<?php
declare(strict_types=1);

namespace EarthCycle\Services;

/**
 * EarthCycle Terrace Gardening & Vegetable Soil Prescription Service
 * 
 * Provides botanical living compost blending ratios for popular Gujarati crops
 * (Ringan/Brinjal, Bhindi/Okra, Tameta/Tomato, Marcha/Chili, Methi/Fenugreek).
 * 
 * @package EarthCycle\Services
 */
class SeasonalCropService
{
    /**
     * Get living compost blend prescription for specific vegetable
     *
     * @param string $cropName
     * @return array
     */
    public static function getCropSoilPrescription(string $cropName): array
    {
        $crops = [
            'brinjal' => [
                'name_en'            => 'Brinjal / Eggplant',
                'name_gu'            => 'Ringan (રીંગણ)',
                'compost_blend_pct'  => '30% Cured Living Compost, 40% Red Soil, 30% Coconut Coir',
                'feed_requirements'  => 'Heavy feeder requiring balanced nitrogen and potassium for abundant fruit set.',
                'ideal_planting'     => 'June–July (Monsoon) and October–November (Winter)',
                'foliar_tea_cycle'   => 'Apply diluted aerated compost tea (1:5) every 14 days after flower initiation.',
            ],
            'okra' => [
                'name_en'            => 'Okra / Ladyfinger',
                'name_gu'            => 'Bhindi (ભીંડી)',
                'compost_blend_pct'  => '25% Cured Compost, 50% Loam Soil, 25% Sand/Coir',
                'feed_requirements'  => 'Moderate nitrogen; excessive nitrogen causes leafy growth with reduced pod count.',
                'ideal_planting'     => 'February–March (Summer) and June–July (Monsoon)',
                'foliar_tea_cycle'   => 'Monthly soil drench with compost leachate around root base.',
            ],
            'tomato' => [
                'name_en'            => 'Tomato',
                'name_gu'            => 'Tameta (ટામેટા)',
                'compost_blend_pct'  => '35% Cured Compost with crushed eggshell powder (calcium), 40% Soil, 25% Coir',
                'feed_requirements'  => 'High calcium demand to prevent Blossom End Rot during hot Gujarat dry spells.',
                'ideal_planting'     => 'September–November (Winter crop)',
                'foliar_tea_cycle'   => 'Foliar spray weekly at sunrise to build biological shield against leaf blight.',
            ],
            'chili' => [
                'name_en'            => 'Green Chili',
                'name_gu'            => 'Lila Marcha (લીલા મરચા)',
                'compost_blend_pct'  => '25% Cured Living Compost, 45% Red Soil, 30% Perlite/Coir',
                'feed_requirements'  => 'Requires excellent drainage; roots rot quickly in heavy waterlogged soils.',
                'ideal_planting'     => 'Throughout the year, peak flowering in October–February',
                'foliar_tea_cycle'   => 'Bi-weekly misting with diluted vermiwash or compost tea.',
            ],
            'fenugreek' => [
                'name_en'            => 'Fenugreek Greens',
                'name_gu'            => 'Methi (મેથી)',
                'compost_blend_pct'  => '40% Living Compost, 40% Garden Soil, 20% Sand',
                'feed_requirements'  => 'Legume that fixes atmospheric nitrogen; living compost inoculates Rhizobium bacteria.',
                'ideal_planting'     => 'October–December (Winter terrace trays)',
                'foliar_tea_cycle'   => 'Light soil misting once a week; ready to harvest tender leaves in 21 days.',
            ],
        ];

        $key = strtolower(trim($cropName));
        return $crops[$key] ?? $crops['tomato'];
    }

    /**
     * Get list of all supported Gujarat terrace garden vegetables
     *
     * @return array
     */
    public static function getSupportedCrops(): array
    {
        return [
            'tomato'    => 'Tomato (ટામેટા)',
            'brinjal'   => 'Brinjal (રીંગણ)',
            'okra'      => 'Okra (ભીંડી)',
            'chili'     => 'Green Chili (મરચા)',
            'fenugreek' => 'Fenugreek (મેથી)',
        ];
    }
}
