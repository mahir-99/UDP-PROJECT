<?php
declare(strict_types=1);

namespace EarthCycle\Controllers;

use EarthCycle\Repositories\CenterRepository;
use EarthCycle\Services\ImpactCalculatorService;
use EarthCycle\Services\ClimateAdvisorService;

/**
 * EarthCycle REST API Controller
 * 
 * Provides JSON API endpoints for centers, impact calculations, and climate advisories.
 * 
 * @package EarthCycle\Controllers
 */
class ApiController
{
    private CenterRepository $centerRepo;

    public function __construct(array $bundledCenters = [])
    {
        $this->centerRepo = new CenterRepository($bundledCenters);
    }

    /**
     * Handle centers API query
     *
     * @param string $city
     * @param string $search
     * @return array
     */
    public function getCenters(string $city = 'All', string $search = ''): array
    {
        $results = $this->centerRepo->search($search, $city);
        $arrayData = array_map(static fn($c) => $c->toArray(), $results);

        return [
            'status'  => 'success',
            'count'   => count($arrayData),
            'centers' => $arrayData,
        ];
    }

    /**
     * Handle impact calculator API query
     *
     * @param float $weeklyKg
     * @return array
     */
    public function calculateImpact(float $weeklyKg): array
    {
        $results = ImpactCalculatorService::calculate($weeklyKg);
        return [
            'status' => 'success',
            'data'   => $results,
        ];
    }

    /**
     * Handle climate advisory API query
     *
     * @return array
     */
    public function getClimateAdvisory(): array
    {
        return [
            'status' => 'success',
            'data'   => ClimateAdvisorService::getSeasonalAdvisory(),
        ];
    }
}
