<?php
declare(strict_types=1);

namespace EarthCycle\Services;

/**
 * EarthCycle Liquid Living Compost Tea Brewing Service
 * 
 * Provides brewing recipes, microbial aeration protocols, and dilution formulas
 * for turning mature living compost into high-potency bio-fertilizer foliar sprays.
 * 
 * @package EarthCycle\Services
 */
class CompostTeaService
{
    /**
     * Compute ingredients and schedule for brewing aerated compost tea (ACT)
     *
     * @param float $batchWaterLiters
     * @return array
     */
    public static function calculateBrewRecipe(float $batchWaterLiters = 20.0): array
    {
        $water = max(5.0, min(200.0, $batchWaterLiters));
        $compostGrams = round($water * 50.0); // 50g cured compost per liter of water
        $unsulfuredMolassesMl = round($water * 2.5); // 2.5ml food source per liter
        $kelpMealGrams = round($water * 1.5);

        return [
            'recipe_name'         => 'Aerated Active Compost Tea (AACT)',
            'water_volume'        => "{$water} Liters (dechlorinated rainwater or aerated tap water)",
            'ingredients'         => [
                'cured_compost'    => "{$compostGrams}g of mature living compost or vermicompost",
                'black_molasses'   => "{$unsulfuredMolassesMl}ml unsulfured organic molasses (bacterial food)",
                'kelp_extract'     => "{$kelpMealGrams}g kelp meal or sea humic acid (fungal food)",
            ],
            'bubbling_equipment'  => 'Aquarium air pump with fine-bubble airstone (minimum 0.05 CFM per gallon)',
            'brew_duration_hours' => 24,
            'ideal_brew_temp'     => '18°C – 24°C (brew indoors during Gujarat summer)',
            'shelf_life'          => 'Apply within 4 hours of turning off aeration to prevent anaerobic die-off.',
        ];
    }

    /**
     * Compute dilution application guidelines
     *
     * @param string $applicationType 'foliar_spray' or 'soil_drench'
     * @param float $teaLiters
     * @return array
     */
    public static function getApplicationGuidelines(string $applicationType, float $teaLiters = 1.0): array
    {
        if ($applicationType === 'foliar_spray') {
            $dilutionRatio = '1:5 (1 part tea to 5 parts water)';
            $finalVolume = $teaLiters * 6.0;
            $instruction = 'Filter through cheesecloth to prevent nozzle clogging. Spray at sunrise or sunset to protect microbes from UV rays.';
            $benefit = 'Inoculates leaf phyllosphere surfaces with beneficial bacteria, outcompeting powdery mildew and fungal blights.';
        } else {
            $dilutionRatio = '1:2 (1 part tea to 2 parts water) or full strength';
            $finalVolume = $teaLiters * 3.0;
            $instruction = 'Pour directly around root drip line of potted plants, terrace garden vegetables, or fruit trees.';
            $benefit = 'Colonizes rhizosphere root zone, unlocking phosphorus and micronutrients for fast plant uptake.';
        }

        return [
            'application_type' => $applicationType,
            'concentrate_tea'  => "{$teaLiters} Liters",
            'dilution_ratio'   => $dilutionRatio,
            'final_volume'     => "{$finalVolume} Liters ready to apply",
            'instructions'     => $instruction,
            'biological_benefit' => $benefit,
        ];
    }
}
