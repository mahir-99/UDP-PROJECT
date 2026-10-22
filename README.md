# EarthCycle — updated XAMPP edition

This package uses the updated dark green / teal Living Soil Network website shown at https://earthcycle5.ai.studio/. It replaces the stale PHP export that was included inside the AI Studio download.

## Run in XAMPP (Windows)

1. If `C:\xampp\htdocs\earthcycle` already exists, rename that old folder to `earthcycle_backup`. Keep your existing database backup if it contains reports.
2. Extract this ZIP into `C:\xampp\htdocs`. The resulting entry file must be `C:\xampp\htdocs\earthcycle\index.php` — not an extra nested `earthcycle\earthcycle` folder.
3. Start **Apache** and **MySQL** in the XAMPP Control Panel.
4. Open `http://localhost/phpmyadmin`, choose **Import**, and import `earthcycle/database/composting_db.sql`. The file creates `composting_db` and the two tables `centers` and `feedback`. Reimporting refreshes the twelve reference facilities without deleting existing feedback. An old feedback table receives its missing city column automatically when the application connects.
5. Open **http://localhost/earthcycle/** and press **Ctrl+F5** once.

Do not double-click a PHP file, open the old AI Studio `index.html`, copy only a `dist` folder, or run an old nested ZIP. This package is already ready to serve; there is no npm install, Vite server, TypeScript compiler, or Node server to run.

## What is included

- Native PHP entry pages, reusable PHP views, PHP content arrays and PHP/PDO MySQL endpoints.
- Updated Home / Impact Calculator, all six Masterclass phases, eighteen Materials entries, twelve Hardware products, Community Feed and FAQs.
- All twelve Gujarat facilities, original city presets, facility selection, map popups and original Google driving-direction links.
- Original images, local fonts, icons, gradients, responsive layouts, hover effects, page transitions and confetti.
- Persistent feedback with name/email/city/rating/category validation, CSRF protection and escaped output. Email addresses are not displayed in the public feed. The three reference-site reports remain editorial content; they are not inserted as fake database submissions.
- `about.php` and `faqs.php` compatibility aliases. No Soil/Biological Analysis or 3D Decomposition Model is added.

## Google Maps — preserved

The map provider, existing key, `DEMO_MAP_ID`, Gujarat coordinates, initial zoom, marker styles, camera transitions, info-window content and driving-direction URLs come from the current source. No replacement map provider or new key is introduced.

The original Google Maps component is retained as an isolated, precompiled browser JavaScript module (`assets/js/map.js` and `map-runtime.js`). That small part retains its original React-based Maps library to avoid changing its behavior. The surrounding pages and content are rendered by native PHP, with ordinary JavaScript for interactions; there is no TypeScript or Node runtime requirement.

Maps still need an internet connection and the existing key's Google project authorization. In this testing environment the Google script request returned `ERR_EMPTY_RESPONSE`, so actual local map tiles could not be verified; the live reference map was visible, and map source/configuration parity was checked. No Google Cloud account settings or API restrictions were changed.

## Editing

- `includes/content.php`: facilities' bundled fallback data, products, materials and original guide/FAQ data.
- `views/`: current PHP page markup; guide panels and FAQ answers are in their page views.
- `includes/nav-*.php` / `includes/footer.php`: current navigation and footer.
- `assets/css/style.css`: ready-to-use local stylesheet, including original Tailwind utility styles.
- `assets/js/app.js`: readable page transitions, calculator, filters, guide/FAQ controls and feedback submission.
- `assets/js/map.js`: readable original map component, compiled to JavaScript. Libraries are in `map-runtime.js`.
- `config/db.php`: XAMPP connection defaults (`127.0.0.1:3306`, database `composting_db`, user `root`, empty password). Environment overrides: `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS`.
- `config/map.php`: preserved map key, with the existing `GOOGLE_MAPS_API_KEY` environment override.

The facility directory reads MySQL when available and uses the bundled reference directory when unavailable. Feedback is only reported as saved after a successful MySQL insert. Errors are logged on the server and never printed as SQL/PHP diagnostics in the website.

## Hosting

Upload the whole `earthcycle` folder to a PHP 8+ / MySQL host. Keep the asset folders and filename capitalization intact. GitHub can store the source, but GitHub Pages does not execute PHP; use XAMPP or a PHP-capable web host to run this project.

## Validation

See `TEST_RESULTS.md` for the completed checks and the external Maps testing limitation.
