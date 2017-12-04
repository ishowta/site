FROM node:7.1

# Init
ENV HOME=/var/www/src
RUN mkdir -p $HOME
RUN cd $HOME
WORKDIR $HOME

# Install module
WORKDIR /usr/local/lib/
RUN npm install socket.io \
    && npm install co \
    && npm install cheerio-httpcli \
    && npm install request
WORKDIR $HOME
RUN npm install forever -g

COPY run.sh /var/www
RUN chmod a+x /var/www/run.sh
CMD ["/var/www/run.sh"]
