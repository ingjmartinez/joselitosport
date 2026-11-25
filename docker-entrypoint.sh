#!/bin/sh
set -eu

cd /var/www/html

if [ -z "${APP_KEY:-}" ]; then
    printf '%s\n' 'APP_KEY is required. Set a persistent application key in Dokploy.' >&2
    exit 1
fi

mkdir -p \
    bootstrap/cache \
    storage/app/private \
    storage/app/public \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs

if [ "${DB_CONNECTION:-mysql}" = 'sqlite' ]; then
    export DB_DATABASE="${DB_DATABASE:-/var/www/html/storage/database/database.sqlite}"

    case "$DB_DATABASE" in
        /*) ;;
        *)
            printf '%s\n' 'DB_DATABASE must be an absolute path for SQLite.' >&2
            exit 1
            ;;
    esac

    mkdir -p "$(dirname "$DB_DATABASE")"

    if [ ! -e "$DB_DATABASE" ]; then
        touch "$DB_DATABASE"
    fi

    chown www-data:www-data "$DB_DATABASE" "$(dirname "$DB_DATABASE")"
    chmod ug+rw "$DB_DATABASE"
fi

chown -R www-data:www-data storage bootstrap/cache
chmod -R ug+rwX storage bootstrap/cache

su -s /bin/sh -c 'php artisan config:clear --no-interaction' www-data

if [ "${RUN_MIGRATIONS:-true}" = 'true' ]; then
    su -s /bin/sh -c 'php artisan migrate --force --no-interaction' www-data
fi

php artisan storage:link --force --no-interaction
su -s /bin/sh -c 'php artisan optimize --no-interaction' www-data

exec docker-php-entrypoint "$@"
