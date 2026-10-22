<?php
declare(strict_types=1);

namespace EarthCycle\Tests;

use EarthCycle\Services\ImpactCalculatorService;

class ImpactCalculatorTest
{
    public static function run(): array
    {
        $tests = 0;
        $passed = 0;

        // Test 1: Standard 7 kg/wk household
        $tests++;
        $res = ImpactCalculatorService::calculate(7.0);
        if ($res['annual_waste_kg'] === 364 && $res['compost_harvested_kg'] === 127 && $res['co2_avoided_kg'] === 335) {
            $passed++;
        }

        // Test 2: Low bounds clamping
        $tests++;
        $resLow = ImpactCalculatorService::calculate(0.1);
        if ($resLow['weekly_kg'] === 0.5) {
            $passed++;
        }

        // Test 3: High bounds clamping
        $tests++;
        $resHigh = ImpactCalculatorService::calculate(200.0);
        if ($resHigh['weekly_kg'] === 100.0) {
            $passed++;
        }

        // Test 4: Community aggregate
        $tests++;
        $comm = ImpactCalculatorService::calculateCommunityAggregate(100, 7.0);
        if ($comm['households'] === 100 && $comm['annual_waste_tonnes'] === 36.4) {
            $passed++;
        }

        return ['name' => 'ImpactCalculatorTest', 'tests' => $tests, 'passed' => $passed];
    }
}
