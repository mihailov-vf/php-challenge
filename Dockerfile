FROM composer:latest as composer

COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install -o \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist \
    --no-dev \
    --apcu-autoloader

FROM php:8.0-fpm

# Install Postgres client & Zip deps
RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
    && apt-get install -y libpq-dev postgresql-client \ 
    && apt-get install -y libzip-dev \
    && apt-get clean -y && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_pgsql
RUN docker-php-ext-install opcache
RUN docker-php-ext-install sockets
RUN docker-php-ext-install zip

RUN pecl install -s apcu \
    && docker-php-ext-enable apcu

COPY . /var/www/html
COPY --from=composer /app/vendor ./vendor

EXPOSE 8000

CMD [ "php", "-S", "0.0.0.0:8000", "-t", "public/" ]
