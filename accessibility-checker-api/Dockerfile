FROM php:8.5-fpm-alpine

RUN apk add --no-cache git
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --prefer-dist