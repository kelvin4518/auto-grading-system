FROM ubuntu

RUN apt-get update
RUN apt-get install python -y
RUN apt-get install vim -y 
RUN apt-get install gcc -y 
RUN apt-get install g++ -y 
RUN apt-get install default-jre -y
RUN apt-get install default-jdk -y 
RUN apt-get install perl -y 
RUN apt-get install python-pip -y
RUN pip install --upgrade pip
RUN pip install mysql-connector-python-rf
RUN apt-get install curl -y


RUN mkdir /app
COPY . /app
WORKDIR /app

CMD python app.py 1155061927_2 python main.py,
#ENTRYPOINT /bin/bash