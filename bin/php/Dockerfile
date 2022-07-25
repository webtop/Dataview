FROM php:8-fpm-alpine
LABEL MAINTAINER="Vagner Cardoso <vagnercardosoweb@gmail.com>"

# Environments
ENV TZ=America/Los_Angeles

# Updates and installs system dependencies
RUN apk add --update --no-cache \
  bash \
  tzdata \
  libxml2-dev \
  libpng-dev \
  libjpeg-turbo-dev \
  freetype-dev \
  postgresql-dev \
  libzip-dev \
  libxslt-dev \
  oniguruma-dev \
  $PHPIZE_DEPS && \
  rm -rf /var/cache/apk/*

# Install php dependencies
RUN docker-php-ext-install \
  bcmath \
  xml \
  mbstring \
  pdo \
  mysqli \
  pdo_mysql  \
  zip \
  opcache \
  intl \
  xsl \
  exif

# Install xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN /bin/bash /root/php-pdo-install.sh
