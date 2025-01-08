#!/bin/sh

set -e

# Ensure Laravel environment is set
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Install Composer dependencies
composer install --no-interaction --prefer-dist

# Run migrations and seed the database
php artisan migrate --force
php artisan db:seed --force

# Generate the application key and clear caches
php artisan key:generate
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Install Node.js dependencies and build assets
npm install
npm run build

# Install npm-run-all globally (if not already installed)
npm install -g npm-run-all

# Start Laravel server
exec php artisan serve --host=0.0.0.0 --port=8000
