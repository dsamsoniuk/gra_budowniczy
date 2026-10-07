FROM php:8.4-fpm

WORKDIR /app

RUN apt-get update && apt-get install -y \
    libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo pdo_mysql intl

CMD ["php", "-S", "0.0.0.0:80", "-t", "public"]