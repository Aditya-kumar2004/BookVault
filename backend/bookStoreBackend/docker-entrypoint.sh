#!/bin/sh

# Run database migrations and seeders automatically
php artisan migrate --force
php artisan db:seed --force

# Cache configurations for speed in production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Fix permissions on storage and bootstrap cache directories so PHP-FPM has access
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Start PHP-FPM in background
php-fpm -D

# Start Nginx in foreground
nginx -g "daemon off;"
