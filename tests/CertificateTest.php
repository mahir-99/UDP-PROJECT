<?php
declare(strict_types=1);

namespace EarthCycle\Tests;

use EarthCycle\Services\CertificateService;
use EarthCycle\Services\MicrobeCultureService;
use EarthCycle\Services\SeasonalCalendarService;

class CertificateTest
{
    public static function run(): array
    {
        $tests = 0;
        $passed = 0;

        // Test 1: Verification hash prefix
        $tests++;
        $hash = CertificateService::generateVerificationHash('Pooja Patel', 'Surat', '2026-10-22');
        if (strpos($hash, 'ECG-') === 0 && strlen($hash) === 16) {
            $passed++;
        }

        // Test 2: SVG Certificate output contains name
        $tests++;
        $svg = CertificateService::generateSvgCertificate('Pooja Patel', 'Surat', 364.0);
        if (strpos($svg, '<svg') !== false && strpos($svg, 'Pooja Patel') !== false && strpos($svg, 'Surat') !== false) {
            $passed++;
        }

        return ['name' => 'CertificateTest', 'tests' => $tests, 'passed' => $passed];
    }
}
