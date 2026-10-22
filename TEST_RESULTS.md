# Validation — 15 October 2026

- All 33 PHP files pass PHP 8.3 syntax checks.
- 51 browser assertions passed, with no uncaught JavaScript errors and no missing local asset responses.
- Seven page layouts reviewed at desktop (1355 × 931) and mobile (390 × 844) sizes. No mobile horizontal overflow.
- Compared the current live website's Home, Masterclass, Materials, Hardware, Community and facility directory against its exported current source and the PHP output. FAQ content/layout retained from the same current source.
- All original image files are identical byte-for-byte; their paths now work under the XAMPP project subdirectory. Fonts, icons and CSS are local.
- Impact calculator harvest/CO2 recalculation and confetti checked.
- All six guide phases, Previous/Next bounds, Materials category/search filters and FAQ accordion checked.
- Gujarat city filtering, facility search, zero-result/reset behavior, facility selection and original direction links preserved.
- Mobile drawer, navigation, direct PHP routes, browser Back and reload checked.
- Real MariaDB tested: SQL import twice, exactly two tables, twelve facility seeds, persistent feedback after refresh.
- Invalid CSRF, email, city and rating inputs rejected; submitted HTML escaped. No test submissions or test databases are included in this package.
- The Google Maps subtree and existing API key match the supplied current source. Initial map center, zoom, map ID, city presets and directions are unchanged.

## External test limitation

The live reference map rendered in the reference browser. The isolated local test browser received `net::ERR_EMPTY_RESPONSE` when requesting Google's JavaScript API. Actual local map tiles and provider-side key authorization could therefore not be verified. This is not reported as a successful live map test. The original integration and key are preserved, with no changes to Google Cloud configuration.

The runtime tested here is PHP 8.3 + MariaDB, equivalent to the application's PHP/MySQL requirements. Windows XAMPP itself was not available in this environment.
