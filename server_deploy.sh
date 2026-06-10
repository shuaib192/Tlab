#!/bin/bash
set -e

echo ">>> Starting Server-side Deployment Tasks..."

if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate
fi

echo ">>> Installing dependencies..."
if command -v composer &> /dev/null; then
    composer install --optimize-autoloader --no-dev
elif [ -f composer.phar ]; then
    php composer.phar install --optimize-autoloader --no-dev
else
    echo ">>> Composer not found. Downloading..."
    curl -sS https://getcomposer.org/installer | php
    php composer.phar install --optimize-autoloader --no-dev
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
