FROM php:8.2-apache
WORKDIR /app
RUN rm -rf /var/www/html
RUN ln -s /app/public /var/www/html
RUN apt -y update && apt -y install libmcrypt-dev openssl nano apache2 git unzip libzip-dev zip
RUN docker-php-ext-install mysqli pdo pdo_mysql zip
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN a2enmod rewrite
EXPOSE 80 22 443