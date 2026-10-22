<?php
declare(strict_types=1);

namespace EarthCycle\Tests;

use EarthCycle\Services\BatchMixOptimizerService;

class BatchMixOptimizerTest
{
    public static function run(): array
    {
        $tests = 0;
        $passed = 0;

        // Test 1: Balanced batch
        $tests++;
        $batch = [
            ['weight_kg' => 2.0, 'carbon_ratio' => 20.0, 'nitrogen_pct' => 2.0], // greens
            ['weight_kg' => 4.0, 'carbon_ratio' => 40.0, 'nitrogen_pct' => 1.0], // browns
        ];
        $res = BatchMixOptimizerService::analyzeBatch($batch);
        if ($res['effective_cn'] >= 25.0 && $res['effective_cn'] <= 35.0) {
            $passed++;
        }

        // Test 2: High nitrogen detection
        $tests++;
        $highN = [
            ['weight_kg' => 10.0, 'carbon_ratio' => 12.0, 'nitrogen_pct' => 3.0],
        ];
        $resHigh = BatchMixOptimizerService::analyzeBatch($highN);
        if (strpos($resHigh['status'], 'High Nitrogen') !== false) {
            $passed++;
        }

        return ['name' => 'BatchMixOptimizerTest', 'tests' => $tests, 'passed' => $passed];
    }
}
