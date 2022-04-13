FROM geerlingguy/php-apache:latest

RUN rm /var/www/html/index.html

COPY vendor/bin/heroku-php-apache2 public/ /var/www/html/index.html