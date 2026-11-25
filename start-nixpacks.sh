#!/usr/bin/env bash
set -euo pipefail

cd /app

mkdir -p \
    bootstrap/cache \
    storage/app/private \
    storage/app/public \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/testing \
    storage/framework/views \
    storage/logs

chmod -R ug+rwX storage bootstrap/cache

php artisan config:clear --no-interaction

node /assets/scripts/prestart.mjs \
    /assets/nginx.template.conf \
    /nginx.conf

php-fpm -y /assets/php-fpm.conf &
exec nginx -c /nginx.conf
