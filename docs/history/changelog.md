# Changelog

## 2026-10-14 — Contact submissions are stored; stuck enquiries recoverable; auth and storage cleanup

Plan: [docs/planning/contact-submissions-and-cleanup-prompt.md](../planning/contact-submissions-and-cleanup-prompt.md)

### Why

Production's `jobs` table held 56 `SendContactEmail` jobs (queue `tightfit`, attempts 0, 2026-04-22 to 2026-10-09). Two were Johan's tests; 54 were real customer enquiries, and none had been emailed. The jobs table was the only copy of them. Three production causes:

1. The deployed controller still dispatched with `->onQueue('tightfit')` (removed in `03206c8` but never deployed). The worker only listens on `default`. *Fixed on the server.*
2. The `tightfit.service` systemd unit had `WorkingDirectory=/var/www/harmonieprop.co.za`, so no Tightfit worker ran at all. *Fixed on the server.*
3. Mail was sent **from** `tightfit@hermanus.co.za`, an ISP domain with `DMARC p=quarantine` whose SPF excludes SES. *Fixed in DNS/SES:* `tightfit.co.za` is DKIM-verified and production sends from `website@tightfit.co.za`.

### What shipped

- **`contact_submissions` table and `ContactSubmission` model.** Every form submission is stored (raw message, ip, user agent, `source`) **before** the job is dispatched. `emailed_at` / `emailed_via` record delivery.
- **`SendContactEmail`** takes the model. It sends to `config('mail.contact.to')` (`MAIL_TO_ADDRESS`, default `tightfit@hermanus.co.za`), stamps `emailed_at`, and skips an already-sent submission. `$tries = 3`, `$backoff = [60, 300]`, `default` queue.
- **`ContactEmail`:**
  - The From address comes from mail config, with no `env()` call (production failed job 3 was `env()` returning null under cached config). replyTo is still the customer.
  - The subject is `Website enquiry from {name}`, and the submission date (SAST) is shown.
  - **Fixed HTML injection**: the message is stored raw and escaped with `nl2br(e())`.
- **`php artisan contact:import-queued`** moves old-shape jobs into `contact_submissions` (`source=queue_backlog`, original timestamp, `<br />` stripped) and deletes the job rows. It never loads the job class, is idempotent, and has `--dry-run`.
- **`php artisan contact:send-backlog-summary`** sends one summary email of every unsent submission to the owner and stamps them `backlog_summary`. Options: `--exclude-email=*`, `--preview-to=` (stamps nothing) and `--dry-run`.
- **Breeze auth removed.** `/login`, `/register` and the related pages are gone, which also removes the `Route [dashboard] not defined` errors. `laravel/breeze` is uninstalled. The `users` table and `User` model stay.
- **`public/storage/` untracked and git-ignored.** It held 9 old JPGs that blocked `storage:link`.
- **Manuals** removed from the desktop, mobile and footer menus. The route stays.
- **Tests now run on sqlite `:memory:`**, not the local MySQL DB.
- `.env.example`: MySQL `tightfit`, `APP_TIMEZONE=Africa/Johannesburg`, `MAIL_FROM_ADDRESS=website@tightfit.co.za`, `MAIL_FROM_NAME="TightFit Website"`, `MAIL_TO_ADDRESS`. The `mail.from` fallbacks in `config/mail.php` match.
- `CLAUDE.md` rewritten. It no longer mentions reCAPTCHA (replaced by the honeypot on purpose), and it documents the contact flow, mail rules, gallery location and production worker.

Departure from the plan: the plan named the recipient config `mail.to.address`. Laravel treats `mail.to` as a global "always send to" override: as written it crashes every send (it has no `name`), and with a name it would redirect `--preview-to` to the owner. The recipient lives at `mail.contact.to` instead, still set by `MAIL_TO_ADDRESS`.

### Files

- Added:
  - `database/migrations/2026_10_14_000000_create_contact_submissions_table.php`
  - `app/Models/ContactSubmission.php`
  - `app/Mail/ContactBacklogSummary.php`
  - `resources/views/emails/backlog-summary.blade.php`
  - `app/Console/Commands/ImportQueuedContactEmails.php`
  - `app/Console/Commands/SendContactBacklogSummary.php`
- Changed:
  - `app/Http/Controllers/ContactController.php`
  - `app/Jobs/SendContactEmail.php`
  - `app/Mail/ContactEmail.php`
  - `resources/views/emails/contact.blade.php`, `contact-text.blade.php` and `header.blade.php`
  - `config/mail.php`, `routes/web.php`, `resources/views/layouts/base.blade.php`
  - `phpunit.xml`, `.env.example`, `.gitignore`, `composer.json`, `composer.lock`, `CLAUDE.md`
  - `tests/TestCase.php` (`withoutVite()`, so page tests don't need `npm run build`)
- Deleted:
  - `routes/auth.php`
  - `app/Http/Controllers/Auth/*`, `ProfileController`, `app/Http/Requests/*`
  - `AppLayout` and `GuestLayout` components
  - Breeze views (`auth/`, `profile/`, `dashboard`, `welcome`, `layouts/app|guest|navigation`) and 13 Breeze Blade components
  - the unused `partials/slider.blade.php`
  - `tests/Feature/Auth/*`, `tests/Feature/ProfileTest.php`
  - `public/storage/*`

### Tests added

- `tests/Feature/ContactFormTest.php`: the submission is persisted and queued on `default`, validation, HTML escaping in the email.
- `tests/Feature/SendContactEmailTest.php`: send and stamp, idempotent, From address taken from config.
- `tests/Feature/ImportQueuedContactEmailsTest.php`: imports a real old-shape payload (`tests/Fixtures/old-send-contact-email-payload.json`, serialised by the pre-change job class), idempotency, `--dry-run`.
- `tests/Feature/SendContactBacklogSummaryTest.php`: preview, real send with exclusions and stamping, dry run, failure when there is nothing to send.
- `tests/Feature/PublicPagesTest.php`: `/login` and `/register` return 404, public pages smoke test, no `/manuals` link.

### Still to do (not in this change)

- Deploy, then on production: `php artisan migrate`, `contact:import-queued`, `contact:send-backlog-summary --preview-to=… --exclude-email=…`, then the real send.
- The manuals link bug (`url($file)` in `HomeController::manuals()`), Sentry, deploy scripts.

## 2026-10-14 — Sentry on production only

- Added sentry/sentry-laravel; `Integration::handles($exceptions)` in bootstrap/app.php. DSN set only in the production .env (`SENTRY_LARAVEL_DSN`, `SENTRY_SEND_DEFAULT_PII=true`); local leaves it blank. `SENTRY_RELEASE` comes from deploy/deploy.sh (git SHA) and must never be put in .env. No config/sentry.php: the package defaults apply.
