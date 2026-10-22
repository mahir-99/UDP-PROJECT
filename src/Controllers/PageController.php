<?php
declare(strict_types=1);

namespace EarthCycle\Controllers;

use EarthCycle\Repositories\CenterRepository;
use EarthCycle\Repositories\FeedbackRepository;
use EarthCycle\Repositories\MaterialRepository;
use EarthCycle\Repositories\GuideRepository;
use EarthCycle\Repositories\ProductRepository;
use EarthCycle\Services\ImpactCalculatorService;
use EarthCycle\Services\ClimateAdvisorService;
use EarthCycle\Services\GeoLocationService;
use EarthCycle\Services\SecurityService;

/**
 * EarthCycle Page & View Orchestration Controller
 * 
 * Prepares data contexts and coordinates view rendering for all frontend pages.
 * 
 * @package EarthCycle\Controllers
 */
class PageController
{
    private CenterRepository $centerRepo;
    private FeedbackRepository $feedbackRepo;
    private MaterialRepository $materialRepo;
    private GuideRepository $guideRepo;
    private ProductRepository $productRepo;
    private array $content;

    public function __construct(array $content)
    {
        $this->content = $content;
        $this->centerRepo = new CenterRepository($content['GUJARAT_CENTERS'] ?? []);
        $this->feedbackRepo = new FeedbackRepository();
        $this->materialRepo = new MaterialRepository($content['MATERIALS'] ?? []);
        $this->guideRepo = new GuideRepository($content['GUIDE_STEPS'] ?? []);
        $this->productRepo = new ProductRepository($content['PRODUCTS'] ?? []);
    }

    /**
     * Get title for page
     *
     * @param string $page
     * @return string
     */
    public function getPageTitle(string $page): string
    {
        $titles = [
            'home'      => 'Living Soil Network',
            'locator'   => 'Gujarat Composting Facilities',
            'guide'     => '6-Phase Complete Field Guide',
            'materials' => 'Materials Matrix',
            'products'  => 'Curated Composting Equipment',
            'feedback'  => 'Community Reviews & Field Reports',
            'faqs'      => 'Frequently Asked Questions',
        ];
        return $titles[$page] ?? 'Living Soil Network';
    }

    /**
     * Prepare data payload for client JavaScript initialization
     *
     * @param string $currentPage
     * @return array
     */
    public function buildClientPayload(string $currentPage): array
    {
        $mapKey = require __DIR__ . '/../../config/map.php';

        return [
            'page'        => $currentPage,
            'centers'     => $this->centerRepo->allAsArrays(),
            'cityPresets' => $this->content['GUJARAT_CITY_COORDINATES'] ?? GeoLocationService::getGujaratCityPresets(),
            'mapKey'      => $mapKey,
        ];
    }

    /**
     * Prepare data context for the active page
     *
     * @param string $currentPage
     * @return array
     */
    public function getPageContext(string $currentPage): array
    {
        $context = [
            'currentPage' => $currentPage,
            'pageTitle'   => $this->getPageTitle($currentPage),
            'content'     => $this->content,
            'centers'     => $this->centerRepo->allAsArrays(),
            'csrfToken'   => SecurityService::csrfToken(),
            'season'      => ClimateAdvisorService::getSeasonalAdvisory(),
        ];

        if ($currentPage === 'feedback') {
            $context['reports'] = $this->feedbackRepo->getReports();
            $context['avgRating'] = $this->feedbackRepo->getAverageRating();
        }

        if ($currentPage === 'home') {
            $context['calculator'] = ImpactCalculatorService::calculate(7.0);
            $context['hubCount'] = count($context['centers']);
        }

        if ($currentPage === 'materials') {
            $context['materials'] = $this->materialRepo->all();
            $context['counts'] = $this->materialRepo->getCategoryCounts();
        }

        if ($currentPage === 'guide') {
            $context['guideSteps'] = $this->guideRepo->all();
        }

        if ($currentPage === 'products') {
            $context['products'] = $this->productRepo->all();
        }

        return $context;
    }
}
