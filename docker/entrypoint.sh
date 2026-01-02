#!/bin/sh

# Exit on error
set -e

# Start PHP-FPM in background
php-fpm -D

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

# Start Nginx in foreground
nginx -g 'daemon off;'
