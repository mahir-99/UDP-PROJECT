<?php
declare(strict_types=1);

namespace EarthCycle\Tests;

use EarthCycle\Services\SeasonalCropService;

class SeasonalCropTest
{
    public static function run(): array
    {
        $tests = 0;
        $passed = 0;

        // Test 1: Brinjal prescription
        $tests++;
        $brinjal = SeasonalCropService::getCropSoilPrescription('brinjal');
        if (strpos($brinjal['name_gu'], 'Ringan') !== false && strpos($brinjal['compost_blend_pct'], '30%') !== false) {
            $passed++;
        }

        // Test 2: Supported crops list
        $tests++;
        $crops = SeasonalCropService::getSupportedCrops();
        if (count($crops) === 5 && isset($crops['fenugreek'])) {
            $passed++;
        }

        return ['name' => 'SeasonalCropTest', 'tests' => $tests, 'passed' => $passed];
    }
}
