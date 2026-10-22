<?php
declare(strict_types=1);

namespace EarthCycle\Services;

/**
 * EarthCycle Biological Troubleshooting & Diagnostic Engine
 * 
 * Analyzes common composting pile failures (odor, excessive moisture, pest vectors,
 * temperature drops) and prescribes corrective actions for Gujarat conditions.
 * 
 * @package EarthCycle\Services
 */
class TroubleshootingService
{
    /**
     * Diagnose composting problem by symptom key
     *
     * @param string $symptom
     * @return array
     */
    public static function diagnose(string $symptom): array
    {
        $knowledgeBase = [
            'rotten_egg_odor' => [
                'issue'          => 'Anaerobic Hydrogen Sulfide Gas Production',
                'cause'          => 'Excessive waterlogging or compaction depriving aerobic microbes of oxygen.',
                'severity'       => 'High',
                'immediate_step' => 'Turn the pile thoroughly from bottom to top using an aerator tool.',
                'carbon_step'    => 'Incorporate 3 parts dry brown shredded cardboard or dry neem leaves immediately.',
                'gujarat_note'   => 'Common during Gujarat monsoon showers (July–September) when bins receive rain intrusion.',
                'recovery_days'  => 3,
            ],
            'ammonia_odor' => [
                'issue'          => 'Excessive Nitrogen Volatilization',
                'cause'          => 'C:N ratio dropped below 20:1 due to excessive kitchen scraps or fresh grass trimmings.',
                'severity'       => 'Moderate',
                'immediate_step' => 'Do not add any kitchen greens for 5 days.',
                'carbon_step'    => 'Layer 4 inches of dry crushed peepal leaves or untreated wood shavings on top.',
                'gujarat_note'   => 'Often occurs after summer feasts with large watermelon and fruit rind additions.',
                'recovery_days'  => 2,
            ],
            'fruit_flies' => [
                'issue'          => 'Drosophila Melanogaster Fruit Fly Infestation',
                'cause'          => 'Exposed sweet fruit scraps (mango, banana, melon) on the surface of the pile.',
                'severity'       => 'Low (Annoyance, not harmful to compost)',
                'immediate_step' => 'Bury all fresh greens at least 3 inches below the surface.',
                'carbon_step'    => 'Maintain a permanent 2-inch "blanket" of dry coconut coir or dry leaves at the top.',
                'gujarat_note'   => 'Abundant during Gujarat Alphonso and Kesar mango season (April–June).',
                'recovery_days'  => 4,
            ],
            'pile_cold' => [
                'issue'          => 'Microbial Digestion Stagnation',
                'cause'          => 'Either the pile is too dry (<40% moisture) or lacks nitrogen fuel to reach thermophilic range.',
                'severity'       => 'Moderate (Decomposition stops)',
                'immediate_step' => 'Check moisture with the squeeze test: a fistful of compost should feel like a wrung-out sponge.',
                'carbon_step'    => 'If dry, sprinkle diluted buttermilk; if already damp, add 2 cups of used coffee grounds.',
                'gujarat_note'   => 'Frequent in Gujarat winter nights (December–January) when ambient temperatures drop below 15°C.',
                'recovery_days'  => 5,
            ],
            'white_mold' => [
                'issue'          => 'Actinomycetes & Beneficial Fungal Hyphae',
                'cause'          => 'Natural thermophilic breakdown of lignin and woody fibers.',
                'severity'       => 'Beneficial (No action needed)',
                'immediate_step' => 'Celebrate! White thread-like web structures are beneficial Actinobacteria decomposing tough carbon.',
                'carbon_step'    => 'Continue standard 2:1 brown-to-green layering.',
                'gujarat_note'   => 'Indicates healthy soil microbial food webs thriving in your balcony bin.',
                'recovery_days'  => 0,
            ],
        ];

        return $knowledgeBase[$symptom] ?? [
            'issue'          => 'General Composting Imbalance',
            'cause'          => 'Unbalanced moisture, aeration, or green-to-brown stoichiometric ratio.',
            'severity'       => 'Variable',
            'immediate_step' => 'Turn the pile and evaluate moisture balance.',
            'carbon_step'    => 'Add a protective dry brown layer on top.',
            'gujarat_note'   => 'Check EarthCycle Masterclass Phase 5 for full troubleshooting protocols.',
            'recovery_days'  => 3,
        ];
    }

    /**
     * Get all diagnosable symptom keys
     *
     * @return array
     */
    public static function getAllSymptoms(): array
    {
        return [
            'rotten_egg_odor' => 'Rotten egg or sewage smell (Anaerobic / Wet)',
            'ammonia_odor'    => 'Sharp ammonia odor (Excessive Nitrogen)',
            'fruit_flies'     => 'Fruit flies or gnats hovering around lid',
            'pile_cold'       => 'Pile stays cold and not decomposing',
            'white_mold'      => 'White fuzzy web or powdery mold across surface',
        ];
    }
}
