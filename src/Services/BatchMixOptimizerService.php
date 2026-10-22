<?php
declare(strict_types=1);

namespace EarthCycle\Services;

/**
 * EarthCycle Organic C:N Ratio & Batch Optimizer Service
 * 
 * Computes chemical stoichiometry and stoichiometric carbon-to-nitrogen ratios
 * for composting batches, ensuring the pile falls within the optimal 25:1 to 30:1 range.
 * 
 * @package EarthCycle\Services
 */
class BatchMixOptimizerService
{
    /**
     * Compute composite C:N ratio from an array of material inputs
     * 
     * Each input: ['carbon_ratio' => float, 'weight_kg' => float, 'nitrogen_pct' => float]
     *
     * @param array $inputs
     * @return array
     */
    public static function analyzeBatch(array $inputs): array
    {
        $totalWeight = 0.0;
        $totalCarbon = 0.0;
        $totalNitrogen = 0.0;

        foreach ($inputs as $item) {
            $weight = (float)($item['weight_kg'] ?? 1.0);
            $cn = (float)($item['carbon_ratio'] ?? 25.0);
            $nPercent = (float)($item['nitrogen_pct'] ?? 1.5);

            $nitrogen = $weight * ($nPercent / 100.0);
            $carbon = $nitrogen * $cn;

            $totalWeight += $weight;
            $totalCarbon += $carbon;
            $totalNitrogen += $nitrogen;
        }

        $effectiveRatio = $totalNitrogen > 0 ? round($totalCarbon / $totalNitrogen, 1) : 30.0;

        $status = 'Balanced';
        $recommendation = 'Your current mix is within the ideal 25:1 - 30:1 composting biological window.';

        if ($effectiveRatio < 20.0) {
            $status = 'High Nitrogen (Risk of Ammonia Odor)';
            $extraBrownsNeeded = round(($totalNitrogen * 30.0 - $totalCarbon) / 0.5, 1);
            $recommendation = "Add approximately {$extraBrownsNeeded} kg of dry brown carbon materials (sawdust, dry neem leaves, shredded cardboard).";
        } elseif ($effectiveRatio > 40.0) {
            $status = 'High Carbon (Slow Decomposition)';
            $extraGreensNeeded = round(($totalCarbon / 30.0 - $totalNitrogen) / 0.02, 1);
            $recommendation = "Add approximately {$extraGreensNeeded} kg of fresh nitrogen greens (fruit/vegetable scraps, green grass, tea grounds).";
        }

        return [
            'total_weight_kg'  => round($totalWeight, 2),
            'effective_cn'     => $effectiveRatio,
            'status'           => $status,
            'recommendation'   => $recommendation,
            'ideal_range'      => '25:1 – 30:1',
        ];
    }
}
