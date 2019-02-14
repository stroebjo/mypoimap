FROM php:7.2-apache

RUN a2enmod rewrite

RUN apt-get update
RUN apt-get install -y vim zlib1g-dev libxml2-dev libfreetype6-dev libjpeg62-turbo-dev libmcrypt-dev libpng-dev imagemagick
RUN docker-php-ext-install mysqli pdo pdo_mysql zip soap
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install gd

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

# Install APCu
RUN pecl install apcu
RUN echo "extension=apcu.so" > /usr/local/etc/php/conf.d/apcu.ini
