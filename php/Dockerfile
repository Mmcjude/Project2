# Use the official PHP image with FPM
FROM php:8.3-fpm

# Use the default PHP configuration for development
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# Update the package list and install required libraries and PHP extensions
RUN apt-get update \
    && apt-get install -y \
        libpq-dev \ 
        libzip-dev \ 
        zip \
    && docker-php-ext-install \
        bcmath \
        zip \
        pdo \
        pdo_mysql

# Install Composer from Composer's official Docker image
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Install Node.js
RUN curl -sL https://deb.nodesource.com/setup_22.x | bash -
RUN apt-get install -y nodejs