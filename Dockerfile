FROM php:7.4.0-fpm-alpine
WORKDIR /www

RUN apk --update upgrade \
    && apk add --no-cache autoconf automake make gcc g++ icu-dev rabbitmq-c rabbitmq-c-dev

RUN pecl install amqp-1.9.4 \
    && pecl install apcu-5.1.17 \
    && pecl install xdebug-3.0.4

RUN docker-php-ext-install -j$(nproc) bcmath opcache intl pdo_mysql \
    && docker-php-ext-enable amqp apcu opcache xdebug

COPY etc/infrastructure/php/ /usr/local/etc/php/

RUN echo http://dl-2.alpinelinux.org/alpine/edge/community/ >> /etc/apk/repositories \
    && apk --no-cache add shadow \
    && usermod -u 1000 www-data  \
    && chown -R www-data:www-data /www/
