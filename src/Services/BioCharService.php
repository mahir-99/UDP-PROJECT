<?php
declare(strict_types=1);

namespace EarthCycle\Services;

/**
 * EarthCycle Activated Biochar & Carbon Sequestration Service
 * 
 * Provides scientific recipes for inoculating (charging) horticultural biochar
 * with liquid compost tea and organic microbial cultures before integration into Gujarat soils.
 * 
 * @package EarthCycle\Services
 */
class BioCharService
{
    /**
     * Compute biochar charging (activation) recipe
     *
     * Raw biochar is sterile and highly absorbent; if added directly to soil,
     * it temporarily robs plants of nitrogen and moisture. It must first be "charged".
     *
     * @param float $rawBiocharKg
     * @return array
     */
    public static function calculateChargingRecipe(float $rawBiocharKg = 10.0): array
    {
        $biochar = max(1.0, min(500.0, $rawBiocharKg));
        $compostTeaLiters = round($biochar * 1.5, 1);
        $matureCompostKg = round($biochar * 1.0, 1);
        $cowDungSlurryLiters = round($biochar * 0.5, 1);

        return [
            'raw_biochar_mass'     => "{$biochar} kg of crushed agricultural biochar (2-5mm grain size)",
            'activation_agents'    => [
                'active_compost_tea' => "{$compostTeaLiters} Liters of aerated living compost tea",
                'mature_compost'     => "{$matureCompostKg} kg of finished living humus compost",
                'cow_dung_slurry'    => "{$cowDungSlurryLiters} Liters of diluted fresh cow dung slurry (Jeevamrutha)",
            ],
            'charging_duration_days' => 14,
            'moisture_target'        => 'Keep mixture at 60% moisture under burlap shade.',
            'soil_application_rate'  => '5% to 10% by volume in garden beds and terrace pots.',
            'carbon_sequestration'   => 'Locks stable biological carbon in Gujarat soil for 500+ years.',
        ];
    }

    /**
     * Calculate permanent carbon sequestration from biochar additions
     *
     * @param float $biocharKg
     * @return array
     */
    public static function calculateCarbonOffset(float $biocharKg): array
    {
        // 1 kg pure carbon biochar equates to ~2.9 kg CO2 removed from active atmospheric carbon cycle
        $co2eSequestrationKg = round($biocharKg * 2.9, 1);

        return [
            'biochar_applied_kg'   => $biocharKg,
            'co2e_sequestered_kg'  => $co2eSequestrationKg,
            'soil_porosity_boost'  => '+25% water holding capacity in sandy/semi-arid Gujarat loam soils',
            'cation_exchange'      => 'Significant increase in CEC (Cation Exchange Capacity) preventing nutrient leaching',
        ];
    }
}
