FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    zip unzip git curl libzip-dev libpng-dev libjpeg-dev libfreetype6-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd zip pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Copy the entrypoint script
COPY netflix-api/docker/entrypoint.sh /usr/local/bin/entrypoint.sh

# Ensure necessary directories exist and set permissions
RUN mkdir -p /var/www/html/netflix-api/bootstrap/cache /var/www/html/netflix-api/storage && \
    chown -R www-data:www-data /var/www/html/netflix-api/bootstrap/cache /var/www/html/netflix-api/storage

# Make entrypoint executable
RUN chmod +x /usr/local/bin/entrypoint.sh

# Expose port 8000
EXPOSE 8000

# Use the entrypoint script
ENTRYPOINT ["sh", "/usr/local/bin/entrypoint.sh"]
