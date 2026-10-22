<?php
declare(strict_types=1);

namespace EarthCycle\Tests;

use EarthCycle\Services\TroubleshootingService;
use EarthCycle\Services\SoilBiologyService;
use EarthCycle\Services\CommunityLeaderboardService;

class TroubleshootingTest
{
    public static function run(): array
    {
        $tests = 0;
        $passed = 0;

        // Test 1: Rotten egg odor diagnostic
        $tests++;
        $diag = TroubleshootingService::diagnose('rotten_egg_odor');
        if (strpos($diag['issue'], 'Hydrogen Sulfide') !== false && $diag['recovery_days'] === 3) {
            $passed++;
        }

        // Test 2: Thermophilic stage
        $tests++;
        $stage = SoilBiologyService::getMicrobialStage(55.0);
        if (strpos($stage['stage'], 'Thermophilic') !== false) {
            $passed++;
        }

        // Test 3: Citizen rank computation
        $tests++;
        $rank = CommunityLeaderboardService::computeCitizenRank(600.0, 6);
        if ($rank['title'] === 'Living Soil Champion' && $rank['level'] === 4) {
            $passed++;
        }

        return ['name' => 'TroubleshootingTest', 'tests' => $tests, 'passed' => $passed];
    }
}
