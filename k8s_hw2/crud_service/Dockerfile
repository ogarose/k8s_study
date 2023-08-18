FROM php:8.2.5-alpine

RUN docker-php-ext-install \
    pdo \
    pdo_mysql

COPY . /app

CMD ["php", "-S", "0.0.0.0:8000", "docke/app/index.php"]