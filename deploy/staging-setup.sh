#!/bin/bash
# Run this ONCE on the server to set up staging
# ssh -p 21098 -i ~/.ssh/namecheap_migration_key dadeggbt@199.188.201.180

echo "Creating staging directory..."
mkdir -p ~/staging.tlab.edfrica.org

echo "Copying production files as base..."
cp -r ~/tlab.edfrica.org/* ~/staging.tlab.edfrica.org/

echo "Setting staging .env..."
cd ~/staging.tlab.edfrica.org
cp .env .env.prod.bak
# Update APP_URL for staging
sed -i 's|APP_URL=.*|APP_URL=https://staging.tlab.edfrica.org|' .env
sed -i 's|APP_ENV=.*|APP_ENV=staging|' .env

echo "Generating unique APP_KEY..."
php artisan key:generate

echo "Setting storage permissions..."
chmod -R 775 storage bootstrap/cache

echo "Staging ready!"
