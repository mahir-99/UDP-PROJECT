<?php
declare(strict_types=1);

namespace EarthCycle\Tests;

use EarthCycle\Services\MicrobeCultureService;

class MicrobeCultureTest
{
    public static function run(): array
    {
        $tests = 0;
        $passed = 0;

        // Test 1: Chhas recipe dilution
        $tests++;
        $rec = MicrobeCultureService::calculateChhasRecipe(100.0);
        if ($rec['fermentation_hrs'] === 24 && strpos($rec['ingredients']['sour_buttermilk'], '2 Liters') !== false) {
            $passed++;
        }

        // Test 2: Bokashi dosage
        $tests++;
        $bok = MicrobeCultureService::calculateBokashiDosage(4.0);
        if (strpos($bok['bran_dosage'], 'tablespoons') !== false) {
            $passed++;
        }

        return ['name' => 'MicrobeCultureTest', 'tests' => $tests, 'passed' => $passed];
    }
}
