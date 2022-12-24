FROM node:14
WORKDIR /usr/src/app
COPY ./src/. /usr/src/app
RUN npm install -g nodemon
RUN npm install --save

RUN chown -R root:node /usr/src/app
RUN chmod 750 /usr/src/app
RUN find . -type f -exec chmod 640 {} \;
RUN find . -type d -exec chmod 750 {} \;

RUN chmod +t -R /usr/src/app