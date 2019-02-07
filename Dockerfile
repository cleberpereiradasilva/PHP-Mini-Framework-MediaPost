FROM debian
MAINTAINER Cleber Silva
RUN apt-get update
RUN apt-get install -y nginx wget sqlite3 vim 
RUN apt install -y apt-transport-https lsb-release ca-certificates
RUN wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
RUN echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list
RUN apt update
RUN alias ls='ls -la --color'
RUN apt install -y php7.2 php7.2-cli php7.2-common php7.2-json php7.2-mysql php7.2-zip php7.2-fpm php7.2-mbstring php7.2-sqlite3 
COPY ./nginx/default /etc/nginx/sites-available/default
CMD service nginx start && service php7.2-fpm start && /bin/bash

#docker build -t mini/php-nginx-2 .
#docker run  -it -p 8080:80 -v /home/noct/HD2TB/Desafios/Mini/html/:/var/www/html mini/php-nginx-2