<?php
declare(strict_types=1);

namespace EarthCycle\Services;

/**
 * EarthCycle Citizen Masterclass Certificate Generator
 * 
 * Generates official verifiable completion certificates for citizens who complete
 * the 6-Phase Living Soil Masterclass in pure Core PHP.
 * 
 * @package EarthCycle\Services
 */
class CertificateService
{
    /**
     * Generate a unique cryptographic verification hash
     *
     * @param string $citizenName
     * @param string $city
     * @param string $date
     * @return string
     */
    public static function generateVerificationHash(string $citizenName, string $city, string $date): string
    {
        $payload = strtoupper(trim($citizenName)) . '|' . strtoupper(trim($city)) . '|' . $date . '|EARTHCYCLE_GUJARAT_2026';
        return 'ECG-' . strtoupper(substr(hash('sha256', $payload), 0, 12));
    }

    /**
     * Render SVG Certificate of Completion
     *
     * @param string $citizenName
     * @param string $city
     * @param float $divertedKg
     * @return string SVG XML
     */
    public static function generateSvgCertificate(string $citizenName, string $city, float $divertedKg = 364.0): string
    {
        $escapedName = htmlspecialchars($citizenName, ENT_XML1, 'UTF-8');
        $escapedCity = htmlspecialchars($city, ENT_XML1, 'UTF-8');
        $date = date('d F Y');
        $certId = self::generateVerificationHash($citizenName, $city, $date);

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 850" width="1200" height="850">
  <defs>
    <linearGradient id="bgGrad" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#02180f" />
      <stop offset="100%" stop-color="#010e08" />
    </linearGradient>
    <linearGradient id="goldGrad" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#10b981" />
      <stop offset="50%" stop-color="#34d399" />
      <stop offset="100%" stop-color="#059669" />
    </linearGradient>
  </defs>

  <!-- Background Canvas -->
  <rect width="1200" height="850" fill="url(#bgGrad)" />
  <rect x="40" y="40" width="1120" height="770" rx="24" fill="none" stroke="#10b981" stroke-width="2" stroke-opacity="0.3" />
  <rect x="55" y="55" width="1090" height="740" rx="16" fill="none" stroke="#34d399" stroke-width="1" stroke-opacity="0.15" />

  <!-- Header -->
  <g transform="translate(600, 140)" text-anchor="middle">
    <circle cx="0" cy="0" r="42" fill="#064e3b" stroke="#34d399" stroke-width="2" />
    <path d="M-12 10 L0 -14 L12 10 Z" fill="#34d399" />
    <text y="75" font-family="'Space Mono', monospace" font-size="14" font-weight="700" fill="#34d399" letter-spacing="4">GUJARAT LIVING SOIL INITIATIVE</text>
    <text y="115" font-family="'Outfit', sans-serif" font-size="44" font-weight="900" fill="#ffffff" letter-spacing="1">CERTIFICATE OF MASTERY</text>
    <text y="145" font-family="'Plus Jakarta Sans', sans-serif" font-size="16" font-weight="300" fill="#94a3b8">Decentralized Urban Organic Waste Composting Field Course</text>
  </g>

  <!-- Body Text -->
  <g transform="translate(600, 390)" text-anchor="middle">
    <text y="0" font-family="'Plus Jakarta Sans', sans-serif" font-size="16" fill="#94a3b8">This credential is proudly awarded to</text>
    <text y="55" font-family="'Outfit', sans-serif" font-size="46" font-weight="900" fill="url(#goldGrad)">{$escapedName}</text>
    <text y="100" font-family="'Plus Jakarta Sans', sans-serif" font-size="17" fill="#cbd5e1">of {$escapedCity}, Gujarat</text>
    <text y="145" font-family="'Plus Jakarta Sans', sans-serif" font-size="15" fill="#94a3b8" max-width="800">
      for successfully completing all six Masterclass modules on C:N stoichiometric balancing,
    </text>
    <text y="172" font-family="'Plus Jakarta Sans', sans-serif" font-size="15" fill="#94a3b8">
      microclimate moisture protection, and diverting an estimated {$divertedKg} kg of organic matter annually.
    </text>
  </g>

  <!-- Footer Verification -->
  <g transform="translate(100, 720)">
    <text y="0" font-family="'Space Mono', monospace" font-size="12" fill="#64748b">VERIFICATION ID:</text>
    <text y="22" font-family="'Space Mono', monospace" font-size="15" font-weight="700" fill="#10b981">{$certId}</text>
  </g>

  <g transform="translate(600, 730)" text-anchor="middle">
    <circle cx="0" cy="-10" r="28" fill="#042f2e" stroke="#10b981" stroke-width="1.5" />
    <text y="-5" font-family="'Outfit', sans-serif" font-size="10" font-weight="900" fill="#34d399">OFFICIAL</text>
    <text y="6" font-family="'Outfit', sans-serif" font-size="9" fill="#94a3b8">VERIFIED</text>
  </g>

  <g transform="translate(1100, 720)" text-anchor="end">
    <text y="0" font-family="'Space Mono', monospace" font-size="12" fill="#64748b">DATE OF ISSUE:</text>
    <text y="22" font-family="'Space Mono', monospace" font-size="15" font-weight="700" fill="#cbd5e1">{$date}</text>
  </g>
</svg>
SVG;
    }
}
