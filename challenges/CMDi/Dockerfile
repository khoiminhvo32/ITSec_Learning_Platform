FROM php:5.6.40-apache

# put files
WORKDIR /var/www/html/
COPY ./src .

# config permission
RUN chown -R root:www-data /var/www/html
RUN chmod 750 /var/www/html
RUN find . -type f -exec chmod 640 {} \;
RUN find . -type d -exec chmod 750 {} \;

# add sticky bit to prevent delete files
RUN chmod +t -R /var/www/html/
RUN apt-get update -y

