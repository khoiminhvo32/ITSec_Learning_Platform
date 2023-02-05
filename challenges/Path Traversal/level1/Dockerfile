FROM php:7.3-apache
WORKDIR /var/www/html/
COPY ./src .

#
# default /var/www/html is 777 ~~ ae nho check ky
#
RUN chown -R root:www-data /var/www/html &&    chmod 750 /var/www/html

RUN find . -type f -exec chmod 640 {} \;
RUN find . -type d -exec chmod 750 {} \;

# prevent delete
RUN chmod +t -R /var/www/html/

RUN echo "VIS{Path_Traversal_File_Reading}" >> /etc/passwd

