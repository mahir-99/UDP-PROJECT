<?php
declare(strict_types=1);

/**
 * EarthCycle Gujarat Facilities REST Endpoint
 * 
 * Returns JSON list of verified composting centers filtered by city and query.
 * 
 * @package EarthCycle\Api
 */

require_once __DIR__ . '/../includes/bootstrap.php';

use EarthCycle\Controllers\ApiController;

$city = is_string($_GET['city'] ?? null) ? $_GET['city'] : 'All';
$query = is_string($_GET['search'] ?? null) ? trim((string)$_GET['search']) : '';

$api = new ApiController($centers);
$response = $api->getCenters($city, $query);

json_response($response, 200);
