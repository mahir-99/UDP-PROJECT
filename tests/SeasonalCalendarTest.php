<?php
declare(strict_types=1);

namespace EarthCycle\Tests;

use EarthCycle\Services\SeasonalCalendarService;

class SeasonalCalendarTest
{
    public static function run(): array
    {
        $tests = 0;
        $passed = 0;

        // Test 1: Full 12 months present
        $tests++;
        $almanac = SeasonalCalendarService::getAlmanac();
        if (count($almanac) === 12) {
            $passed++;
        }

        // Test 2: Month 5 (May) peak summer check
        $tests++;
        if (strpos($almanac[5]['season'], 'Summer') !== false) {
            $passed++;
        }

        return ['name' => 'SeasonalCalendarTest', 'tests' => $tests, 'passed' => $passed];
    }
}
