<?php
declare(strict_types=1);

/**
 * EarthCycle Command-Line Management Console
 * 
 * Provides CLI commands for database migrations, seeders, impact calculations,
 * and system health checks in pure Core PHP.
 * 
 * Usage:
 *   php console.php help
 *   php console.php db:migrate
 *   php console.php db:seed
 *   php console.php centers:list
 *   php console.php impact:calculate [weekly_kg]
 *   php console.php climate:advisory [season]
 * 
 * @package EarthCycle
 */

if (PHP_SAPI !== 'cli') {
    die("Error: EarthCycle console can only be executed from command-line interface.\n");
}

require_once __DIR__ . '/includes/bootstrap.php';

use EarthCycle\Database\Connection;
use EarthCycle\Database\DatabaseMigration;
use EarthCycle\Database\Seeders\DatabaseSeeder;
use EarthCycle\Repositories\CenterRepository;
use EarthCycle\Services\ImpactCalculatorService;
use EarthCycle\Services\ClimateAdvisorService;

$command = $argv[1] ?? 'help';
$arg = $argv[2] ?? null;

echo "\n";
echo "========================================================\n";
echo "       EarthCycle Living Soil Network Console (PHP)     \n";
echo "========================================================\n\n";

switch ($command) {
    case 'help':
    case '--help':
    case '-h':
        echo "Available Commands:\n";
        echo "  db:migrate               Verify and execute schema migrations\n";
        echo "  db:seed                  Seed all 12 Gujarat centers and 18 materials\n";
        echo "  centers:list             List all verified Gujarat composting facilities\n";
        echo "  impact:calculate [kg]    Calculate annual diverted waste, compost & CO2\n";
        echo "  climate:advisory [s]     Display seasonal protocol for Gujarat climate\n";
        echo "  health:check             Check database connectivity and configuration\n";
        echo "  test                     Run unit and regression test suite\n";
        echo "\n";
        break;

    case 'health:check':
        echo "Checking system health...\n";
        echo "PHP Version: " . PHP_VERSION . "\n";
        $dbConnected = Connection::isConnected();
        echo "Database Connection: " . ($dbConnected ? "[OK] Connected to MySQL" : "[WARNING] MySQL Offline (using bundled fallbacks)") . "\n";
        if (!$dbConnected && Connection::getLastError()) {
            echo "Database Error: " . Connection::getLastError() . "\n";
        }
        echo "Loaded Centers: " . count($centers) . " facilities\n";
        echo "Environment: " . (getenv('APP_ENV') ?: 'production') . "\n";
        break;

    case 'db:migrate':
        echo "Executing database migrations...\n";
        try {
            $migrator = new DatabaseMigration();
            $res = $migrator->run();
            echo "Migration results:\n";
            print_r($res);
            echo "\n[OK] Migrations completed successfully.\n";
        } catch (Throwable $e) {
            echo "[ERROR] Migration failed: " . $e->getMessage() . "\n";
        }
        break;

    case 'db:seed':
        echo "Seeding Gujarat centers and materials...\n";
        try {
            $res = DatabaseSeeder::run();
            echo "Seeding report: Centers: " . ($res['centers'] ?? 0) . ", Materials: " . ($res['materials'] ?? 0) . "\n";
            echo "[OK] Seeding completed.\n";
        } catch (Throwable $e) {
            echo "[ERROR] Seeding failed: " . $e->getMessage() . "\n";
        }
        break;

    case 'centers:list':
        $repo = new CenterRepository($centers);
        $all = $repo->all();
        echo sprintf("%-4s %-42s %-14s %-12s\n", "ID", "FACILITY NAME", "CITY", "CAPACITY");
        echo str_repeat('-', 78) . "\n";
        foreach ($all as $c) {
            echo sprintf("%-4d %-42s %-14s %-12s\n", $c->getId(), substr($c->getName(), 0, 40), $c->getCity(), $c->getCapacity());
        }
        echo "\nTotal Verified Facilities: " . count($all) . "\n";
        break;

    case 'impact:calculate':
        $kg = (float)($arg ?? 7.0);
        $res = ImpactCalculatorService::calculate($kg);
        echo "Household Impact Calculation for {$kg} kg/week:\n";
        echo "  - Weekly Household Waste:     {$res['formatted']['weekly']}\n";
        echo "  - Annual Organic Waste Diverted: {$res['annual_waste_kg']} kg\n";
        echo "  - Living Humus Compost Yield: {$res['formatted']['harvest']}\n";
        echo "  - Avoided Landfill Methane:   {$res['formatted']['co2']} CO2e\n";
        echo "  - Equivalent Urban Trees:     {$res['trees_equivalent']} trees/yr\n";
        break;

    case 'climate:advisory':
        $season = $arg ? ucfirst(strtolower($arg)) : ClimateAdvisorService::getCurrentSeason();
        $advisory = ClimateAdvisorService::getSeasonalAdvisory($season);
        echo "Gujarat Seasonal Composting Protocol:\n";
        echo "  Season:      {$advisory['season']}\n";
        echo "  Temp Range:  {$advisory['temp_range']}\n";
        echo "  Humidity:    {$advisory['humidity']}\n";
        echo "  Main Risk:   {$advisory['main_risk']}\n";
        echo "  C:N Ratio:   {$advisory['ratio_advice']}\n";
        echo "  Watering:    {$advisory['water_action']}\n";
        echo "  Placement:   {$advisory['placement']}\n";
        echo "  Pro-Tip:     {$advisory['pro_tip']}\n";
        break;

    case 'test':
        require_once __DIR__ . '/tests/run_tests.php';
        break;

    default:
        echo "Unknown command: '{$command}'. Run 'php console.php help' for available commands.\n";
        exit(1);
}
echo "\n";
