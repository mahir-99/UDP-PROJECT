<?php
declare(strict_types=1);

namespace EarthCycle\Services;

/**
 * EarthCycle Environmental Impact Calculator Service
 * 
 * Implements scientific organic conversion algorithms:
 * - Waste diversion: kg/week * 52 weeks = annual organic diversion
 * - Living humus compost yield: 35% of total input mass (due to moisture evaporation & respiration)
 * - Methane avoidance & CO2 equivalent: 0.92 kg CO2e avoided per 1 kg organic waste kept out of landfills
 * - Urban tree seedling equivalent: 21 kg CO2 absorbed per urban shade tree per year
 * 
 * @package EarthCycle\Services
 */
class ImpactCalculatorService
{
    public const WEEKS_PER_YEAR = 52;
    public const COMPOST_CONVERSION_RATE = 0.35;
    public const CO2E_FACTOR_PER_KG = 0.92;
    public const TREE_ABSORPTION_FACTOR_KG = 21.0;

    /**
     * Compute full environmental impact metrics from weekly organic waste mass (in kg)
     *
     * @param float $weeklyKg
     * @return array
     */
    public static function calculate(float $weeklyKg): array
    {
        $kg = max(0.5, min(100.0, $weeklyKg));
        $annualKg = $kg * self::WEEKS_PER_YEAR;

        $compostHarvestKg = (int)round($annualKg * self::COMPOST_CONVERSION_RATE);
        $co2AvoidedKg = (int)round($annualKg * self::CO2E_FACTOR_PER_KG);
        $treesEquivalent = round($co2AvoidedKg / self::TREE_ABSORPTION_FACTOR_KG, 1);

        return [
            'weekly_kg'            => $kg,
            'annual_waste_kg'      => (int)round($annualKg),
            'compost_harvested_kg' => $compostHarvestKg,
            'co2_avoided_kg'       => $co2AvoidedKg,
            'trees_equivalent'     => $treesEquivalent,
            'badge'                => "{$kg} kg/wk",
            'formatted'            => [
                'weekly'  => "{$kg} kg",
                'harvest' => "{$compostHarvestKg} kg",
                'co2'     => "{$co2AvoidedKg} kg",
                'trees'   => (string)$treesEquivalent,
            ]
        ];
    }

    /**
     * Calculate aggregate impact across a given number of Gujarat participating households
     *
     * @param int $householdCount
     * @param float $averageWeeklyKg
     * @return array
     */
    public static function calculateCommunityAggregate(int $householdCount, float $averageWeeklyKg = 7.0): array
    {
        $single = self::calculate($averageWeeklyKg);
        $totalAnnualTonnes = ($single['annual_waste_kg'] * $householdCount) / 1000.0;
        $totalCompostTonnes = ($single['compost_harvested_kg'] * $householdCount) / 1000.0;
        $totalCo2Tonnes = ($single['co2_avoided_kg'] * $householdCount) / 1000.0;
        $totalTrees = round($single['trees_equivalent'] * $householdCount);

        return [
            'households'           => $householdCount,
            'annual_waste_tonnes'  => round($totalAnnualTonnes, 1),
            'compost_yield_tonnes' => round($totalCompostTonnes, 1),
            'co2_avoided_tonnes'   => round($totalCo2Tonnes, 1),
            'trees_equivalent'     => (int)$totalTrees,
        ];
    }
}
