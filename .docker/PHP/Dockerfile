FROM php:7.4-fpm

ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/

COPY php.ini /usr/local/etc/php/php.in

RUN chmod +x /usr/local/bin/install-php-extensions

RUN apt-get update && apt-get install -y \
     && install-php-extensions \
     bcmath \
     pdo_mysql \
     gmp \
     zip \
     mongodb

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update && apt-get install git -y && apt-get install wget -y

RUN cd /tmp \
    && wget https://cs.symfony.com/download/php-cs-fixer-v2.phar -O php-cs-fixer \
    && chmod a+x php-cs-fixer \
    && mv php-cs-fixer /usr/local/bin/php-cs-fixer

WORKDIR /app