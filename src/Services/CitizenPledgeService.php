<?php
declare(strict_types=1);

namespace EarthCycle\Services;

/**
 * EarthCycle Citizen Composting Pledge & Soil Commitment Service
 * 
 * Records, validates, and manages public sustainability commitments made by Gujarat citizens,
 * generating unique pledge certificates and community impact metrics.
 * 
 * @package EarthCycle\Services
 */
class CitizenPledgeService
{
    /**
     * Create a structured citizen pledge record
     *
     * @param string $citizenName
     * @param string $city
     * @param float $pledgedWeeklyKg
     * @return array
     */
    public static function createPledge(string $citizenName, string $city, float $pledgedWeeklyKg = 7.0): array
    {
        $kg = max(1.0, min(50.0, $pledgedWeeklyKg));
        $impact = ImpactCalculatorService::calculate($kg);
        $pledgeId = 'PLG-' . strtoupper(substr(hash('crc32b', $citizenName . $city . time()), 0, 8));

        return [
            'pledge_id'            => $pledgeId,
            'citizen_name'         => trim($citizenName),
            'city'                 => trim($city),
            'weekly_kg'            => $kg,
            'annual_waste_divert'  => "{$impact['annual_waste_kg']} kg",
            'annual_humus_yield'   => "{$impact['compost_harvested_kg']} kg",
            'co2e_avoided'         => "{$impact['co2_avoided_kg']} kg",
            'pledge_date'          => date('Y-m-d H:i:s'),
            'pledge_text'          => "I solemnly pledge to segregate organic kitchen peels, practice 2:1 brown-to-green composting, and restore the living soils of {$city}, Gujarat.",
        ];
    }
}
