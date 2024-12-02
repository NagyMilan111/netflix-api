#!/bin/sh

# Ensure Laravel environment is set
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Install Composer dependencies
composer install --no-interaction --prefer-dist

# Run migrations
php artisan migrate
php artisan db:seed

# Clear and optimize caches
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
npm run dev

# Serve Laravel application
php artisan serve --host=0.0.0.0 --port=8000
