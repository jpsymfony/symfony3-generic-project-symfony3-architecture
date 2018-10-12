FROM php:7.0-apache

# PHP extensions
ENV APCU_VERSION 5.1.7
RUN buildDeps=" \
        libicu-dev \
        zlib1g-dev \
    " \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
        $buildDeps \
        zlib1g \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install \
        intl \
        pdo_mysql \
        bcmath \
        mbstring \
        zip \
    && apt-get purge -y --auto-remove $buildDeps
RUN pecl install \
        apcu-$APCU_VERSION \
    && docker-php-ext-enable --ini-name 05-opcache.ini \
        opcache \
    && docker-php-ext-enable --ini-name 20-apcu.ini \
        apcu

COPY config/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN apt-get update && apt-get install -y g++

RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN mkdir -p /var/lib/php/sessions && chmod -R 777 /var/lib/php/sessions

COPY config/php.ini /usr/local/etc/php/

COPY config/apache_project.conf /etc/apache2/sites-available/apache_project.conf
RUN a2dissite 000-default
RUN a2ensite apache_project
RUN a2enmod rewrite

WORKDIR /var/www/project
