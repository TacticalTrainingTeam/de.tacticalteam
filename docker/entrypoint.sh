#!/bin/sh

# Exit on error
set -e

# Start PHP-FPM in background
php-fpm -D

# Start Cron daemon
cron

# Run Laravel migrations
# -----------------------------------------------------------
# Ensure the database schema is up to date.
# -----------------------------------------------------------
php artisan migrate --force

# Clear and cache configurations
# -----------------------------------------------------------
# Improves performance by caching config and routes.
# -----------------------------------------------------------
php artisan config:cache
php artisan route:cache

# Start Nginx in foreground
nginx -g 'daemon off;'
