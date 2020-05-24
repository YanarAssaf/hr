FROM php:7.4-fpm-alpine

WORKDIR /var/www

COPY composer.json composer.lock ./

RUN docker-php-ext-install pdo_mysql 

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-scripts --no-autoloader --no-dev

COPY . /var/www



RUN mv .env.prod .env
