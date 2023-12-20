FROM php:fpm

# Install required dependencies
RUN apt-get update \
    && apt-get install -y \
    git \
    zip \
    unzip \
    libmagickwand-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    libmcrypt-dev \
    libxml2-dev \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

# Install and configure PHP extensions
RUN docker-php-ext-install opcache soap calendar sockets mysqli pdo pdo_mysql \
    && docker-php-ext-configure calendar \
    && pecl install apcu

# Copy Symfony project files
COPY ./Code/ /var/www/html

# Set working directory
WORKDIR /var/www/html

# Install dependencies using Composer
RUN composer install --no-dev --optimize-autoloader

# Run Symfony console commands 
RUN php bin/console doctrine:database:create && php bin/console doctrine:migrations:migrate --no-interaction