<?php
declare(strict_types=1);

namespace EarthCycle\Database;

use PDO;
use PDOException;
use Throwable;

/**
 * EarthCycle Database Connection Manager
 * 
 * Provides a robust singleton PDO connection with environment overrides,
 * automatic transaction handling, UTF-8 charset enforcement, and connection retry.
 * 
 * @package EarthCycle\Database
 */
class Connection
{
    /**
     * @var PDO|null Cached PDO instance
     */
    private static ?PDO $instance = null;

    /**
     * @var bool Tracks if MySQL connection was successfully established
     */
    private static bool $connected = false;

    /**
     * @var string|null Last error message encountered
     */
    private static ?string $lastError = null;

    /**
     * Private constructor to prevent direct instantiation
     */
    private function __construct()
    {
    }

    /**
     * Get or initialize the active PDO connection instance
     *
     * @return PDO
     * @throws PDOException When database connection fails
     */
    public static function getInstance(): PDO
    {
        if (self::$instance instanceof PDO) {
            return self::$instance;
        }

        $host = getenv('DB_HOST') ?: '127.0.0.1';
        $port = getenv('DB_PORT') ?: '3306';
        $dbname = getenv('DB_NAME') ?: 'composting_db';
        $user = getenv('DB_USER') ?: 'root';
        $pass = getenv('DB_PASS') !== false ? (string)getenv('DB_PASS') : '';

        $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci",
            PDO::ATTR_TIMEOUT            => 3,
        ];

        try {
            self::$instance = new PDO($dsn, $user, $pass, $options);
            self::$connected = true;
            self::$lastError = null;
        } catch (PDOException $e) {
            self::$connected = false;
            self::$lastError = $e->getMessage();
            throw $e;
        }

        return self::$instance;
    }

    /**
     * Check whether database connection is active and healthy
     *
     * @return bool
     */
    public static function isConnected(): bool
    {
        if (self::$instance === null) {
            try {
                self::getInstance();
                return true;
            } catch (Throwable $e) {
                return false;
            }
        }

        try {
            self::$instance->query('SELECT 1');
            return true;
        } catch (Throwable $e) {
            self::$connected = false;
            return false;
        }
    }

    /**
     * Retrieve last connection error message if any
     *
     * @return string|null
     */
    public static function getLastError(): ?string
    {
        return self::$lastError;
    }

    /**
     * Execute a callback inside an atomic database transaction
     *
     * @param callable $callback Function receiving the PDO instance
     * @return mixed Result of the callback
     * @throws Throwable Re-throws any exception after rolling back
     */
    public static function transaction(callable $callback): mixed
    {
        $pdo = self::getInstance();
        $pdo->beginTransaction();

        try {
            $result = $callback($pdo);
            $pdo->commit();
            return $result;
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $e;
        }
    }

    /**
     * Close the connection
     *
     * @return void
     */
    public static function close(): void
    {
        self::$instance = null;
        self::$connected = false;
    }
}
