FROM php:8-apache

RUN apt-get -y update --fix-missing && \
    apt-get upgrade -y && \
    # Install useful tools
    apt-get -y install apt-utils nano wget dialog && \
    # Install important libraries
    apt-get -y install --fix-missing apt-utils build-essential git curl libcurl4 libcurl4-openssl-dev zip openssl && \
    # Composer
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    # Install xdebug
    pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    # Other PHP Extensions
    apt-get -y install zlib1g-dev && \
    apt-get -y install libicu-dev && \
    apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev && \
    # Enable the available sites
    ln -s /etc/apache2/sites-available/default /etc/apache2/sites-enabled/ && \
    # Enable apache modules
    a2enmod rewrite headers
