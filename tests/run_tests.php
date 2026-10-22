<?php
declare(strict_types=1);

/**
 * EarthCycle Automated Core PHP Test Suite Runner
 * 
 * Executes all automated tests for calculators, security, coordinates,
 * algorithms, validations, certificates, ecology, vermicomposting, tea brewing, biochar, config, and crops.
 */

require_once __DIR__ . '/../includes/bootstrap.php';
require_once __DIR__ . '/ImpactCalculatorTest.php';
require_once __DIR__ . '/ClimateAdvisorTest.php';
require_once __DIR__ . '/BatchMixOptimizerTest.php';
require_once __DIR__ . '/GeoLocationTest.php';
require_once __DIR__ . '/SecurityTest.php';
require_once __DIR__ . '/ValidationTest.php';
require_once __DIR__ . '/CertificateTest.php';
require_once __DIR__ . '/MicrobeCultureTest.php';
require_once __DIR__ . '/SeasonalCalendarTest.php';
require_once __DIR__ . '/TroubleshootingTest.php';
require_once __DIR__ . '/CompostTeaTest.php';
require_once __DIR__ . '/BioCharTest.php';
require_once __DIR__ . '/ConfigTest.php';
require_once __DIR__ . '/SeasonalCropTest.php';

use EarthCycle\Tests\ImpactCalculatorTest;
use EarthCycle\Tests\ClimateAdvisorTest;
use EarthCycle\Tests\BatchMixOptimizerTest;
use EarthCycle\Tests\GeoLocationTest;
use EarthCycle\Tests\SecurityTest;
use EarthCycle\Tests\ValidationTest;
use EarthCycle\Tests\CertificateTest;
use EarthCycle\Tests\MicrobeCultureTest;
use EarthCycle\Tests\SeasonalCalendarTest;
use EarthCycle\Tests\TroubleshootingTest;
use EarthCycle\Tests\CompostTeaTest;
use EarthCycle\Tests\BioCharTest;
use EarthCycle\Tests\ConfigTest;
use EarthCycle\Tests\SeasonalCropTest;

$suites = [
    ImpactCalculatorTest::class,
    ClimateAdvisorTest::class,
    BatchMixOptimizerTest::class,
    GeoLocationTest::class,
    SecurityTest::class,
    ValidationTest::class,
    CertificateTest::class,
    MicrobeCultureTest::class,
    SeasonalCalendarTest::class,
    TroubleshootingTest::class,
    CompostTeaTest::class,
    BioCharTest::class,
    ConfigTest::class,
    SeasonalCropTest::class,
];

echo "========================================================\n";
echo "           EarthCycle Automated Test Suite              \n";
echo "========================================================\n\n";

$totalTests = 0;
$totalPassed = 0;

foreach ($suites as $suite) {
    $res = $suite::run();
    $status = $res['passed'] === $res['tests'] ? '[PASS]' : '[FAIL]';
    echo sprintf("%-6s %-30s (%d/%d tests passed)\n", $status, $res['name'], $res['passed'], $res['tests']);
    $totalTests += $res['tests'];
    $totalPassed += $res['passed'];
}

echo "\n" . str_repeat('-', 56) . "\n";
echo sprintf("Summary: %d of %d tests passed successfully (%s)\n", $totalPassed, $totalTests, $totalPassed === $totalTests ? '100% OK' : 'ERRORS');
echo str_repeat('-', 56) . "\n";
