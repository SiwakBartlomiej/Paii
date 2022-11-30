FROM php:8.0-apache

RUN apt-get update \
 && apt-get install -y git zlib1g-dev libzip-dev libicu-dev libxml2-dev \
 && docker-php-ext-configure intl \
 && docker-php-ext-install zip pdo pdo_mysql intl \
 && a2enmod rewrite \
 && sed -i 's!/var/www/html!/var/www/public!g' /etc/apache2/sites-enabled/000-default.conf

COPY . /var/www

WORKDIR /var/www