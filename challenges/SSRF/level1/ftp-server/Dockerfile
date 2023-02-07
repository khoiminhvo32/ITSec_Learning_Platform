FROM fauria/vsftpd
RUN mkdir /home/vsftpd/myuser 
RUN echo -e "\n" >> /etc/vsftpd/virtual_users.txt 
RUN /usr/bin/db_load -T -t hash -f /etc/vsftpd/virtual_users.txt /etc/vsftpd/virtual_users.db
RUN sed -i 's/anonymous_enable=NO/anonymous_enable=YES/g' /etc/vsftpd/vsftpd.conf
RUN echo 'Flag 4: VIS{FTP_cAn_alSo_Bee_AccessED?}' >> /var/ftp/flag.txt