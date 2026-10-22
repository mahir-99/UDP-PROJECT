<?php
declare(strict_types=1);

namespace EarthCycle\Services;

/**
 * EarthCycle Gujarat Climate & Seasonal Adaptation Service
 * 
 * Provides dynamic agricultural and biological advice tailored specifically
 * to Gujarat's semi-arid, coastal, and subtropical weather patterns.
 * 
 * @package EarthCycle\Services
 */
class ClimateAdvisorService
{
    /**
     * Determine active season in Gujarat based on current month
     *
     * @param int|null $month Month 1-12
     * @return string 'Summer', 'Monsoon', or 'Winter'
     */
    public static function getCurrentSeason(?int $month = null): string
    {
        $m = $month ?? (int)date('n');

        if ($m >= 3 && $m <= 6) {
            return 'Summer'; // March to June: Scorching dry heat (40-45°C)
        }
        if ($m >= 7 && $m <= 10) {
            return 'Monsoon'; // July to October: High humidity & rainfall
        }
        return 'Winter'; // November to February: Mild, cool nights
    }

    /**
     * Get detailed seasonal protocol for Gujarat home composters
     *
     * @param string|null $season
     * @return array
     */
    public static function getSeasonalAdvisory(?string $season = null): array
    {
        $s = $season ?? self::getCurrentSeason();

        switch ($s) {
            case 'Summer':
                return [
                    'season'        => 'Summer (Greens & Dry Heat)',
                    'temp_range'    => '38°C – 45°C',
                    'humidity'      => '15% – 35%',
                    'main_risk'     => 'Rapid moisture desiccation leading to microbial dormancy and pile death.',
                    'ratio_advice'  => '2:1 Brown-to-Green, with pre-soaked brown materials (neem leaves/coir).',
                    'water_action'  => 'Sprinkle diluted buttermilk (chhas) or aerated water every 3 days. Keep covered with a damp jute sack.',
                    'placement'     => 'North-facing shaded balcony or beneath green shade netting (75% UV block).',
                    'pro_tip'       => 'Never allow the core of the pile to dry like straw; microbes require 50-60% moisture to metabolize.',
                ];

            case 'Monsoon':
                return [
                    'season'        => 'Monsoon (High Humidity & Rain)',
                    'temp_range'    => '28°C – 34°C',
                    'humidity'      => '75% – 95%',
                    'main_risk'     => 'Waterlogging, anaerobic odor (methane/hydrogen sulfide), and fruit fly infestation.',
                    'ratio_advice'  => '3:1 Brown-to-Green (increase dry carbon absorption buffers).',
                    'water_action'  => 'Zero added water! Ensure drain holes at the bottom of terracotta or plastic bins are unblocked.',
                    'placement'     => 'Elevate bin on bricks to prevent standing puddle ingress; protect top with a slanted rain lid.',
                    'pro_tip'       => 'Add a 2-inch cap of shredded dry cardboard or dry neem leaves after every fresh kitchen green addition.',
                ];

            case 'Winter':
            default:
                return [
                    'season'        => 'Winter (Mild & Optimum Digestion)',
                    'temp_range'    => '14°C – 28°C',
                    'humidity'      => '40% – 60%',
                    'main_risk'     => 'Cool night temperatures dropping pile below thermophilic range (below 45°C).',
                    'ratio_advice'  => 'Standard 2:1 Brown-to-Green ratio with nitrogen kickstarters (coffee grounds).',
                    'water_action'  => 'Weekly light misting; moisture retention is optimal in winter.',
                    'placement'     => 'Full solar exposure during daytime hours to boost solar microbial incubation.',
                    'pro_tip'       => 'Turn the pile every 7-10 days to distribute warmth from core to exterior edges.',
                ];
        }
    }
}
