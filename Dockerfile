# Используем официальный PHP-образ с поддержкой расширений
FROM php:8.2-fpm

# Установка системных зависимостей и расширений PHP
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Установка Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Копируем проект
COPY . /var/www

WORKDIR /var/www

# Устанавливаем переменные окружения для Composer
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_MEMORY_LIMIT=-1

# Создаем .env для корректной работы artisan команд во время сборки
RUN cp .env.example .env

# Установка зависимостей Laravel без dev пакетов для продакшена
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Генерация ключа приложения
RUN php artisan key:generate || true

# Открываем порт
EXPOSE ${PORT:-8000}

# Запуск Laravel через встроенный сервер
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
