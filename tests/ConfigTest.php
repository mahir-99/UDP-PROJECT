<?php
declare(strict_types=1);

namespace EarthCycle\Tests;

use EarthCycle\Services\ConfigService;
use EarthCycle\Services\NotificationService;

class ConfigTest
{
    public static function run(): array
    {
        $tests = 0;
        $passed = 0;

        // Test 1: Config dot notation
        $tests++;
        $appName = ConfigService::get('app.name');
        if (strpos($appName, 'EarthCycle') !== false) {
            $passed++;
        }

        // Test 2: Database default host
        $tests++;
        $dbHost = ConfigService::get('database.host');
        if (!empty($dbHost)) {
            $passed++;
        }

        // Test 3: Flash notification
        $tests++;
        NotificationService::flash('success', 'Compost test verified');
        $flashes = NotificationService::getFlashes();
        if (count($flashes) === 1 && $flashes[0]['message'] === 'Compost test verified') {
            $passed++;
        }

        return ['name' => 'ConfigTest', 'tests' => $tests, 'passed' => $passed];
    }
}
