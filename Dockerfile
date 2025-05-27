# Dockerfile

FROM node:20 as build-stage

WORKDIR /var/www

# Install npm dependencies & build Vite
COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build

# Laravel dependencies stage
FROM php:8.2-fpm

# Install dependencies (intl, zip)
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev libzip-dev zlib1g-dev libicu-dev mariadb-client

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd intl zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project from build-stage
WORKDIR /var/www
COPY --from=build-stage /var/www /var/www

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expose PHP-FPM port
EXPOSE 9000

CMD ["php-fpm"]
