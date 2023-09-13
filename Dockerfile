FROM php:8.2-fpm-alpine

FROM composer:2.0 as vendor

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install

RUN php ./cmd/queue
RUN php ./cmd/sent