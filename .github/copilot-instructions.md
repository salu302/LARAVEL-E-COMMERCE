<!-- Copied/created for AI coding agents to onboard quickly into this Laravel project -->
# Copilot instructions — Ecommerce Laravel App

Purpose
- Help AI agents make focused, safe, and correct code changes in this repository.

Quick start (recommended developer flow)
- Install PHP deps: `composer install`
- Install JS deps: `npm ci`
- Copy env and generate key (composer does this on create, but run manually when needed):
  - `copy .env.example .env` (Windows PowerShell)
  - `php artisan key:generate`
- Database (local default): repository expects an SQLite file created by composer scripts: `database/database.sqlite`.
  - Run migrations: `php artisan migrate --seed`
- Start dev stack (concurrent processes configured in `composer.json`):
  - `composer run dev` (this runs `php artisan serve`, queue listener, pail, and `npm run dev` via `concurrently`)
  - Alternatively run the parts you need: `php artisan serve` and `npm run dev`

Tests & CI
- Tests use Pest + Laravel testing helpers. Run tests with:
  - `composer test` or `php artisan test` (CI uses phpunit/pest config in `phpunit.xml`/`pest.php`)
- Windows notes: vendor binaries include `.bat` shims in `vendor\bin` (e.g. `vendor\bin\pest.bat`).

Big-picture architecture
- Laravel MVC (standard): `routes/` defines HTTP endpoints (`routes/web.php`, `routes/auth.php`).
- Controllers: `app/Http/Controllers/` handle requests and return views or JSON.
- Requests/Validation: `app/Http/Requests/` holds form request objects.
- Models & DB: `app/Models/` for Eloquent models; migrations under `database/migrations`; factories under `database/factories`.
- Views & frontend: Blade templates in `resources/views/` (layouts in `resources/views/layouts`, components in `resources/views/components`).
- Frontend build: Vite + Tailwind + Alpine configured via `vite.config.js`, `tailwind.config.js`, `resources/js/app.js`, and `resources/css/app.css`.

Project-specific conventions & patterns
- PSR-4 autoload: namespace `App\` maps to `app/` (see `composer.json`).
- SQLite-first dev setup: Composer `post-create-project-cmd` creates `database/database.sqlite` and runs migrations. Favor this for fast local tests.
- Dev stack shortcut: `composer run dev` orchestrates server, queue, logs, and vite — prefer it for full local environment.
- Blade/Vite detection: views check `public/build/manifest.json` to decide whether to use `@vite` or inline styles (see `resources/views/welcome.blade.php`).

Integration points & cross-component notes
- Jobs/queues: queue worker invoked with `php artisan queue:listen --tries=1` in `composer.json` dev script. Check `.env` for `QUEUE_CONNECTION`.
- Logs: application logs are in `storage/logs/` — use `tail -f` equivalents or open files in editor.
- Third-party packages: Breeze (auth scaffolding), Pail (logging/monitoring helper), Pest for tests. See `composer.json` require-dev.

Common tasks & examples for AI edits
- Add a route + controller + view:
  1. Add route in `routes/web.php`.
  2. Create controller in `app/Http/Controllers/` (PSR-4 namespace `App\Http\Controllers`).
  3. Create blade in `resources/views/` and reference assets with `@vite(['resources/css/app.css','resources/js/app.js'])`.
- Update an Eloquent model: update `app/Models/*`, run `php artisan tinker` or tests to validate behavior.
- Frontend changes: edit `resources/js/app.js` or `resources/css/app.css` then run `npm run dev` (or `composer run dev`).

Safety & style
- Follow existing style: controllers under `app/Http/Controllers`, Requests for validation, small, single-purpose Blade components in `resources/views/components/`.
- Tests: add or update tests in `tests/Feature` or `tests/Unit`. Run `composer test` before proposing changes.

Useful files to inspect
- `composer.json` (scripts, php requirement, dev tooling)
- `package.json`, `vite.config.js`, `tailwind.config.js` (frontend build)
- `routes/web.php`, `app/Http/Controllers/`, `app/Models/`, `resources/views/`
- `database/migrations/`, `database/factories/`, `database/seeders/`
- `phpunit.xml`, `pest.php`, `tests/`

If you need more
- Ask for specific areas to expand (tests, deployment, CI config). I can iterate on examples or expand sections.
