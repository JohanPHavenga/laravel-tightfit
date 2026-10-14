# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What This App Is

TightFit Garage Doors & Automation — a marketing/brochure website for a garage door business. It has static content pages, a contact form whose submissions are stored and emailed via the queue, and product galleries served from `public/images/gallery/`.

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

# Run tests (sqlite :memory:, see below)
php artisan test
php artisan test --filter ContactFormTest   # Single test class

# Code style (Laravel Pint)
vendor/bin/pint

# Database
php artisan migrate
php artisan migrate:fresh

# One-off recovery of contact enquiries stuck in the jobs table (see below)
php artisan contact:import-queued --dry-run
php artisan contact:send-backlog-summary --dry-run
```

## Architecture

**Routes** → **Controllers** → **Blade views** (no API layer, no Vue/React)

### Key Controllers

- [HomeController](app/Http/Controllers/HomeController.php) — renders home, about, manuals; serves manual PDFs from `storage/app/public/manuals/`
- [ContactController](app/Http/Controllers/ContactController.php) — contact form display, validation, persisting the submission and dispatching `SendContactEmail`
- [GalleryController](app/Http/Controllers/GalleryController.php) — resolves `{type}/{product}` URL params to a directory under `public/images/gallery/`, lists all files, passes them to `gallery.blade.php`

### Contact Form Flow

1. POST `/contact` → `ContactController@store`. Spam protection is the **Spatie honeypot** (`spatie/laravel-honeypot`, `<x-honeypot />` in the form). There is **no reCAPTCHA**: it was dropped on purpose.
2. The submission is persisted to `contact_submissions` (`ContactSubmission` model, `source=form`, raw message text).
3. `SendContactEmail` (takes the model) is dispatched on the **`default`** queue (database driver). Never add `onQueue()`: the worker only listens on `default`.
4. The job sends `ContactEmail` to `config('mail.contact.to')`, then stamps `emailed_at` / `emailed_via=individual`. **`emailed_at` null means the enquiry has not been emailed.** The job is idempotent.
5. Redirects back to `/contact` with a success toast.

The queue must be running (`php artisan queue:work`) for emails to actually send in development.

The message is stored raw and escaped when rendered (`nl2br(e())` in the HTML part). Never `nl2br` before storing or print it with unescaped `{!! !!}` in HTML.

### Mail

- Sent **from** `website@tightfit.co.za` (`MAIL_FROM_ADDRESS`), because `tightfit.co.za` is verified with DKIM in SES eu-central-1. **Never send from `@hermanus.co.za`**: it's the ISP's domain, with `DMARC p=quarantine`.
- The recipient is `tightfit@hermanus.co.za` (`MAIL_TO_ADDRESS` → `config('mail.contact.to')`), where the owner, Ben, reads mail. It is not under `mail.to`: Laravel treats a top-level `mail.to` as "send every email to this address".
- Mailables take the From address from `config('mail.from')`. Never call `env()` outside `config/`: config is cached in production, so `env()` returns null.

### Backlog recovery commands

- `contact:import-queued {--queue=tightfit} {--dry-run}` moves old-shape `SendContactEmail` jobs (array payload) from the `jobs` table into `contact_submissions` (`source=queue_backlog`) and deletes each job. It is idempotent.
- `contact:send-backlog-summary {--preview-to=} {--exclude-email=*} {--dry-run}` sends every unsent submission to the owner as **one** `ContactBacklogSummary` email and stamps them `emailed_via=backlog_summary`. `--preview-to` sends to that address only and stamps nothing.

### Gallery System

Images live in `public/images/gallery/{type}/{product}/` (committed to git), **not** in storage. Valid `{type}` values are `garagedoors`, `doorautomation`, `gateautomation`. Optional `{product}` subdirectory (e.g. `nice`, `centurion`) filters images and sets a supplier URL.

`public/storage` is git-ignored; it is only the `storage:link` symlink (used by the manuals).

### Frontend Stack

- **Tailwind CSS v3** — primary styling (compiled via Vite from `resources/css/app.css`)
- **Alpine.js v3** — reactive behaviour, initialized in `resources/js/app.js`
- **Bootstrap + jQuery + Swiper** — legacy static assets in `public/css/` and `public/js/` (not through npm), included in `layouts/base.blade.php`

All public-facing pages use `<x-base-layout>` (`layouts/base.blade.php`).

**Auth is removed**: Breeze, its routes, controllers and views are gone. The `users` migration and `App\Models\User` remain (harmless, already migrated in production).

**Manuals** are hidden from the menus; the `/manuals` route, controller and view still exist.

### Production

- Queue worker: the systemd unit `tightfit.service` (`php artisan queue:work`, `default` queue, `Restart=always`).

### Environment Notes

- **Timezone:** `Africa/Johannesburg`
- **Queue/cache/session drivers:** all use `database` — requires migrations to be run
- **Local DB:** MySQL `tightfit`, which may hold a copy of production data
- **Tests** use sqlite `:memory:` (set in `phpunit.xml`). Never point them at the local MySQL DB: `RefreshDatabase` would wipe it.
