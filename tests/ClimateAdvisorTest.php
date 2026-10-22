<?php
declare(strict_types=1);

namespace EarthCycle\Tests;

use EarthCycle\Services\ClimateAdvisorService;

class ClimateAdvisorTest
{
    public static function run(): array
    {
        $tests = 0;
        $passed = 0;

        // Test 1: Summer season determination (May = Month 5)
        $tests++;
        if (ClimateAdvisorService::getCurrentSeason(5) === 'Summer') {
            $passed++;
        }

        // Test 2: Monsoon season determination (August = Month 8)
        $tests++;
        if (ClimateAdvisorService::getCurrentSeason(8) === 'Monsoon') {
            $passed++;
        }

        // Test 3: Winter season determination (January = Month 1)
        $tests++;
        if (ClimateAdvisorService::getCurrentSeason(1) === 'Winter') {
            $passed++;
        }

        // Test 4: Summer advisory content
        $tests++;
        $summer = ClimateAdvisorService::getSeasonalAdvisory('Summer');
        if (strpos($summer['temp_range'], '45°C') !== false) {
            $passed++;
        }

        return ['name' => 'ClimateAdvisorTest', 'tests' => $tests, 'passed' => $passed];
    }
}
