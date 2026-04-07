FROM php:8.2-apache

# Установка расширений для MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Копирование проекта
COPY . /var/www/html/

# Включение mod_rewrite
RUN a2enmod rewrite

# Разрешаем .htaccess
RUN echo '<Directory /var/www/html/> \
    AllowOverride All \
</Directory>' >> /etc/apache2/apache2.conf

# Права доступа
RUN chown -R www-data:www-data /var/www/html
