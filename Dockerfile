FROM php:8.2-apache

# Установка расширений
RUN docker-php-ext-install pdo pdo_mysql

# Включаем mod_rewrite (достаточно этого!)
RUN a2enmod rewrite

# Копирование проекта
COPY . /var/www/html/

# Права
RUN chown -R www-data:www-data /var/www/html
