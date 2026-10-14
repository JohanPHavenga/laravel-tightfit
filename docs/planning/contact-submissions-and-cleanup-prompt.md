> **Recommended model:** Sonnet (a migration, a model, two artisan commands and a few small, fully-specified cleanups in one small app. The design is already settled.)

# Tightfit: keep a record of every contact submission, recover the 56 stuck enquiries, and clean up

## §0 Before you write any code

1. Save this prompt as `docs/planning/contact-submissions-and-cleanup-prompt.md` and commit it with the change-set.
2. Read `CLAUDE.md`. Parts of it are **wrong** (see §5), so trust this prompt where they disagree.
3. **Reproduce first.** Before changing anything, write the test from §6 row 1 ("a contact submission is persisted") and the one from row 6 ("the message is HTML-escaped in the email"). Show me both failing against the current code.
4. Summarise your plan in a few lines, list every file you intend to **delete** in §4.E, and **wait for my green light**.

## §1 Evidence (from production, 2026-10-14)

- `jobs` on production holds **56 `App\Jobs\SendContactEmail` rows on queue `tightfit`, attempts 0**, from 2026-04-22 to 2026-10-09. The first two are Johan's own tests; the other 54 are real customers. **None was ever emailed.**
- Two causes, both already fixed **on the server** (no code needed for them):
  - The deployed controller still had `->onQueue('tightfit')` (`03206c8` removed it, but was never deployed). The worker only listens on `default`.
  - The `tightfit.service` systemd unit had `WorkingDirectory=/var/www/harmonieprop.co.za`, so no Tightfit worker existed at all.
- A third cause: mail was sent **from** `tightfit@hermanus.co.za`, an ISP domain with `DMARC p=quarantine` whose SPF excludes SES. That has been fixed in DNS/SES: `tightfit.co.za` is verified with DKIM, and production's `MAIL_FROM_ADDRESS` becomes `website@tightfit.co.za`. **The recipient stays `tightfit@hermanus.co.za`** (that's where the owner, Ben, reads mail).
- The `jobs` table was the only place these enquiries existed. There is **no durable record of contact submissions**: a job row disappears as soon as it's processed.
- Production log: `Route [dashboard] not defined` (userId 1, 12 and 18 May). Breeze's `routes/auth.php` is still required, so `/login` and `/register` are live, and login redirects to a route that no longer exists. Auth is not used on this site.
- `public/storage/` is a **real directory committed to git** (7 old gallery JPGs), and the same on the server. It blocks `php artisan storage:link`. Nothing references `/storage/…` URLs: the gallery reads `public/images/gallery/`.

## §2 Root causes (confirmed in the code)

| # | Where | Problem |
|---|---|---|
| R1 | `ContactController::store()` | Dispatches the job with an array. Nothing is persisted, so a lost job means a lost enquiry. |
| R2 | `ContactController::store()` + `emails/contact.blade.php` | The controller stores `nl2br($message)` and the view prints it with `{!! $mail_message !!}`, so **a visitor can inject HTML into the email Ben receives.** |
| R3 | `SendContactEmail::handle()` | The recipient `tightfit@hermanus.co.za` is hardcoded. |
| R4 | `ContactEmail::envelope()` | `env('MAIL_FROM_ADDRESS') ?? config(...)`. Once config is cached (the new deploy runs `php artisan optimize`), `env()` returns null outside `config/`. Failed job 3 on production was exactly this: `Address::__construct(): Argument #1 must be of type string, null given`. |
| R5 | `routes/web.php` | `require __DIR__.'/auth.php'` exposes unused Breeze auth (open registration, and a login that 500s). |
| R6 | git | `public/storage/` is tracked, and `/public/storage` is missing from `.gitignore`. |
| R7 | `phpunit.xml` | The sqlite `:memory:` lines are commented out, so tests run against the **local MySQL DB**. That DB will hold a copy of production data, including these submissions. Any `RefreshDatabase` test would wipe it. |

## §3 Decisions already made (do not reopen)

- reCAPTCHA was **dropped on purpose** in favour of `spatie/laravel-honeypot`. Leave the spam protection as it is.
- The backlog goes to Ben as **one summary email**, not 54 individual ones.
- Manuals: **remove it from the menus only**. Leave the route, controller and view in place.
- Auth: **remove it entirely.** Keep the `users` table migration (it's harmless, and production has already run it).

## §4 Changes

### A. `contact_submissions` table and `ContactSubmission` model

Migration columns:
- `id`
- `name` (string)
- `email` (string)
- `subject` (string, nullable)
- `message` (text): the **raw** text the visitor typed, never `nl2br`'d or HTML
- `ip` (string 45, nullable)
- `user_agent` (string 512, nullable, truncate to fit)
- `source` (string 20; `form` or `queue_backlog`)
- `emailed_at` (timestamp, nullable)
- `emailed_via` (string 20, nullable; `individual` or `backlog_summary`)
- `timestamps()`
- an index on `emailed_at`

The model casts `emailed_at` to a datetime and has a `scopeUnsent()`.

### B. Controller and job

- `ContactController::store()`: keep the existing validation and honeypot. Add `max:` limits that fit the columns (name 255, email 255, message 10000). **Create the `ContactSubmission` first** (with `source=form`, ip and user agent), **then** `SendContactEmail::dispatch($submission)`. No `onQueue()`: the worker listens on `default`.
- `SendContactEmail` takes the `ContactSubmission` (`SerializesModels`). In `handle()`:
  - send `ContactEmail` to `config('mail.to.address')`
  - then set `emailed_at = now()` and `emailed_via = individual`
  - skip silently if `emailed_at` is already set (so a retry is idempotent)
  - `$tries = 3`, `$backoff = [60, 300]`
- `config/mail.php`: add `'to' => ['address' => env('MAIL_TO_ADDRESS', 'tightfit@hermanus.co.za')]`.

### C. `ContactEmail`

- Remove the explicit `from:` from the envelope: the mailer's global `from` config already applies, and that is what fixes R4. Keep `replyTo` set to the customer.
- Subject: `Website enquiry from {name}`, set on the server side. The hidden `subject` input stays in the form and is stored, but it no longer controls the email subject.
- Pass the raw message to the views. HTML view: `{!! nl2br(e($mail_message)) !!}`. Text view: plain `{{ }}` is wrong for a text part, so use `{!! $mail_message !!}` (the text part is never rendered as HTML).
- Add a line with the submission date (`Africa/Johannesburg`).

### D. Recovering the backlog: two artisan commands

**`contact:import-queued {--queue=tightfit} {--dry-run}`**
- Reads the `jobs` rows on that queue whose payload `displayName` is `App\Jobs\SendContactEmail`.
- **The payloads are in the OLD shape** (an array in `$incoming`; `message` is already `nl2br`'d). Decode with `unserialize($command, ['allowed_classes' => false])` and read the `incoming` key off `(array)` of the incomplete object. **Never** instantiate the job class (its shape changes in §4.B).
- For each row, in one DB transaction per row:
  - create a `ContactSubmission` with `source=queue_backlog`, the message cleaned by stripping `<br>`/`<br />` (it's already followed by a newline) and decoding nothing else
  - set `created_at` = the job's `created_at` (unix timestamp → datetime)
  - `emailed_at` null
  - then **delete that `jobs` row**
- Idempotent: skip a row if a submission with the same email, `created_at` and message already exists (and still delete the job).
- Print a table of date | name | email. `--dry-run` prints the table and writes nothing.

**`contact:send-backlog-summary {--preview-to=} {--exclude-email=*} {--dry-run}`**
- Collects `ContactSubmission::unsent()` oldest first, minus any `--exclude-email` (Johan will exclude his own two tests).
- Sends **one** `ContactBacklogSummary` mailable to `config('mail.to.address')`. Content:
  - a short, neutral apology/explanation for Ben (e.g. *"Because of a website fault, the following enquiries submitted between {first} and {last} were not delivered at the time. They are listed oldest first."*)
  - then each submission: date, name, email as a `mailto:` link, and the message, escaped with `nl2br(e())`
  - no `replyTo`
- After a successful real send, stamp each included row `emailed_at=now()` and `emailed_via=backlog_summary`.
- `--preview-to=addr` sends the same email **to that address only and stamps nothing**. `--dry-run` prints the count and the list and sends nothing.
- Exit non-zero with a message if there's nothing to send.

### E. Remove the Breeze auth surface

- Remove `require __DIR__.'/auth.php'` and delete `routes/auth.php`, `app/Http/Controllers/Auth/*` and `ProfileController`.
- Delete the auth Requests, the Breeze-only views (`auth/`, `profile/`, `dashboard.blade.php`, `welcome.blade.php`, `layouts/app.blade.php`, `layouts/guest.blade.php`, `layouts/navigation.blade.php`) and their `View\Components` classes, and the Breeze-only Blade components.
- **Grep before deleting:** `x-base-layout`, `x-toast`, `partials/*` and anything the public pages or the emails use must stay. List what you will delete in §0 step 4.
- Delete `tests/Feature/Auth/*` and `tests/Feature/ProfileTest.php`.
- `composer remove laravel/breeze` (it sits in `require`; nothing at runtime needs it).
- Keep the `users` migration and `App\Models\User`.

### F. Remaining fixes

- **Storage:** `git rm -r --cached public/storage` and delete it from the working tree, then add `/public/storage` to `.gitignore`. Do **not** run `storage:link` on my behalf beyond the local check.
- **Manuals:** remove the three menu links in `layouts/base.blade.php` (desktop nav, mobile nav, footer). Leave the route.
- **`phpunit.xml`:** uncomment `DB_CONNECTION=sqlite` and `DB_DATABASE=:memory:`.
- **`.env.example`:**
  - `DB_CONNECTION=mysql` with the `DB_*` lines uncommented (`DB_DATABASE=tightfit`)
  - `APP_TIMEZONE=Africa/Johannesburg`
  - `MAIL_FROM_ADDRESS="website@tightfit.co.za"`
  - `MAIL_FROM_NAME="TightFit Website"`
  - `MAIL_TO_ADDRESS="tightfit@hermanus.co.za"`
  - keep `MAIL_MAILER=log`
- Grep `app/ resources/ routes/` for any remaining `env(` outside `config/` and fix it.

## §5 Update `CLAUDE.md` (same commit)

- Contact form: **no reCAPTCHA (dropped on purpose); the Spatie honeypot is the spam protection.** Remove every reCAPTCHA reference.
- Contact flow: the submission is persisted to `contact_submissions`, then `SendContactEmail` goes on the `default` queue to `config('mail.to.address')`. `emailed_at` null means it has not been sent.
- Mail: sent **from** `website@tightfit.co.za`, because `tightfit.co.za` is verified with DKIM in SES eu-central-1. **Never send from `@hermanus.co.za`**: it's the ISP's domain, with `DMARC p=quarantine`. The recipient is `tightfit@hermanus.co.za` (`MAIL_TO_ADDRESS`).
- Gallery images live in `public/images/gallery/{type}/{product}` (committed), **not** in storage.
- Production worker: the systemd unit `tightfit.service` (`queue:work`, `default` queue, `Restart=always`).
- Auth removed. Manuals hidden from the menu.
- Tests use sqlite `:memory:`; never point them at the local MySQL DB.

## §6 Tests (PHPUnit, `tests/Feature`)

Disable the honeypot in the contact tests with `config(['honeypot.enabled' => false])`. Use `Queue::fake()` / `Mail::fake()` as appropriate.

| # | Test | Asserts |
|---|---|---|
| 1 | A contact submission is persisted | POST `/contact` creates one `contact_submissions` row (`source=form`, raw message) and pushes `SendContactEmail` on the `default` queue |
| 2 | Validation | Missing fields and an over-long message → redirect with errors, no row, no job |
| 3 | The job sends and stamps | `SendContactEmail` sends `ContactEmail` to `config('mail.to.address')` with replyTo the customer; `emailed_at` is set and `emailed_via=individual` |
| 4 | The job is idempotent | Already `emailed_at` → nothing is sent |
| 5 | The mailable needs no `env()` | With `config(['mail.from.address' => 'x@tightfit.co.za'])` the message's From is that address |
| 6 | The message is HTML-escaped in the email | A message containing `<a href="http://evil">x</a>` and a newline renders escaped in the HTML part, with a `<br />` |
| 7 | Import: old payload shape | Insert a `jobs` row built from a **real old-shape payload** (serialize an object with an `incoming` array, the way the old job did; hard-code the serialized string in a fixture) → one submission (`queue_backlog`), the `<br />` stripped, `created_at` = the job time, the job row deleted |
| 8 | Import is idempotent, and `--dry-run` writes nothing | |
| 9 | Summary: preview | `--preview-to` sends one mail to that address and stamps nothing |
| 10 | Summary: real send | Sends one mail to `mail.to.address` with every unsent row except the excluded emails, and stamps them `backlog_summary` |
| 11 | Auth is gone | `GET /login` and `GET /register` → 404 |
| 12 | Smoke | `/`, `/about`, `/contact`, `/gallery` and `/gallery/garagedoors` → 200, and the home page does not contain `/manuals` |

## §7 Out of scope

- **The manuals link bug.** `HomeController::manuals()` builds links with `url($file)` (`/manuals/...`) instead of `Storage::disk('public')->url($file)`, and production's `storage/app/public` is empty anyway. Leave it until the manuals return.
- Deploy scripts (`deploy/deploy.sh`, `bin/deploy`, `bin/pull-prod`). Those are being written separately on a branch, so don't create them.
- Sentry: a separate step after the first deploy.
- Running either command against production. Johan does that after the deploy.

## §8 Closing steps

1. `./vendor/bin/pint --dirty`, then `./vendor/bin/pint --dirty --test` (zero issues).
2. `php artisan test`: the full suite (it's small). Report any pre-existing failure rather than papering over it.
3. Create `docs/history/changelog.md` if it doesn't exist, and add a dated entry (2026-10-14): what shipped, files touched, tests added, and the three production causes from §1.
4. Commit (this prompt included), then **push once to `main`**. **Do not deploy.**
