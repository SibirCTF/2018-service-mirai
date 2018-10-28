FROM php:7.1-apache

RUN apt-get -qq update
RUN apt-get install -y libpq-dev
RUN docker-php-ext-install pgsql pdo_pgsql
WORKDIR /var/www/html/

COPY ./code/ .

RUN chgrp www-data /var/www/html/avatars
RUN chmod g+rwx /var/www/html/avatars
RUN chgrp www-data /var/www/html/images
RUN chmod g+rwx /var/www/html/images
