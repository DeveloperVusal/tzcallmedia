FROM php:8.1-fpm

RUN apt-get update && apt-get install -y git curl libmcrypt-dev default-mysql-client
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /app
COPY . .

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --ignore-platform-reqs