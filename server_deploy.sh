#!/bin/bash
set -e

echo ">>> Starting Server-side Deployment Tasks..."

if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate
fi

echo ">>> Installing dependencies..."
COMPOSER_CMD="composer"
if ! command -v composer &> /dev/null; then
    if [ ! -f composer.phar ]; then
        echo ">>> Composer not found. Downloading..."
        curl -sS https://getcomposer.org/installer | php
    fi
    COMPOSER_CMD="php composer.phar"
fi

for i in 1 2 3; do
    echo ">>> Composer install attempt $i..."
    if $COMPOSER_CMD install --optimize-autoloader --no-dev; then
        INSTALL_OK=1
        break
    fi
    echo ">>> Retrying in 3 seconds..."
    sleep 3
done

if [ -z "$INSTALL_OK" ]; then
    echo ">>> Composer install failed after 3 attempts. Aborting."
    exit 1
fi

echo ">>> Running migrations..."
php artisan migrate --force

echo ">>> Clearing caches..."
php artisan config:clear
php artisan view:clear
php artisan cache:clear
php artisan route:clear

echo ">>> Fixing storage link..."
if [ -L public/storage ]; then
    rm public/storage
fi
php artisan storage:link

echo ">>> Optimizing for production..."
php artisan optimize
php artisan event:cache

echo ">>> Server setup complete!"
