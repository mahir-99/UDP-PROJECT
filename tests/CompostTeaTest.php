<?php
declare(strict_types=1);

namespace EarthCycle\Tests;

use EarthCycle\Services\CompostTeaService;
use EarthCycle\Services\VermicompostingService;
use EarthCycle\Services\CommunityDropOffService;

class CompostTeaTest
{
    public static function run(): array
    {
        $tests = 0;
        $passed = 0;

        // Test 1: Compost tea recipe calculation
        $tests++;
        $rec = CompostTeaService::calculateBrewRecipe(20.0);
        if ($rec['brew_duration_hours'] === 24 && strpos($rec['ingredients']['cured_compost'], '1000g') !== false) {
            $passed++;
        }

        // Test 2: Vermicompost worm requirement
        $tests++;
        $worm = VermicompostingService::calculateWormRequirements(1.0);
        if (strpos($worm['required_worm_biomass'], '2 kg') !== false) {
            $passed++;
        }

        // Test 3: Worm food safety check (citrus)
        $tests++;
        $citrusCheck = VermicompostingService::checkWormFoodSafety('Lemon and orange citrus peels');
        if ($citrusCheck['is_safe'] === false) {
            $passed++;
        }

        // Test 4: Municipal drop-off checklist count
        $tests++;
        $checklist = CommunityDropOffService::getDropOffChecklist();
        if (count($checklist) === 5) {
            $passed++;
        }

        return ['name' => 'CompostTeaTest', 'tests' => $tests, 'passed' => $passed];
    }
}
