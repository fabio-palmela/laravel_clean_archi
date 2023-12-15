FROM acrcredicom.azurecr.io/php:8.2-fpm

WORKDIR /var/www/html
COPY --chown=www-data:www-data . .
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN composer install --no-scripts
EXPOSE 80