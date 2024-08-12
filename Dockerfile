FROM ghcr.io/roadrunner-server/roadrunner:2023.3.11 AS roadrunner
FROM php:cli-bullseye

COPY --from=roadrunner /usr/bin/rr /usr/local/bin/rr
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apt update \
    && apt install -y \
        librabbitmq-dev \
        libssh-dev libpcre3 libpcre3-dev \
        libssl-dev g++ make zlib1g-dev libzip-dev libpq-dev  \
        libicu-dev \
    && docker-php-ext-install \
        bcmath intl opcache zip sockets pdo_mysql pdo_pgsql \
    && pecl install amqp \
    && docker-php-ext-enable amqp

WORKDIR /usr/src/app

#COPY . .

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV APP_ENV=dev

#RUN composer install --no-dev --no-scripts --prefer-dist --no-progress --no-interaction
#RUN composer dump-autoload --optimize && \
#    composer check-platform-reqs && \
#    php bin/console cache:warmup

EXPOSE 8080

CMD ["rr", "serve"]