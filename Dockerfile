FROM php:8.2-apache

# Сброс кеша
RUN echo "fix port"

# Установка расширений
RUN docker-php-ext-install pdo pdo_mysql

# Apache должен слушать PORT от Railway
RUN sed -i 's/80/${PORT}/g' /etc/apache2/ports.conf
RUN sed -i 's/:80/:${PORT}/g' /etc/apache2/sites-available/000-default.conf

# Включаем модули
RUN a2dismod mpm_event mpm_worker || true
RUN a2enmod mpm_prefork rewrite

# Копируем проект
COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html
