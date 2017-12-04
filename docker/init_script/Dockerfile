FROM python:3.6

# occurred error in greater version
RUN pip3 install mysql-connector==2.1.4
RUN pip3 install ConfigParser

# Init
ENV HOME=/home/init_script
RUN mkdir -p $HOME
RUN cd $HOME
WORKDIR $HOME

COPY run.sh /home
RUN chmod a+x /home/run.sh
CMD ["/home/run.sh"]
