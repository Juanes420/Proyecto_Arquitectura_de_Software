#!/bin/sh
set -e

echo "==> GameVault: Starting container..."

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    echo "==> Generating application key..."
    php artisan key:generate --force
fi

# Cache configuration for production
echo "==> Caching config, routes and views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
echo "==> Running migrations..."
php artisan migrate --force

# Link storage
php artisan storage:link --force 2>/dev/null || true

echo "==> GameVault ready!"

exec "$@"
