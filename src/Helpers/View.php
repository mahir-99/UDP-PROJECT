<?php
declare(strict_types=1);

namespace EarthCycle\Helpers;

use EarthCycle\Services\SecurityService;

/**
 * EarthCycle View & Template Helper
 * 
 * Manages rendering of PHP view partials, asset cache-busting hashes,
 * and page titles.
 * 
 * @package EarthCycle\Helpers
 */
class View
{
    private static string $baseDir = __DIR__ . '/../../views';

    /**
     * Render a view partial with context variables
     *
     * @param string $view View name (e.g. 'home', 'locator')
     * @param array $data Context variables made available to template
     * @return string Rendered HTML
     */
    public static function render(string $view, array $data = []): string
    {
        $file = self::$baseDir . '/' . $view . '.php';
        if (!file_exists($file)) {
            return '';
        }

        extract($data, EXTR_SKIP);
        ob_start();
        include $file;
        return ob_get_clean();
    }

    /**
     * Generate cache-busting asset version hash
     *
     * @param string $basePath
     * @return string
     */
    public static function getAssetVersion(string $basePath): string
    {
        $css = $basePath . '/assets/css/style.css';
        $js = $basePath . '/assets/js/app.js';

        $hashPart = '20261015';
        if (file_exists($css) && file_exists($js)) {
            $combined = hash_file('sha256', $css) . hash_file('sha256', $js);
            $hashPart .= '-' . substr(hash('sha256', $combined), 0, 8);
        }

        return $hashPart;
    }

    /**
     * Short alias for HTML entity escaping
     *
     * @param mixed $value
     * @return string
     */
    public static function e(mixed $value): string
    {
        return SecurityService::escape($value);
    }
}
