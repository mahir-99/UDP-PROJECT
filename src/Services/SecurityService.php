<?php
declare(strict_types=1);

namespace EarthCycle\Services;

/**
 * EarthCycle Security & Sanitization Service
 * 
 * Provides cryptographically secure CSRF protection, input sanitation,
 * XSS escaping, rate limiting, and standard HTTP security response headers.
 * 
 * @package EarthCycle\Services
 */
class SecurityService
{
    /**
     * Start secure session if not already active
     */
    public static function initSession(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            $isHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
            session_set_cookie_params([
                'lifetime' => 0,
                'path'     => '/',
                'domain'   => '',
                'secure'   => $isHttps,
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
            session_start();
        }
    }

    /**
     * Generate or return existing CSRF token
     *
     * @return string
     */
    public static function csrfToken(): string
    {
        self::initSession();
        if (empty($_SESSION['csrf'])) {
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf'];
    }

    /**
     * Validate submitted CSRF token using timing-safe comparison
     *
     * @param string|null $token
     * @return bool
     */
    public static function validateCsrf(?string $token): bool
    {
        self::initSession();
        if (empty($token) || empty($_SESSION['csrf'])) {
            return false;
        }
        return hash_equals($_SESSION['csrf'], $token);
    }

    /**
     * Sanitize and escape string for HTML output
     *
     * @param mixed $value
     * @return string
     */
    public static function escape(mixed $value): string
    {
        return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    /**
     * Send standard security and privacy HTTP headers
     */
    public static function sendSecurityHeaders(): void
    {
        if (!headers_sent()) {
            header('X-Content-Type-Options: nosniff');
            header('X-Frame-Options: SAMEORIGIN');
            header('X-XSS-Protection: 1; mode=block');
            header('Referrer-Policy: strict-origin-when-cross-origin');
        }
    }

    /**
     * Simple sliding window rate limiter for submissions
     *
     * @param string $action Action key (e.g., 'submit_feedback')
     * @param int $maxAttempts Max attempts allowed in window
     * @param int $windowSeconds Window in seconds
     * @return bool True if allowed, false if rate limited
     */
    public static function checkRateLimit(string $action, int $maxAttempts = 10, int $windowSeconds = 60): bool
    {
        self::initSession();
        $key = 'rate_' . $action;
        $now = time();

        if (!isset($_SESSION[$key]) || !is_array($_SESSION[$key])) {
            $_SESSION[$key] = [];
        }

        // Prune expired attempts
        $_SESSION[$key] = array_filter(
            $_SESSION[$key],
            static fn(int $timestamp) => ($now - $timestamp) < $windowSeconds
        );

        if (count($_SESSION[$key]) >= $maxAttempts) {
            return false;
        }

        $_SESSION[$key][] = $now;
        return true;
    }
}
