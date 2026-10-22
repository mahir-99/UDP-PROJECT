<?php
declare(strict_types=1);

/**
 * EarthCycle PSR-4 Compatible Autoloader
 * 
 * Automatically loads PHP classes from the EarthCycle namespace
 * mapped directly to the src/ directory.
 *
 * @package EarthCycle
 * @author EarthCycle Living Soil Network
 * @version 2.0.0
 */

spl_autoload_register(static function (string $class): void {
    // Project-specific namespace prefix
    $prefix = 'EarthCycle\\';

    // Base directory for the namespace prefix
    $baseDir = __DIR__ . '/';

    // Does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    // Get the relative class name
    $relativeClass = substr($class, $len);

    // Replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append with .php
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    // If the file exists, require it
    if (file_exists($file)) {
        require_once $file;
    }
});
