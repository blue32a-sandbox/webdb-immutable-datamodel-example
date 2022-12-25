FROM php:8.2-fpm-alpine

RUN apk update \
    && apk add --update-cache --no-cache \
        git \
        zip \
        unzip

COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer
