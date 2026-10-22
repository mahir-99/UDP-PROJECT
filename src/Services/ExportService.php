<?php
declare(strict_types=1);

namespace EarthCycle\Services;

use EarthCycle\Repositories\CenterRepository;
use EarthCycle\Repositories\FeedbackRepository;
use EarthCycle\Repositories\MaterialRepository;
use SimpleXMLElement;

/**
 * EarthCycle Multi-Format Data Exporter Service
 * 
 * Exports directory information and analytical metrics into XML, JSON, CSV, and text formats.
 * 
 * @package EarthCycle\Services
 */
class ExportService
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
     * Export centers list as structured XML string
     *
     * @return string
     */
    public function exportCentersXml(): string
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><earthcycle_facilities></earthcycle_facilities>');
        $xml->addAttribute('region', 'Gujarat');
        $xml->addAttribute('generated_at', date('c'));

        foreach ($this->centerRepo->all() as $center) {
            $node = $xml->addChild('facility');
            $node->addChild('id', (string)$center->getId());
            $node->addChild('name', htmlspecialchars($center->getName(), ENT_XML1));
            $node->addChild('type', htmlspecialchars($center->getType(), ENT_XML1));
            $node->addChild('city', htmlspecialchars($center->getCity(), ENT_XML1));
            $node->addChild('address', htmlspecialchars($center->getAddress(), ENT_XML1));
            $node->addChild('latitude', (string)$center->getLat());
            $node->addChild('longitude', (string)$center->getLng());
            $node->addChild('phone', htmlspecialchars($center->getPhone(), ENT_XML1));
            $node->addChild('hours', htmlspecialchars($center->getHours(), ENT_XML1));
            $node->addChild('capacity', htmlspecialchars($center->getCapacity(), ENT_XML1));
            $node->addChild('status', htmlspecialchars($center->getStatus(), ENT_XML1));
        }

        return (string)$xml->asXML();
    }

    /**
     * Export materials matrix as JSON string
     *
     * @return string
     */
    public function exportMaterialsJson(): string
    {
        $materials = $this->materialRepo->all();
        $data = array_map(static fn($m) => $m->toArray(), $materials);

        return json_encode([
            'schema'       => 'EarthCycle Organic Waste Classification 2.0',
            'total_items'  => count($data),
            'generated_at' => date('Y-m-d H:i:s'),
            'materials'    => $data,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
