FROM php:8.2-apache

# Установка расширений
RUN docker-php-ext-install pdo pdo_mysql

# Копирование проекта
COPY . /var/www/html/

# Включаем mod_rewrite
RUN a2enmod rewrite

# Правильная настройка Apache
RUN printf '<Directory /var/www/html/>\nAllowOverride All\n</Directory>\n' >> /etc/apache2/apache2.conf

# Права
RUN chown -R www-data:www-data /var/www/html
