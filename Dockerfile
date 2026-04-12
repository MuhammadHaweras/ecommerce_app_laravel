FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    libicu-dev \
    libpq-dev \
    && docker-php-ext-install intl zip pdo_pgsql pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

CMD php -S 0.0.0.0:$PORT -t public
