<?php
declare(strict_types=1);

namespace EarthCycle\Services;

/**
 * EarthCycle Domestic & Community Vermicomposting Service
 * 
 * Manages biological husbandry for Eisenia fetida (Red Wiggler) earthworms,
 * calculates daily feeding capacities, bedding moisture thresholds, and harvesting schedules.
 * 
 * @package EarthCycle\Services
 */
class VermicompostingService
{
    /**
     * Compute vermicompost bin sizing and worm biomass requirements
     *
     * @param float $dailyKitchenGreensKg
     * @return array
     */
    public static function calculateWormRequirements(float $dailyKitchenGreensKg = 0.5): array
    {
        $dailyKg = max(0.1, min(10.0, $dailyKitchenGreensKg));
        // Eisenia fetida can consume approximately 50% of their body weight per day
        $requiredWormBiomassKg = round($dailyKg * 2.0, 2);
        // Approx 1,000 worms per 500g
        $estimatedWormCount = (int)round($requiredWormBiomassKg * 2000);
        $binSurfaceSqFt = round($dailyKg * 2.0, 1); // 1 sq ft per 0.5kg waste per day

        return [
            'daily_waste_input'     => "{$dailyKg} kg/day of kitchen fruit & vegetable discards",
            'required_worm_biomass' => "{$requiredWormBiomassKg} kg of live Eisenia fetida",
            'estimated_worm_count'  => "Approximately {$estimatedWormCount} red wigglers",
            'recommended_bin_area'  => "{$binSurfaceSqFt} sq ft surface area",
            'bedding_type'          => 'Pre-soaked shredded brown corrugated cardboard and damp coconut coir',
            'bedding_moisture'      => '70% – 80% (feels like a wet sponge with 1-2 drops when squeezed firmly)',
            'temperature_range'     => '15°C – 28°C (keep in cool shade or indoors during Gujarat heatwaves)',
            'harvest_cycle_months'  => 3,
        ];
    }

    /**
     * Worm safety food compatibility check
     *
     * @param string $foodItem
     * @return array
     */
    public static function checkWormFoodSafety(string $foodItem): array
    {
        $safeGreens = [
            'banana peels', 'apple cores', 'melon rinds', 'gourd peels',
            'cucumber skins', 'used tea leaves', 'coffee grounds', 'crushed eggshells',
            'spinach stems', 'coriander roots', 'soaked oats'
        ];

        $toxicItems = [
            'citrus peels', 'lemon', 'orange', 'onions', 'garlic', 'chili peppers',
            'spicy food', 'dairy', 'cheese', 'oil', 'cooked food', 'meat', 'dog feces'
        ];

        $lower = strtolower(trim($foodItem));

        foreach ($toxicItems as $toxic) {
            if (strpos($lower, $toxic) !== false) {
                return [
                    'item'       => $foodItem,
                    'is_safe'    => false,
                    'status'     => 'Toxic / Harmful to Worms',
                    'reason'     => 'Contains acidic d-limonene, allicin, or capsaicin that irritates worm epidermal skin.',
                    'action'     => 'Keep out of worm bin; compost in regular aerobic compost pile or municipal drop-off.',
                ];
            }
        }

        return [
            'item'       => $foodItem,
            'is_safe'    => true,
            'status'     => 'Safe Worm Food',
            'reason'     => 'Excellent organic matter easily softened by microbial biofilms for worm ingestion.',
            'action'     => 'Chop small and bury beneath damp bedding.',
        ];
    }
}
