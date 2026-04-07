FROM php:8.2-apache

# force rebuild
RUN echo "rebuild"

RUN docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html
