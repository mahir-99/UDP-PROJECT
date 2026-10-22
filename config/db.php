<?php
declare(strict_types=1);
// XAMPP defaults. Override using Apache environment variables if needed.
function get_db_connection(): PDO {
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;
    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $port = getenv('DB_PORT') ?: '3306';
    $name = getenv('DB_NAME') ?: 'composting_db.sql';
    $user = getenv('DB_USER') ?: 'root';
    $pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$name;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_TIMEOUT => 2,
    ]);
    // Upgrade the old exported feedback table without deleting existing reports.
    if (!$pdo->query("SHOW COLUMNS FROM feedback LIKE 'city'")->fetch()) {
        $pdo->exec("ALTER TABLE feedback ADD COLUMN city VARCHAR(100) NOT NULL DEFAULT 'Ahmedabad' AFTER email");
    }
    return $pdo;
}
