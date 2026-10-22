<?php
declare(strict_types=1);

namespace EarthCycle\Services;

/**
 * EarthCycle Community Gamification & Citizen Badge Service
 * 
 * Computes citizen ecological achievement levels and badge credentials based on
 * kilograms of organic waste diverted and community field contributions.
 * 
 * @package EarthCycle\Services
 */
class CommunityLeaderboardService
{
    /**
     * Compute citizen composting badge from annual diverted waste
     *
     * @param float $divertedKg
     * @param int $submittedReports
     * @return array
     */
    public static function computeCitizenRank(float $divertedKg, int $submittedReports = 1): array
    {
        $kg = max(0.0, $divertedKg);

        if ($kg >= 500.0 && $submittedReports >= 5) {
            return [
                'title'       => 'Living Soil Champion',
                'badge_icon'  => '👑',
                'level'       => 4,
                'color_class' => 'from-emerald-400 to-teal-300',
                'description' => 'Veteran community composter diverting over 500 kg of municipal waste and actively reporting field data.',
                'next_milestone' => 'Maximum Rank Achieved',
            ];
        }

        if ($kg >= 250.0 || $submittedReports >= 3) {
            return [
                'title'       => 'Master Composter',
                'badge_icon'  => '🌱',
                'level'       => 3,
                'color_class' => 'from-emerald-500 to-teal-500',
                'description' => 'Consistent balcony or backyard composter producing cured living humus every 4-6 weeks.',
                'next_milestone' => 'Reach 500 kg and 5 reports to become a Living Soil Champion.',
            ];
        }

        if ($kg >= 100.0) {
            return [
                'title'       => 'Urban Soil Steward',
                'badge_icon'  => '🌿',
                'level'       => 2,
                'color_class' => 'from-teal-500 to-emerald-600',
                'description' => 'Dedicated urban apartment composter maintaining stable 2:1 brown-to-green layering.',
                'next_milestone' => 'Reach 250 kg diverted to unlock Master Composter status.',
            ];
        }

        return [
            'title'       => 'Seedling Pioneer',
            'badge_icon'  => '🌾',
            'level'       => 1,
            'color_class' => 'from-emerald-600 to-teal-700',
            'description' => 'Citizen starting their sustainable waste segregation and home composting journey.',
            'next_milestone' => 'Divert 100 kg to unlock Urban Soil Steward status.',
        ];
    }
}
