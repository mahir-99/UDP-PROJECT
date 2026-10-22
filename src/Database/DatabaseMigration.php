<?php
declare(strict_types=1);

namespace EarthCycle\Database;

use PDO;
use Throwable;

/**
 * EarthCycle Database Schema Migration & Integrity Manager
 * 
 * Verifies existence of required application tables (`centers`, `feedback`),
 * validates schema versions, and creates missing columns or indexes if needed.
 * 
 * @package EarthCycle\Database
 */
class DatabaseMigration
{
    private PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? Connection::getInstance();
    }

    /**
     * Run all pending migrations and table checks
     *
     * @return array Status report of migration checks
     */
    public function run(): array
    {
        $report = [];

        try {
            $report['database'] = $this->ensureDatabaseExists();
            $report['centers_table'] = $this->ensureCentersTable();
            $report['feedback_table'] = $this->ensureFeedbackTable();
            $report['seed_centers'] = $this->verifyCentersData();
        } catch (Throwable $e) {
            $report['error'] = $e->getMessage();
        }

        return $report;
    }

    /**
     * Ensure database exists
     */
    private function ensureDatabaseExists(): string
    {
        $this->pdo->exec("CREATE DATABASE IF NOT EXISTS `composting_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        return 'verified';
    }

    /**
     * Ensure centers table structure
     */
    private function ensureCentersTable(): string
    {
        $sql = "CREATE TABLE IF NOT EXISTS `centers` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(255) NOT NULL,
            `type` VARCHAR(100) NOT NULL,
            `city` VARCHAR(100) NOT NULL,
            `address` VARCHAR(500) NOT NULL,
            `latitude` DECIMAL(10, 7) NOT NULL,
            `longitude` DECIMAL(10, 7) NOT NULL,
            `phone` VARCHAR(50) DEFAULT NULL,
            `email` VARCHAR(100) DEFAULT NULL,
            `operating_hours` VARCHAR(100) DEFAULT NULL,
            `accepted_waste` TEXT DEFAULT NULL,
            `capacity` VARCHAR(100) DEFAULT NULL,
            `services` TEXT DEFAULT NULL,
            `status` VARCHAR(100) DEFAULT 'Active',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            INDEX `idx_city` (`city`),
            INDEX `idx_type` (`type`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

        $this->pdo->exec($sql);
        return 'table verified';
    }

    /**
     * Ensure feedback table structure and missing columns
     */
    private function ensureFeedbackTable(): string
    {
        $sql = "CREATE TABLE IF NOT EXISTS `feedback` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(150) NOT NULL,
            `email` VARCHAR(150) NOT NULL,
            `city` VARCHAR(100) NOT NULL,
            `rating` TINYINT(4) NOT NULL DEFAULT 5,
            `category` VARCHAR(100) NOT NULL DEFAULT 'General Suggestion',
            `message` TEXT NOT NULL,
            `status` VARCHAR(50) NOT NULL DEFAULT 'Approved',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            INDEX `idx_rating` (`rating`),
            INDEX `idx_city` (`city`),
            INDEX `idx_created` (`created_at`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

        $this->pdo->exec($sql);

        // Check if city column exists (compatibility check from original schema notes)
        try {
            $stmt = $this->pdo->query("SHOW COLUMNS FROM `feedback` LIKE 'city'");
            if (!$stmt->fetch()) {
                $this->pdo->exec("ALTER TABLE `feedback` ADD COLUMN `city` VARCHAR(100) NOT NULL DEFAULT 'Ahmedabad' AFTER `email`");
            }
        } catch (Throwable $e) {
            // Ignore if column check fails
        }

        return 'table verified';
    }

    /**
     * Check if initial Gujarat centers exist; if empty, report count
     */
    private function verifyCentersData(): int
    {
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM `centers`");
            return (int)$stmt->fetchColumn();
        } catch (Throwable $e) {
            return 0;
        }
    }
}
