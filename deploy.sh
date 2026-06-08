#!/bin/bash
set -e

USER="dadeggbt"
HOST="199.188.201.180"
PORT="21098"
KEY="/Users/bigdaddy/.ssh/namecheap_migration_key"
TARGET="~/tlab.edfrica.org"

echo ">>> Syncing CODE files to Namecheap..."
rsync -avz -e "ssh -o StrictHostKeyChecking=no -i $KEY -p $PORT" \
  --include='app/***' \
  --include='resources/***' \
  --include='routes/***' \
  --include='database/***' \
  --include='config/***' \
  --include='public/' \
  --include='public/favicon.ico' \
  --include='public/favicon-48.png' \
  --include='public/favicon-32.png' \
  --include='public/manifest.json' \
  --include='public/index.php' \
  --include='public/.htaccess' \
  --include='public/build/***' \
  --include='public/css/***' \
  --include='public/js/***' \
  --include='public/images/***' \
  --include='composer.json' \
  --include='composer.lock' \
  --include='artisan' \
  --include='server_deploy.sh' \
  --include='bootstrap/***' \
  --exclude='bootstrap/cache/*' \
  --exclude='*' \
  ./ $USER@$HOST:$TARGET/

echo ">>> Migration of files complete!"
