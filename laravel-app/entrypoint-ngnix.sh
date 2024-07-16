#!/bin/bash

# Wait for the database to be ready
until php artisan db:monitor --databases=mysql
do
    echo "Waiting for database connection..."
    sleep 10
done

# Run database migrations
php artisan migrate --force

# Start PHP-FPM
php-fpm -D

# Start Nginx
nginx -g 'daemon off;'
