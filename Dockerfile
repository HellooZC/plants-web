FROM php:8.2-apache

# Install PostgreSQL PDO driver
RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Copy project files
COPY public/ /var/www/html/

EXPOSE 80
