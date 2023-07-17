FROM php:8.1-cli

RUN apt-get update \
    && apt-get install -y \
    curl \
    libpq-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /app

COPY . /app

RUN composer install

RUN php vendor/bin/php-cs-fixer fix -vvv --show-progress=dots
RUN php vendor/bin/phpstan analyze --memory-limit=-1

CMD php artisan serve --host 0.0.0.0 --port 80
