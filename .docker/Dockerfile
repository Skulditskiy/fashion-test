FROM roadiz/php72-nginx-alpine:latest
MAINTAINER Ambroise Maupate <ambroise@rezo-zero.com>

COPY . /var/www/
COPY .docker/000-default.conf /etc/nginx/default.d/000-default.conf

RUN chown -R www-data:www-data /var/www/
EXPOSE 80
