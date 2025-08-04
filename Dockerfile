# Use official PHP with Apache base image
FROM php:8.2-apache

# Install PostgreSQL driver and required tools
RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql

# Enable mod_rewrite for clean URLs (optional)
RUN a2enmod rewrite

# Copy app files to Apache web root
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html
