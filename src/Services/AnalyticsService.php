<?php
declare(strict_types=1);

namespace EarthCycle\Services;

use EarthCycle\Repositories\CenterRepository;
use EarthCycle\Repositories\FeedbackRepository;
use EarthCycle\Repositories\MaterialRepository;

/**
 * EarthCycle Platform Analytics & Statistics Service
 * 
 * Aggregates live platform metrics including waste diversion calculations,
 * category satisfaction rates, and materials distribution.
 * 
 * @package EarthCycle\Services
 */
class AnalyticsService
{
    private CenterRepository $centerRepo;
    private FeedbackRepository $feedbackRepo;
    private MaterialRepository $materialRepo;

    public function __construct(
        ?CenterRepository $centerRepo = null,
        ?FeedbackRepository $feedbackRepo = null,
        ?MaterialRepository $materialRepo = null
    ) {
        $this->centerRepo = $centerRepo ?? new CenterRepository();
        $this->feedbackRepo = $feedbackRepo ?? new FeedbackRepository();
        $this->materialRepo = $materialRepo ?? new MaterialRepository();
    }

    /**
     * Compute comprehensive dashboard metrics
     *
     * @return array
     */
    public function getDashboardMetrics(): array
    {
        $centers = $this->centerRepo->all();
        $reports = $this->feedbackRepo->getReports();
        $matCounts = $this->materialRepo->getCategoryCounts();

        // Rating distribution
        $ratingDist = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        foreach ($reports as $r) {
            $star = (int)($r['rating'] ?? 5);
            if (isset($ratingDist[$star])) {
                $ratingDist[$star]++;
            }
        }

        // City report distribution
        $cityDist = [];
        foreach ($reports as $r) {
            $c = $r['city'] ?? 'Ahmedabad';
            $cityDist[$c] = ($cityDist[$c] ?? 0) + 1;
        }

        return [
            'total_centers'       => count($centers),
            'total_reports'       => count($reports),
            'rating_distribution' => $ratingDist,
            'reports_by_city'     => $cityDist,
            'materials_matrix'    => $matCounts,
            'community_impact'    => ImpactCalculatorService::calculateCommunityAggregate(10000, 7.0),
        ];
    }
}
