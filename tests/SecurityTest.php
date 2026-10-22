<?php
declare(strict_types=1);

namespace EarthCycle\Tests;

use EarthCycle\Services\SecurityService;

class SecurityTest
{
    public static function run(): array
    {
        $tests = 0;
        $passed = 0;

        // Test 1: HTML escaping
        $tests++;
        $escaped = SecurityService::escape('<script>alert("xss")</script>');
        if (strpos($escaped, '<script>') === false && strpos($escaped, '&lt;script&gt;') !== false) {
            $passed++;
        }

        // Test 2: CSRF generation & validation
        $tests++;
        $token = SecurityService::csrfToken();
        if (!empty($token) && strlen($token) === 64) {
            $passed++;
        }

        // Test 3: CSRF verification
        $tests++;
        if (SecurityService::validateCsrf($token) && !SecurityService::validateCsrf('invalid-token')) {
            $passed++;
        }

        return ['name' => 'SecurityTest', 'tests' => $tests, 'passed' => $passed];
    }
}
