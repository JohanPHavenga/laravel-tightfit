# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What This App Is

TightFit Garage Doors & Automation — a marketing/brochure website for a garage door business. It has static content pages, a contact form with queued email delivery and reCAPTCHA v3, and dynamic product galleries served from storage.

## Commands

```bash
# Start all dev services concurrently (PHP server + queue worker + log tail + Vite)
composer run dev

# Run individually
php artisan serve        # PHP dev server
npm run dev              # Vite with HMR
php artisan queue:work   # Process queued contact emails

# Build frontend for production
npm run build

# Run tests
php artisan test
php artisan test --filter ExampleTest   # Single test

# Code style (Laravel Pint)
vendor/bin/pint

# Database
php artisan migrate
php artisan migrate:fresh
```

## Architecture

**Routes** → **Controllers** → **Blade views** (no API layer, no Vue/React)

### Key Controllers

- [HomeController](app/Http/Controllers/HomeController.php) — renders home, about, manuals; serves manual PDFs from `storage/app/public/manuals/`
- [ContactController](app/Http/Controllers/ContactController.php) — contact form display, validation (including reCAPTCHA), and dispatching `SendContactEmail` job
- [GalleryController](app/Http/Controllers/GalleryController.php) — resolves `{type}/{product}` URL params to a storage directory, lists all files, passes them to `gallery.blade.php`

### Contact Form Flow

1. POST `/contact` → `ContactController@store` validates with `ReCaptchaV3` custom rule
2. Dispatches `SendContactEmail` job to the **database queue**
3. Job sends `ContactEmail` mailable to `tightfit@hermanus.co.za`
4. Redirects to `/success`

The queue must be running (`php artisan queue:work`) for emails to actually send in development.

### Gallery System

Images live under `storage/app/public/{type}/{product}/`. Valid `{type}` values are `garagedoors`, `doorautomation`, `gateautomation`. Optional `{product}` subdirectory (e.g. `nice`, `centurion`) filters images and sets a supplier URL. Run `php artisan storage:link` if the `public/storage` symlink is missing.

### Frontend Stack

- **Tailwind CSS v3** — primary styling (compiled via Vite from `resources/css/app.css`)
- **Alpine.js v3** — reactive behaviour, initialized in `resources/js/app.js`
- **Bootstrap + jQuery + Swiper** — legacy static assets in `public/css/` and `public/js/` (not through npm), included in `layouts/base.blade.php`

All public-facing pages extend `layouts/base.blade.php`. Auth pages use `layouts/guest.blade.php`. The dashboard and profile routes are commented out — Breeze auth is installed but not actively used.

### Environment Notes

- **Timezone:** `Africa/Johannesburg`
- **Queue/cache/session drivers:** all use `database` — requires migrations to be run
- **reCAPTCHA v3:** configured via `RECAPTCHA_SITE_KEY` and `RECAPTCHA_SECRET_KEY` in `.env`; uses the `biscolab/laravel-recaptcha` package
- **Mail:** SMTP — configure mailer credentials in `.env` (Mailtrap used in dev)
