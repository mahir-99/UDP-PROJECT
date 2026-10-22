<?php
declare(strict_types=1);

namespace EarthCycle\Helpers;

/**
 * EarthCycle Date and Gujarati Calendar Helper
 * 
 * Provides localized date string generation, relative time parsing,
 * and Gujarati month name representations.
 * 
 * @package EarthCycle\Helpers
 */
class DateHelper
{
    private static array $gujaratiMonths = [
        1  => ['name' => 'Posh / Maha',     'season' => 'Shishir (Winter)'],
        2  => ['name' => 'Maha / Fagan',    'season' => 'Shishir (Winter)'],
        3  => ['name' => 'Fagan / Chaitra', 'season' => 'Vasant (Spring)'],
        4  => ['name' => 'Chaitra / Vaisakh','season' => 'Grishma (Summer)'],
        5  => ['name' => 'Vaisakh / Jeth',  'season' => 'Grishma (Summer)'],
        6  => ['name' => 'Jeth / Ashadh',   'season' => 'Varsha (Monsoon)'],
        7  => ['name' => 'Ashadh / Shravan','season' => 'Varsha (Monsoon)'],
        8  => ['name' => 'Shravan / Bhadarvo','season' => 'Varsha (Monsoon)'],
        9  => ['name' => 'Bhadarvo / Aso',  'season' => 'Sharad (Autumn)'],
        10 => ['name' => 'Aso / Kartak',    'season' => 'Sharad (Autumn)'],
        11 => ['name' => 'Kartak / Magshar','season' => 'Hemant (Pre-Winter)'],
        12 => ['name' => 'Magshar / Posh',  'season' => 'Hemant (Pre-Winter)'],
    ];

    /**
     * Get active Gujarati calendar season information
     *
     * @param int|null $month
     * @return array
     */
    public static function getGujaratiMonthInfo(?int $month = null): array
    {
        $m = $month ?? (int)date('n');
        return self::$gujaratiMonths[$m] ?? self::$gujaratiMonths[1];
    }

    /**
     * Format timestamp to Indian standard display (DD-MM-YYYY HH:MM)
     *
     * @param string|int $timestamp
     * @return string
     */
    public static function formatIndianDateTime(string|int $timestamp): string
    {
        $ts = is_numeric($timestamp) ? (int)$timestamp : strtotime((string)$timestamp);
        return date('d/m/Y h:i A', $ts ?: time());
    }
}
