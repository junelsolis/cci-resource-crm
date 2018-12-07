FROM php:7.2-fpm
RUN docker-php-ext-install pdo_mysql
#ENV TZ=America/New_York
#RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
