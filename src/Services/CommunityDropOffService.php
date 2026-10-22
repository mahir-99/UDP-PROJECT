<?php
declare(strict_types=1);

namespace EarthCycle\Services;

/**
 * EarthCycle Municipal Drop-Off & Citizen Waste Logistics Service
 * 
 * Manages protocol checklists, container hygiene, transport safety, and volunteer drop-off
 * guidelines for citizens utilizing Gujarat's 12 municipal composting facilities.
 * 
 * @package EarthCycle\Services
 */
class CommunityDropOffService
{
    /**
     * Get official municipal drop-off citizen checklist
     *
     * @return array
     */
    public static function getDropOffChecklist(): array
    {
        return [
            'pre_sorting' => [
                'step_number' => 1,
                'title'       => 'Strict Source Segregation at Home',
                'description' => 'Separate wet kitchen scraps from all plastic bags, rubber bands, produce stickers, and metal twist ties before collecting.',
                'critical_rule' => 'Zero single-use plastic bags allowed inside municipal bio-compost reception hoppers.',
            ],
            'storage_caddy' => [
                'step_number' => 2,
                'title'       => 'Airtight Countertop Caddy Storage',
                'description' => 'Store daily vegetable/fruit scraps in a 5L countertop caddy with an activated carbon filter lid.',
                'critical_rule' => 'Keep indoors away from direct sunlight; line with a layer of newspaper or dry neem leaves.',
            ],
            'transportation' => [
                'step_number' => 3,
                'title'       => 'Safe Odor-Free Transport to Center',
                'description' => 'Transfer accumulated wet waste every 3-4 days in a sealed reusable bucket with a locking lid.',
                'critical_rule' => 'Ensure bucket is firmly secured in vehicle trunk or two-wheeler footboard to prevent spills.',
            ],
            'facility_reception' => [
                'step_number' => 4,
                'title'       => 'Weigh-In and Bin Emptying',
                'description' => 'Present waste at the reception booth (AMC Pirana, SMC Bhestan, VMC Atladara, etc.) for visual purity check and weighbridge entry.',
                'critical_rule' => 'Empty scraps into the designated green municipal intake hopper; rinse container at the wash station.',
            ],
            'culture_collection' => [
                'step_number' => 5,
                'title'       => 'Free Bio-Culture & Compost Collection',
                'description' => 'Participating citizens in Ahmedabad, Surat, and Vadodara are eligible for free dry bio-accelerator culture or cured living compost bags on designated weekend mornings.',
                'critical_rule' => 'Bring a clean cloth sack to receive your monthly living soil allotment.',
            ],
        ];
    }

    /**
     * Check if facility is currently open based on operating hours string and current time
     *
     * @param string $operatingHours e.g. "Mon - Sat: 08:00 AM - 05:00 PM"
     * @param int|null $timestamp
     * @return array
     */
    public static function checkOpenStatus(string $operatingHours, ?int $timestamp = null): array
    {
        $time = $timestamp ?? time();
        $currentDay = date('D', $time);
        $currentHourMin = date('H:i', $time);

        // Typical Gujarat schedule: Mon - Sat: 08:00 AM - 05:00 PM
        $isSunday = $currentDay === 'Sun';
        $isEveryDay = stripos($operatingHours, 'Daily') !== false || stripos($operatingHours, 'Mon - Sun') !== false;

        if ($isSunday && !$isEveryDay) {
            return [
                'is_open'     => false,
                'status_text' => 'Closed Today (Sunday)',
                'hours'       => $operatingHours,
                'next_open'   => 'Monday 08:00 AM',
            ];
        }

        // Check hour range (08:00 to 17:00 or 18:00)
        $hour = (int)date('G', $time);
        $isOpen = $hour >= 8 && $hour < 17;

        return [
            'is_open'     => $isOpen,
            'status_text' => $isOpen ? 'Open Now' : 'Closed for the Day',
            'hours'       => $operatingHours,
            'next_open'   => $isOpen ? 'Closes at 05:00 PM' : 'Opens tomorrow at 08:00 AM',
        ];
    }
}
