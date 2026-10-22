<?php
declare(strict_types=1);

namespace EarthCycle\Database\Seeders;

use EarthCycle\Database\Connection;
use PDO;
use Throwable;

/**
 * EarthCycle Master Database Seeder
 * 
 * Orchestrates seeding of all database tables (centers, materials).
 * 
 * @package EarthCycle\Database\Seeders
 */
class DatabaseSeeder
{
    public static function run(?PDO $pdo = null): array
    {
        $pdo = $pdo ?? Connection::getInstance();
        $report = [];

        try {
            $report['centers'] = CenterSeeder::run($pdo);
            $report['materials'] = MaterialSeeder::run($pdo);
            $report['status'] = 'success';
        } catch (Throwable $e) {
            $report['status'] = 'error';
            $report['message'] = $e->getMessage();
        }

        return $report;
    }
}
