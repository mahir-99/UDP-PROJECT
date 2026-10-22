<?php
declare(strict_types=1);

namespace EarthCycle\Helpers;

/**
 * EarthCycle Data Formatting Helper
 * 
 * Provides utility methods for formatting weights, percentages, ratings,
 * dates, and human-readable time intervals.
 * 
 * @package EarthCycle\Helpers
 */
class Format
{
    /**
     * Format mass in kg with appropriate unit (kg or Tonnes)
     *
     * @param float $kg
     * @return string
     */
    public static function weight(float $kg): string
    {
        if ($kg >= 1000) {
            return round($kg / 1000.0, 1) . ' T';
        }
        return round($kg, 1) . ' kg';
    }

    /**
     * Format star rating display (e.g. "★★★★★" or numerical "5.0 / 5")
     *
     * @param int|float $rating
     * @return string
     */
    public static function stars(int|float $rating): string
    {
        $r = max(1, min(5, (int)round((float)$rating)));
        return str_repeat('★', $r) . str_repeat('☆', 5 - $r);
    }

    /**
     * Format relative date from timestamp (e.g., "Just now", "2 days ago")
     *
     * @param string|int $timestamp
     * @return string
     */
    public static function relativeTime(string|int $timestamp): string
    {
        $time = is_numeric($timestamp) ? (int)$timestamp : strtotime($timestamp);
        if (!$time) {
            return 'Recently';
        }

        $diff = time() - $time;
        if ($diff < 60) {
            return 'Just now';
        }
        if ($diff < 3600) {
            $mins = max(1, (int)floor($diff / 60));
            return $mins === 1 ? '1 minute ago' : "{$mins} minutes ago";
        }
        if ($diff < 86400) {
            $hours = (int)floor($diff / 3600);
            return $hours === 1 ? '1 hour ago' : "{$hours} hours ago";
        }
        if ($diff < 604800) {
            $days = (int)floor($diff / 86400);
            return $days === 1 ? '1 day ago' : "{$days} days ago";
        }

        return date('j M Y', $time);
    }

    /**
     * Format Indian Rupee currency display
     *
     * @param float|int $amount
     * @return string
     */
    public static function inr(float|int $amount): string
    {
        return '₹' . number_format((float)$amount, 0);
    }
}
