FROM php:8.2-apache

# Сброс кеша
RUN echo "clean build"

# Установка расширений
RUN docker-php-ext-install pdo pdo_mysql

# Включаем правильный MPM (prefork) и выключаем другие
RUN a2dismod mpm_event mpm_worker || true
RUN a2enmod mpm_prefork

# Включаем rewrite
RUN a2enmod rewrite

# Копируем проект
COPY . /var/www/html/

# Права
RUN chown -R www-data:www-data /var/www/html
