<?php
declare(strict_types=1);

/**
 * EarthCycle Citizen Feedback Submission Endpoint
 * 
 * Handles POST requests for community reports, validates CSRF tokens,
 * applies rate limiting, inserts into MySQL, and returns JSON with card HTML.
 * 
 * @package EarthCycle\Api
 */

require_once __DIR__ . '/../includes/bootstrap.php';

use EarthCycle\Controllers\FeedbackController;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    json_response(['status' => 'error', 'message' => 'Method not allowed.'], 405);
}

$input = stripos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false
    ? json_decode(file_get_contents('php://input'), true)
    : $_POST;

if (!is_array($input)) {
    json_response(['status' => 'error', 'message' => 'Invalid report data payload.'], 400);
}

$allowedCities = array_keys($content['GUJARAT_CITY_COORDINATES'] ?? []);
$controller = new FeedbackController($allowedCities);
$result = $controller->handleSubmission($input);

json_response($result['data'], $result['status']);
