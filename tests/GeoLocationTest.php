<?php
declare(strict_types=1);

namespace EarthCycle\Tests;

use EarthCycle\Services\GeoLocationService;
use EarthCycle\Services\SecurityService;

class GeoLocationTest
{
    public static function run(): array
    {
        $tests = 0;
        $passed = 0;

        // Test 1: Presets contain Ahmedabad and Surat
        $tests++;
        $presets = GeoLocationService::getGujaratCityPresets();
        if (isset($presets['Ahmedabad']) && isset($presets['Surat']) && isset($presets['Vadodara'])) {
            $passed++;
        }

        // Test 2: Distance between Ahmedabad and Gandhinagar ~25 km
        $tests++;
        $dist = GeoLocationService::calculateDistance(23.0225, 72.5714, 23.2156, 72.6369);
        if ($dist >= 20.0 && $dist <= 30.0) {
            $passed++;
        }

        return ['name' => 'GeoLocationTest', 'tests' => $tests, 'passed' => $passed];
    }
}
