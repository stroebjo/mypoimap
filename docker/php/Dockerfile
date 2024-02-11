FROM php:8.3-apache

RUN a2enmod rewrite

RUN apt-get update
RUN apt-get install -y vim libxml2-dev libfreetype6-dev libjpeg62-turbo-dev libmcrypt-dev libpng-dev imagemagick


RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev
RUN docker-php-ext-install zip

RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# ImageMagick
#RUN set -x \
#    && apk add --no-cache --virtual .phpize-deps $PHPIZE_DEPS imagemagick-dev libtool \
#    && pecl install imagick-3.4.1 \
#    && docker-php-ext-enable imagick \
#    && apk add --no-cache --virtual .imagick-runtime-deps imagemagick \
#    && apk del .phpize-deps

# ImageMagic - attempt2
#RUN apt-get install -y libmagickwand-dev
#RUN pecl install imagick-beta

# Install opcache
RUN docker-php-ext-install opcache

RUN docker-php-ext-install exif

# Intl (for NumberFormat etc.)
RUN apt-get update -y && apt-get install -y \
  zlib1g-dev libicu-dev g++ \
  && docker-php-ext-configure intl \
  && docker-php-ext-install intl

# Install APCu
RUN pecl install apcu
RUN echo "extension=apcu.so" > /usr/local/etc/php/conf.d/apcu.ini
