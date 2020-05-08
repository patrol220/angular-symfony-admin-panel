FROM php:7.4-fpm

RUN apt-get update && \
apt-get install -y \
zlib1g-dev \
libzip-dev \
libpq-dev \
&& apt-get install -y -qq git curl wget

RUN docker-php-ext-install pdo_mysql pdo_pgsql

RUN pecl install apcu
RUN pecl install redis

RUN docker-php-ext-install zip
RUN docker-php-ext-enable apcu
RUN docker-php-ext-enable redis

RUN bash -c "wget http://getcomposer.org/composer.phar && mv composer.phar /usr/local/bin/composer"

WORKDIR /usr/src/app

COPY / /usr/src/app

RUN PATH=$PATH:/usr/src/apps/vendor/bin:bin
