FROM php:7.2-apache
RUN apt update && apt install vsftpd -y && apt install ftp -y && apt install  net-tools -y
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo pdo_mysql
RUN pecl install apcu && docker-php-ext-enable apcu --ini-name 10-docker-php-ext-apcu.ini
WORKDIR /var/vis/html
COPY ./src /var/vis/html
COPY ./web-internal /var/vis/internal/html 
RUN chown -R www-data:www-data /var/vis/html
COPY 000-default.conf /etc/apache2/sites-available/
COPY apache2.conf /etc/apache2/
RUN echo "Listen 8888" >> /etc/apache2/ports.conf
RUN echo "Listen 9001" >> /etc/apache2/ports.conf
RUN echo "Flag5: VIS{File_Schemeeeeeeeee}" >> /etc/passwd 