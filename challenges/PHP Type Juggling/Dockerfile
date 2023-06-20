FROM php:7.4-apache

WORKDIR /var/www/html
COPY ./src .

# Config permission
RUN chown -R root:www-data /var/www/html
RUN chmod 750 /var/www/html
RUN find . -type f -exec chmod 640 {} \;
RUN find . -type d -exec chmod 750 {} \;
RUN chmod +t -R /var/www/html/

RUN echo "HPT{PHP_TypE_JuGglinG}MinKhoy" > /DAY_LA_CAI_FLAG_CHUC_MUNG_BAN.txt
