FROM php:8.2-cli

# Установка расширений
RUN docker-php-ext-install pdo pdo_mysql

# Рабочая директория
WORKDIR /app

# Копируем проект
COPY . .

# Railway использует переменную PORT
CMD php -S 0.0.0.0:$PORT
