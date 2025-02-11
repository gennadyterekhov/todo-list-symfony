FROM php:8.2-fpm


RUN apt update \
    && apt install -y git libicu-dev zip libzip-dev zip libpq-dev mariadb-client \
    && docker-php-ext-install intl pdo pdo_mysql \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

WORKDIR /var/www
COPY --chown=www-data:www-data . /var/www

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash
RUN apt install symfony-cli

RUN composer install

RUN chown -R www-data /var/www/var