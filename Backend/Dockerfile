FROM php:8.0.3-apache-buster

COPY  /config/apache.conf /etc/apache2/sites-available/000-default.conf

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install bcmath

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip


RUN docker-php-ext-install zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html
