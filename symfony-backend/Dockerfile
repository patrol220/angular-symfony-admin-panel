FROM php:7.4-fpm

RUN apt-get update && \
apt-get install -y \
zlib1g-dev \
libzip-dev \
libpq-dev \
libpng-dev \
unzip \
&& apt-get install -y -qq git curl wget

RUN docker-php-ext-install pdo_mysql pdo_pgsql

RUN pecl install apcu
RUN pecl install redis

RUN docker-php-ext-install gd
RUN docker-php-ext-install zip
RUN docker-php-ext-enable apcu
RUN docker-php-ext-enable redis

RUN docker-php-ext-configure gd --enable-gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /usr/src/app

RUN adduser dockeruser --disabled-login --disabled-password
USER dockeruser

COPY / /usr/src/app

RUN PATH=$PATH:/usr/src/apps/vendor/bin:bin
