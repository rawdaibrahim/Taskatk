FROM php:8-apache
COPY ./ /var/www/html/Taskatk
RUN docker-php-ext-install mysqli session