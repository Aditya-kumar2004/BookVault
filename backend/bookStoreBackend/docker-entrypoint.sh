#!/bin/sh

# Run database migrations and seeders automatically
php artisan migrate --force
php artisan db:seed --force

# Cache configurations for speed in production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start PHP-FPM in background
php-fpm -D

# Start Nginx in foreground
nginx -g "daemon off;"
