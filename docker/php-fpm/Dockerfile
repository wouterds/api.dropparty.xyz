FROM php:7.2-fpm-alpine
LABEL maintainer="Wouter De Schuyter <wouter.de.schuyter@gmail.com>"

# Install extensions
RUN NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) \
  && docker-php-ext-install -j${NPROC} pdo pdo_mysql mysqli

# PHP configuration file
COPY ./docker/php-fpm/php.ini /usr/local/etc/php/conf.d/custom.ini

# Copy project
COPY ./ /code

# Change working directory
WORKDIR /code
