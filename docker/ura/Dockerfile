FROM php:7.0-apache
COPY php.ini /usr/local/etc/php/
ENV DEBIAN_FRONTEND noninteractive
ENV PHP_MEMCACHED_VERSION php7

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
        libmemcached-dev \
        zlib1g-dev \
    && docker-php-ext-install -j$(nproc) iconv mcrypt pdo pdo_mysql \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

RUN apt-get -y install libmemcached11 libmemcachedutil2 libmemcached-dev git \
    && cd /usr/local/share \
    && git clone --branch php7 https://github.com/php-memcached-dev/php-memcached \
    && cd php-memcached \
    && phpize \
    && ./configure \
    && make \
    && echo "extension=/usr/local/share/php-memcached/modules/memcached.so" > /usr/local/etc/php/conf.d/memcached.ini

