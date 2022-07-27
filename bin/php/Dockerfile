FROM webtop/php-8-pdo:latest
ENV TZ=America/Los_Angeles
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo_mysql
RUN pecl install xdebug
RUN docker-php-ext-enable pdo_mysql
## Enable the available sites
RUN ln -s /etc/apache2/sites-available/default /etc/apache2/sites-enabled/
RUN a2enmod rewrite
