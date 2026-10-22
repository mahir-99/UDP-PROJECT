<?php
declare(strict_types=1);

namespace EarthCycle\Services;

/**
 * EarthCycle Centralized Application Configuration & Environment Loader
 * 
 * Provides typed access to platform settings, API credentials, and environment overrides
 * without external Composer dependencies in pure Core PHP.
 * 
 * @package EarthCycle\Services
 */
class ConfigService
{
    private static array $config = [];
    private static bool $initialized = false;

    /**
     * Initialize platform configurations
     */
    public static function init(): void
    {
        if (self::$initialized) {
            return;
        }

        self::$config = [
            'app' => [
                'name'        => 'EarthCycle Living Soil Network Gujarat',
                'env'         => getenv('APP_ENV') ?: 'production',
                'version'     => '2.0.0',
                'timezone'    => 'Asia/Kolkata',
                'locale'      => 'en_IN',
                'base_url'    => getenv('APP_URL') ?: 'http://localhost/earthcycle',
            ],
            'database' => [
                'host'     => getenv('DB_HOST') ?: '127.0.0.1',
                'port'     => (int)(getenv('DB_PORT') ?: 3306),
                'database' => getenv('DB_NAME') ?: 'composting_db',
                'username' => getenv('DB_USER') ?: 'root',
                'password' => getenv('DB_PASS') !== false ? (string)getenv('DB_PASS') : '',
                'charset'  => 'utf8mb4',
            ],
            'gujarat' => [
                'corporations' => ['AMC', 'SMC', 'VMC', 'RMC', 'GMC', 'BMC'],
                'primary_hub'  => 'AMC Central Bio-Composting Plant, Pirana',
                'total_centers'=> 12,
                'state'        => 'Gujarat',
                'country'      => 'India',
            ],
            'composting' => [
                'ideal_cn_min'        => 25.0,
                'ideal_cn_max'        => 30.0,
                'moisture_target_pct' => 55.0,
                'co2_factor_per_kg'   => 0.92,
                'tree_factor_kg'      => 21.0,
                'compost_yield_ratio' => 0.35,
            ],
        ];

        date_default_timezone_set(self::$config['app']['timezone']);
        self::$initialized = true;
    }

    /**
     * Retrieve configuration value by dot notation key (e.g. 'database.host')
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        self::init();
        $segments = explode('.', $key);
        $current = self::$config;

        foreach ($segments as $seg) {
            if (!is_array($current) || !array_key_exists($seg, $current)) {
                return $default;
            }
            $current = $current[$seg];
        }

        return $current;
    }

    /**
     * Set configuration value dynamically at runtime
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set(string $key, mixed $value): void
    {
        self::init();
        $segments = explode('.', $key);
        $current = &self::$config;

        foreach ($segments as $seg) {
            if (!isset($current[$seg]) || !is_array($current[$seg])) {
                $current[$seg] = [];
            }
            $current = &$current[$seg];
        }

        $current = $value;
    }
}
