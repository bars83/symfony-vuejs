FROM php:7.3-fpm

RUN apt-get update && apt-get install -y \
        libpq-dev \
        openssl \
        git \
        unzip \
        libzip-dev \
        libicu-dev \
        g++ \
        zlib1g-dev \
        libfcgi0ldbl \
        && \
    docker-php-ext-configure intl && \
    docker-php-ext-install \
            pdo \
            pdo_pgsql \
            zip \
            intl \
            opcache && \
    docker-php-ext-enable \
        opcache


RUN rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

RUN pecl install apcu && docker-php-ext-enable apcu

COPY ./php.ini /usr/local/etc/php/php.ini
COPY ./ping.conf /usr/local/etc/php-fpm.d/ping.conf
COPY ./php-fpm.conf /usr/local/etc/php-fpm.d/www.conf

WORKDIR /var/www/html

ARG BUILD_TIME

ENV BUILD_TIME_ENV=$BUILD_TIME

#RUN pecl install xdebug-2.7.0 && docker-php-ext-enable xdebug

RUN mkdir -p /var/www/.composer && chown -R www-data:www-data /var/www/.composer

#HEALTHCHECK --interval=10s --timeout=3s \
#    CMD \
#    SCRIPT_NAME=/ping \
#    SCRIPT_FILENAME=/ping \
#    REQUEST_METHOD=GET \
#    cgi-fcgi -bind -connect 127.0.0.1:9000 || exit 1

USER www-data

CMD php-fpm