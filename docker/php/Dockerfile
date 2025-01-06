FROM php:8.1-fpm

# Install required dependencies and PHP extensions
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev git unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy custom PHP configuration files
COPY php.ini /usr/local/etc/php/

# Copy custom PHP-FPM config
COPY www.conf /usr/local/etc/php-fpm.d/

# Set the working directory
WORKDIR /var/www/html
