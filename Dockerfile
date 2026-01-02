# Use PHP 8.2 FPM as the base image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx \
    cron

# Clear cache
RUN apt-get autoremove -y && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Use the recommended production PHP configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" && \
    sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 20M/g' "$PHP_INI_DIR/php.ini" && \
    sed -i 's/post_max_size = 8M/post_max_size = 20M/g' "$PHP_INI_DIR/php.ini"

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Copy existing application directory contents with correct permissions
COPY --chown=www-data:www-data . /var/www

# Install Composer and dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader --no-interaction --no-progress --prefer-dist

# Copy Nginx configuration
COPY docker/nginx.conf /etc/nginx/sites-available/default

# Add cron job
RUN echo "* * * * * www-data cd /var/www && php artisan schedule:run >> /dev/null 2>&1" >> /etc/cron.d/laravel-scheduler
RUN chmod 0744 /etc/cron.d/laravel-scheduler
RUN crontab /etc/cron.d/laravel-scheduler

# Make entrypoint script executable
RUN chmod +x /var/www/docker/entrypoint.sh

# Expose port 80
EXPOSE 80

# Start the application using entrypoint script
ENTRYPOINT ["/var/www/docker/entrypoint.sh"]
