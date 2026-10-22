<?php
declare(strict_types=1);

namespace EarthCycle\Services;

/**
 * EarthCycle Gujarat Agricultural & Composting Calendar Service
 * 
 * Maps traditional Gujarati solar months to biological composting milestones,
 * crop cycles, and municipal leaf drop events.
 * 
 * @package EarthCycle\Services
 */
class SeasonalCalendarService
{
    /**
     * Complete 12-month Gujarat composting almanac
     *
     * @return array
     */
    public static function getAlmanac(): array
    {
        return [
            1 => [
                'month'     => 'January',
                'guj_month' => 'Posh / Maha',
                'season'    => 'Winter Peak',
                'guidance'  => 'Makar Sankranti terrace leaf gathering. Low nocturnal temperatures slow digestion; insulate bin walls.',
                'action'    => 'Turn pile at noon when ambient sun warms outer edges.',
            ],
            2 => [
                'month'     => 'February',
                'guj_month' => 'Maha / Fagan',
                'season'    => 'Late Winter Transition',
                'guidance'  => 'Deciduous neem and peepal trees begin shedding dry brown leaves across Gujarat streets.',
                'action'    => 'Collect and store 4 bags of dry leaves for summer carbon reserve.',
            ],
            3 => [
                'month'     => 'March',
                'guj_month' => 'Fagan / Chaitra',
                'season'    => 'Early Summer Heat',
                'guidance'  => 'Holi bonfire wood ash collection. Temperatures rise to 38°C in Ahmedabad and Rajkot.',
                'action'    => 'Sprinkle max 1 cup sifted wood ash per 20L bin as potassium supplement.',
            ],
            4 => [
                'month'     => 'April',
                'guj_month' => 'Chaitra / Vaishakh',
                'season'    => 'Summer Heatwave',
                'guidance'  => 'Dry ambient air evaporates bin moisture in 48 hours. Microbes risk dehydration.',
                'action'    => 'Move composter to north-facing balcony shade; cap with wet jute burlap.',
            ],
            5 => [
                'month'     => 'May',
                'guj_month' => 'Vaishakh / Jeth',
                'season'    => 'Peak Summer (44°C+)',
                'guidance'  => 'Melon and mango peel abundance. High sugar fruit rinds accelerate fermentation.',
                'action'    => 'Dust mango peels with dry cardboard strips to prevent fruit fly clusters.',
            ],
            6 => [
                'month'     => 'June',
                'guj_month' => 'Jeth / Ashadh',
                'season'    => 'Pre-Monsoon Humidity',
                'guidance'  => 'First monsoon showers (Mrigashira). Relative humidity surges from 20% to 70%.',
                'action'    => 'Elevate bins on cement blocks to prevent flash puddle flooding.',
            ],
            7 => [
                'month'     => 'July',
                'guj_month' => 'Ashadh / Shravan',
                'season'    => 'Monsoon Inundation',
                'guidance'  => 'Torrential rains across Surat and South Gujarat. Danger of anaerobic swamp conditions.',
                'action'    => 'Zero added water. Double brown carbon buffer (3:1 ratio).',
            ],
            8 => [
                'month'     => 'August',
                'guj_month' => 'Shravan / Bhadarvo',
                'season'    => 'Mid Monsoon',
                'guidance'  => 'Janmashtami and festive floral waste abundance. Wet marigold and rose garlands.',
                'action'    => 'Chop marigold stems finely; mix with dry coconut coir before binning.',
            ],
            9 => [
                'month'     => 'September',
                'guj_month' => 'Bhadarvo / Aso',
                'season'    => 'Late Monsoon / Post-Rain Heat',
                'guidance'  => 'High moisture compost cured during monsoon is ready for preliminary sieving.',
                'action'    => 'Harvest leachate (liquid compost tea) from spigot tap and dilute 1:10.',
            ],
            10 => [
                'month'     => 'October',
                'guj_month' => 'Aso / Kartak',
                'season'    => 'Navratri Autumn Harvest',
                'guidance'  => 'Optimum outdoor conditions for terrace soil preparation for winter vegetables.',
                'action'    => 'Blend 30% cured living compost into terrace pot potting mix.',
            ],
            11 => [
                'month'     => 'November',
                'guj_month' => 'Kartak / Magshar',
                'season'    => 'Early Winter / Diwali Garden Prep',
                'guidance'  => 'Festive cleaning yields shredded cardboard packaging and dried temple flowers.',
                'action'    => 'Soak shredded delivery boxes and layer with kitchen greens.',
            ],
            12 => [
                'month'     => 'December',
                'guj_month' => 'Magshar / Posh',
                'season'    => 'Winter Digestion',
                'guidance'  => 'Crisp sunny mornings across Gujarat. Thermophilic bacteria thrive in solar bins.',
                'action'    => 'Add used coffee grounds to give the pile an internal thermophilic heat spike.',
            ],
        ];
    }

    /**
     * Get guidance for the current calendar month
     *
     * @return array
     */
    public static function getCurrentMonthAlmanac(): array
    {
        $m = (int)date('n');
        $almanac = self::getAlmanac();
        return $almanac[$m] ?? $almanac[1];
    }
}
