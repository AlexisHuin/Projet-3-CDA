FROM php:fpm

RUN apt-get update && apt-get install -y git zip unzip libmagickwand-dev libcurl4-openssl-dev pkg-config libssl-dev libmcrypt-dev libxml2-dev && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && php composer-setup.php --install-dir=/usr/local/bin --filename=composer && rm composer-setup.php && docker-php-ext-install opcache soap calendar sockets mysqli pdo pdo_mysql && docker-php-ext-configure calendar && pecl install apcu imagick && docker-php-ext-enable apcu opcache soap imagick sockets
