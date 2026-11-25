FROM php:8.3-apache-bookworm

ENV APP_ENV=production \
    APP_DEBUG=false \
    APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN apt-get update \
    && apt-get install -y --no-install-recommends libicu-dev libzip-dev unzip \
    && docker-php-ext-install -j"$(nproc)" intl opcache pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/* \
    && cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && printf '%s\n' \
        'expose_php=Off' \
        'opcache.enable=1' \
        'opcache.memory_consumption=128' \
        'opcache.interned_strings_buffer=16' \
        'opcache.max_accelerated_files=20000' \
        'opcache.validate_timestamps=0' \
        > "$PHP_INI_DIR/conf.d/production.ini" \
    && a2enmod rewrite \
    && sed -ri "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf \
    && printf '%s\n' \
        '<Directory /var/www/html/public>' \
        '    AllowOverride All' \
        '    Require all granted' \
        '    Options -Indexes +FollowSymLinks' \
        '</Directory>' \
        > /etc/apache2/conf-available/laravel.conf \
    && a2enconf laravel \
    && php -r 'foreach (["mbstring", "pdo_mysql", "pdo_sqlite", "intl", "zip"] as $extension) { if (! extension_loaded($extension)) { throw new RuntimeException("Missing extension: ".$extension); } }'

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./

RUN COMPOSER_ALLOW_SUPERUSER=1 composer install \
    --no-dev --prefer-dist --no-interaction --no-progress --no-scripts --no-autoloader

COPY . .

RUN mkdir -p bootstrap/cache storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs \
    && COMPOSER_ALLOW_SUPERUSER=1 composer install \
        --no-dev --prefer-dist --optimize-autoloader --no-interaction --no-progress \
    && composer check-platform-reqs --no-dev \
    && install -m 755 docker-entrypoint.sh /usr/local/bin/laravel-entrypoint

EXPOSE 80

HEALTHCHECK --interval=30s --timeout=5s --start-period=60s --retries=3 \
    CMD curl --fail --silent --show-error --output /dev/null http://127.0.0.1/up || exit 1

ENTRYPOINT ["laravel-entrypoint"]
CMD ["apache2-foreground"]
