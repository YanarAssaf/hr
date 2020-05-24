FROM php:7.4-fpm-alpine

WORKDIR /var/www

COPY composer.json composer.lock ./

RUN docker-php-ext-install pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-scripts --no-autoloader --no-dev

COPY . /var/www

RUN mkdir storage
RUN mkdir bootstrap/cache
RUN mkdir storage/framework
RUN mkdir storage/framework/cache
RUN mkdir storage/framework/views
RUN mkdir storage/framework/sessions
RUN composer dump-autoload --optimize

RUN chown -R www-data:www-data \
        /var/www/storage \
        /var/www/bootstrap/cache

RUN mv .env.prod .env
