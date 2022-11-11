FROM php:8.1-fpm-alpine3.15

RUN apk add --no-cache gcc g++ autoconf make pkgconfig git openssl libpng-dev libzip libzip-dev \
    libressl curl-dev zip unzip supervisor nginx bash \
    && docker-php-ext-install sockets

RUN docker-php-ext-install gd
RUN docker-php-ext-install zip
#&& docker-php-ext-install gd && docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENV COMPOSER_ALLOW_SUPERUSER=1

EXPOSE 8089