<?php
declare(strict_types=1);

namespace EarthCycle\Controllers;

use EarthCycle\Database\Connection;
use EarthCycle\Database\DatabaseMigration;
use EarthCycle\Database\Seeders\DatabaseSeeder;
use EarthCycle\Repositories\CenterRepository;
use EarthCycle\Repositories\FeedbackRepository;
use EarthCycle\Services\AnalyticsService;
use EarthCycle\Services\ReportGeneratorService;
use Throwable;

/**
 * EarthCycle Administrative & Operations Controller
 * 
 * Provides administrative diagnostics, migration execution, and facility status checks.
 * 
 * @package EarthCycle\Controllers
 */
class AdminController
{
    private CenterRepository $centerRepo;
    private FeedbackRepository $feedbackRepo;
    private AnalyticsService $analyticsService;
    private ReportGeneratorService $reportService;

    public function __construct(
        ?CenterRepository $centerRepo = null,
        ?FeedbackRepository $feedbackRepo = null
    ) {
        $this->centerRepo = $centerRepo ?? new CenterRepository();
        $this->feedbackRepo = $feedbackRepo ?? new FeedbackRepository();
        $this->analyticsService = new AnalyticsService($this->centerRepo, $this->feedbackRepo);
        $this->reportService = new ReportGeneratorService($this->centerRepo, $this->feedbackRepo);
    }

    /**
     * Get complete system health and diagnostics report
     *
     * @return array
     */
    public function getSystemHealth(): array
    {
        $dbConnected = Connection::isConnected();
        $dbError = Connection::getLastError();

        $centersCount = count($this->centerRepo->all());
        $reportsCount = count($this->feedbackRepo->getReports());

        return [
            'app_name'           => 'EarthCycle Living Soil Network Gujarat',
            'php_version'        => PHP_VERSION,
            'server_software'    => $_SERVER['SERVER_SOFTWARE'] ?? 'CLI/XAMPP',
            'database_status'    => $dbConnected ? 'Connected (MySQL)' : 'Offline (Fallback Mode Active)',
            'database_error'     => $dbError,
            'loaded_facilities'  => $centersCount,
            'total_feedback'     => $reportsCount,
            'analytics_summary'  => $this->analyticsService->getDashboardMetrics(),
            'municipal_summary'  => $this->reportService->generateMunicipalSummary(),
            'timestamp'          => date('Y-m-d H:i:s'),
        ];
    }

    /**
     * Trigger database migration runner
     *
     * @return array
     */
    public function runMigrations(): array
    {
        try {
            $migrator = new DatabaseMigration();
            return [
                'status'  => 'success',
                'details' => $migrator->run(),
            ];
        } catch (Throwable $e) {
            return [
                'status'  => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Trigger database seeders
     *
     * @return array
     */
    public function seedDatabase(): array
    {
        try {
            return DatabaseSeeder::run();
        } catch (Throwable $e) {
            return [
                'status'  => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }
}
