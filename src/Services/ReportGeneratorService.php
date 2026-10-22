<?php
declare(strict_types=1);

namespace EarthCycle\Services;

use EarthCycle\Repositories\CenterRepository;
use EarthCycle\Repositories\FeedbackRepository;
use EarthCycle\Models\Center;

/**
 * EarthCycle Municipal Composting Audit & Report Generator
 * 
 * Generates structured audits, CSV exports, and municipal performance reports
 * across Gujarat composting zones.
 * 
 * @package EarthCycle\Services
 */
class ReportGeneratorService
{
    private CenterRepository $centerRepo;
    private FeedbackRepository $feedbackRepo;

    public function __construct(
        ?CenterRepository $centerRepo = null,
        ?FeedbackRepository $feedbackRepo = null
    ) {
        $this->centerRepo = $centerRepo ?? new CenterRepository();
        $this->feedbackRepo = $feedbackRepo ?? new FeedbackRepository();
    }

    /**
     * Generate CSV export string of all Gujarat composting centers
     *
     * @return string
     */
    public function exportCentersCsv(): string
    {
        $centers = $this->centerRepo->all();
        $fp = fopen('php://temp', 'r+');

        // CSV Header
        fputcsv($fp, [
            'Center ID',
            'Facility Name',
            'Type',
            'City',
            'Address',
            'Latitude',
            'Longitude',
            'Operating Hours',
            'Contact Phone',
            'Capacity',
            'Status'
        ]);

        foreach ($centers as $c) {
            fputcsv($fp, [
                $c->getId(),
                $c->getName(),
                $c->getType(),
                $c->getCity(),
                $c->getAddress(),
                $c->getLat(),
                $c->getLng(),
                $c->getHours(),
                $c->getPhone(),
                $c->getCapacity(),
                $c->getStatus(),
            ]);
        }

        rewind($fp);
        $csv = stream_get_contents($fp);
        fclose($fp);

        return (string)$csv;
    }

    /**
     * Generate Gujarat Municipal Composting Performance Summary
     *
     * @return array
     */
    public function generateMunicipalSummary(): array
    {
        $centers = $this->centerRepo->all();
        $cityCounts = $this->centerRepo->getCountsByCity();
        $totalFacilities = count($centers);

        $totalCapacityTpd = 0;
        foreach ($centers as $c) {
            if (preg_match('/(\d+)\s*TPD/i', $c->getCapacity(), $m)) {
                $totalCapacityTpd += (int)$m[1];
            }
        }

        $avgRating = $this->feedbackRepo->getAverageRating();
        $totalFeedback = count($this->feedbackRepo->getReports());

        return [
            'platform'             => 'EarthCycle Living Soil Network Gujarat',
            'timestamp'            => date('Y-m-d H:i:s'),
            'total_facilities'     => $totalFacilities,
            'total_capacity_tpd'   => $totalCapacityTpd,
            'covered_cities'       => array_keys($cityCounts),
            'city_distribution'    => $cityCounts,
            'average_rating'       => $avgRating,
            'total_field_reports'  => $totalFeedback,
            'annual_potential_tonnes' => $totalCapacityTpd * 365,
        ];
    }
}
