<?php
declare(strict_types=1);

/**
 * EarthCycle Platform Bootstrap & Initialization
 * 
 * Registers PSR-4 autoloader, initializes session security, database connection,
 * and loads content definitions and municipal facilities.
 * 
 * @package EarthCycle
 */

// Error logging configuration
ini_set('display_errors', '0');
ini_set('log_errors', '1');

// Register EarthCycle PSR-4 Autoloader
require_once __DIR__ . '/../src/autoload.php';

use EarthCycle\Database\Connection;
use EarthCycle\Repositories\CenterRepository;
use EarthCycle\Repositories\FeedbackRepository;
use EarthCycle\Services\SecurityService;

// Initialize session with secure cookie flags
SecurityService::initSession();

// Database configuration
require_once __DIR__ . '/../config/db.php';

// Load static content definitions
$content = require __DIR__ . '/content.php';
$centers = $content['GUJARAT_CENTERS'];

/**
 * Escape string for safe HTML output
 *
 * @param mixed $value
 * @return string
 */
function e(mixed $value): string {
    return SecurityService::escape($value);
}

/**
 * Retrieve or generate CSRF token
 *
 * @return string
 */
function csrf_token(): string {
    return SecurityService::csrfToken();
}

/**
 * Send JSON response and exit
 *
 * @param array $value
 * @param int $status
 * @return void
 */
function json_response(array $value, int $status = 200): void {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store');
    echo json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_SUBSTITUTE);
    exit;
}

/**
 * Editorial reference reports
 *
 * @return array
 */
function reference_reports(): array {
    return FeedbackRepository::getReferenceReports();
}

/**
 * Load citizen reports from database with fallback
 *
 * @return array
 */
function load_reports(): array {
    $repo = new FeedbackRepository();
    return $repo->getReports();
}

/**
 * Load centers from database with fallback to bundled defaults
 *
 * @param array $defaults
 * @return array
 */
function load_centers(array $defaults): array {
    $repo = new CenterRepository($defaults);
    return $repo->allAsArrays();
}

$centers = load_centers($centers);
