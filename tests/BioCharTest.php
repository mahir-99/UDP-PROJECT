<?php
declare(strict_types=1);

namespace EarthCycle\Tests;

use EarthCycle\Services\BioCharService;
use EarthCycle\Services\CitizenPledgeService;

class BioCharTest
{
    public static function run(): array
    {
        $tests = 0;
        $passed = 0;

        // Test 1: Biochar charging recipe
        $tests++;
        $rec = BioCharService::calculateChargingRecipe(10.0);
        if ($rec['charging_duration_days'] === 14 && strpos($rec['activation_agents']['active_compost_tea'], '15 Liters') !== false) {
            $passed++;
        }

        // Test 2: Biochar carbon offset calculation
        $tests++;
        $offset = BioCharService::calculateCarbonOffset(10.0);
        if ($offset['co2e_sequestered_kg'] === 29.0) {
            $passed++;
        }

        // Test 3: Citizen pledge generation
        $tests++;
        $plg = CitizenPledgeService::createPledge('Rajesh Varma', 'Rajkot', 5.0);
        if (strpos($plg['pledge_id'], 'PLG-') === 0 && $plg['city'] === 'Rajkot') {
            $passed++;
        }

        return ['name' => 'BioCharTest', 'tests' => $tests, 'passed' => $passed];
    }
}
