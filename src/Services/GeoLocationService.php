<?php
declare(strict_types=1);

namespace EarthCycle\Services;

/**
 * EarthCycle Geographic & Coordinate Service for Gujarat
 * 
 * Manages official municipal presets, bounding boxes, and distance calculations
 * across Gujarat cities.
 * 
 * @package EarthCycle\Services
 */
class GeoLocationService
{
    /**
     * Official center coordinates for Gujarat municipal areas
     *
     * @return array
     */
    public static function getGujaratCityPresets(): array
    {
        return [
            'All'         => ['lat' => 22.2587, 'lng' => 71.1924, 'zoom' => 7],
            'Ahmedabad'   => ['lat' => 23.0225, 'lng' => 72.5714, 'zoom' => 12],
            'Surat'       => ['lat' => 21.1702, 'lng' => 72.8311, 'zoom' => 12],
            'Vadodara'    => ['lat' => 22.3072, 'lng' => 73.1812, 'zoom' => 12],
            'Rajkot'      => ['lat' => 22.3039, 'lng' => 70.8022, 'zoom' => 12],
            'Gandhinagar' => ['lat' => 23.2156, 'lng' => 72.6369, 'zoom' => 12],
            'Bhavnagar'   => ['lat' => 21.7645, 'lng' => 72.1519, 'zoom' => 12],
        ];
    }

    /**
     * Calculate Haversine distance between two sets of GPS coordinates in kilometers
     *
     * @param float $lat1
     * @param float $lng1
     * @param float $lat2
     * @param float $lng2
     * @return float
     */
    public static function calculateDistance(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadius = 6371.0;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return round($earthRadius * $c, 2);
    }
}
