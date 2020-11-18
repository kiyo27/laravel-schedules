FROM php:7.3-fpm

LABEL project=sb-participant-mgmt

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin

COPY --from=composer:1.9.1 /usr/bin/composer /usr/bin/composer

# COPY php.ini /usr/local/etc/php/

RUN apt-get update \
  && apt-get install -y \
  libzip-dev \
  libssl-dev \
  default-mysql-client \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  libpng-dev \
  && docker-php-ext-install \
  zip \
  pdo_mysql

WORKDIR /var/www
