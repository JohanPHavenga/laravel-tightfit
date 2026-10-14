#!/usr/bin/env bash
#
# Deploy Tightfit (tightfit.co.za) on Denver.
#
# Deliberately simple: an in-place git checkout behind a short maintenance
# window (about a minute, while Composer and the Vite build run). No release
# directories and no symlink flip — deploys are rare and a little downtime is
# acceptable. If a deploy fails part-way, the site STAYS in maintenance mode
# rather than serving half-updated code.
#
# Runs ON THE SERVER, from the checkout itself. Trigger it from WSL with:
#
#     ./bin/deploy            # deploys main
#     ./bin/deploy some-branch
#
# The whole body is ONE brace group, closed by `exit` on the last line. bash
# then reads the entire script into memory before running any of it, so the
# `git reset --hard` below can safely rewrite this very file mid-run (bash
# otherwise reads scripts incrementally by byte offset). A change to this file
# therefore takes effect on the deploy AFTER the one that ships it.
# Keep every new line INSIDE the braces.
set -euo pipefail
{

APP_DIR=/var/www/tightfit.co.za
BRANCH="${1:-main}"
cd "$APP_DIR"

echo "→ Preflight"
for bin in git php composer node npm; do
  command -v "$bin" >/dev/null 2>&1 || { echo "  ✗ $bin not found on PATH"; exit 1; }
done
[ -f .env ]  || { echo "  ✗ $APP_DIR/.env is missing"; exit 1; }
[ -d .git ]  || { echo "  ✗ $APP_DIR is not a git checkout yet — do the one-time server setup first"; exit 1; }
echo "  ✓ php $(php -r 'echo PHP_VERSION;'), node $(node -v)"

trap 'echo; echo "✗ Deploy FAILED at line $LINENO — the site is still in maintenance mode."; echo "  Fix the cause and deploy again. Only if you know the site is in a working state:"; echo "  cd $APP_DIR && php artisan up"' ERR

echo "→ Maintenance mode on"
php artisan down --retry=60 || echo "  ⚠ could not enable maintenance mode — continuing"

echo "→ Code → origin/$BRANCH"
git fetch --depth 1 origin "$BRANCH"
git reset --hard FETCH_HEAD
echo "  now at $(git log -1 --format='%h %s')"

# Tags Sentry events with the exact commit once sentry/sentry-laravel is
# installed (config/sentry.php reads env('SENTRY_RELEASE')). Exported BEFORE
# the config cache below so it gets baked in. Keep SENTRY_RELEASE OUT of .env —
# a variable already in the shell environment wins over .env.
SENTRY_RELEASE="$(git rev-parse HEAD)"
export SENTRY_RELEASE

echo "→ Composer (no-dev, optimised)"
composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction

echo "→ Front-end build"
npm ci --no-audit --no-fund
npm run build

echo "→ Migrate"
php artisan migrate --force

echo "→ Rebuild caches"
php artisan storage:link >/dev/null 2>&1 || true
php artisan optimize:clear
php artisan optimize

echo "→ Restart queue worker (it exits after its current job; systemd unit tightfit.service brings it back)"
php artisan queue:restart

echo "→ Reload PHP-FPM (clears OPcache)"
sudo -n systemctl reload php8.4-fpm 2>/dev/null \
  || echo "  ⚠ could not reload php8.4-fpm without a password — check /etc/sudoers.d/nitro-reload"

echo "→ Maintenance mode off"
php artisan up

trap - ERR
echo "✓ Deployed $(git log -1 --format='%h %s')"
exit 0
}
