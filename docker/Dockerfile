FROM php:7.0-apache
ARG USER
ARG UID

# PHP extensions
ENV APCU_VERSION 5.1.12

RUN apt-get update && apt-get install -y zip zlib1g-dev libicu-dev libbz2-dev g++ libssl-dev vim libtool automake git pkg-config librabbitmq-dev libpng-dev libjpeg62-turbo-dev libfreetype6-dev wget libmagickwand-dev locales locales-all curl software-properties-common gnupg acl

ENV LANG fr_FR.UTF-8
ENV LC_ALL fr_FR.UTF-8

RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install intl
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install zip
RUN docker-php-ext-install pcntl
RUN docker-php-ext-install bz2
RUN docker-php-ext-install hash
RUN docker-php-ext-install json
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install -j$(nproc) gd

RUN pecl install imagick && docker-php-ext-enable imagick
RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN pecl install mongodb-1.4.4 && docker-php-ext-enable mongodb
RUN pecl install apcu-$APCU_VERSION && docker-php-ext-enable --ini-name 05-opcache.ini opcache && docker-php-ext-enable --ini-name 20-apcu.ini apcu

# Install Java
RUN mkdir -p /usr/share/man/man1/ && apt-get install default-jre -y

COPY config/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN mkdir -p /var/lib/php/sessions && chmod -R 777 /var/lib/php/sessions

COPY config/php.ini /usr/local/etc/php/

COPY config/apache_project.conf /etc/apache2/sites-available/apache_project.conf
RUN a2dissite 000-default
RUN a2ensite apache_project
RUN a2enmod rewrite

RUN groupadd -f -g $UID $USER && \
    useradd -u $UID -g $USER $USER && \
    mkdir -p /home/$USER && \
    chown -R $USER:$USER /home/$USER

USER $USER

ENV APACHE_RUN_USER $USER
ENV APACHE_RUN_GROUP www-data

USER root

CMD apachectl -D FOREGROUND

