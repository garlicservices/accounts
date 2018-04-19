FROM debian:jessie

MAINTAINER MIG <imaximius@gmail.com>

RUN apt-get update && apt-get install -y \
    nginx

ADD nginx.conf /etc/nginx/
ADD cabinet.socialmedia.market.conf /etc/nginx/sites-available/

RUN ln -s /etc/nginx/sites-available/cabinet.socialmedia.market.conf /etc/nginx/sites-enabled/cabinet.socialmedia.market.conf
RUN rm /etc/nginx/sites-enabled/default

RUN echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf

RUN usermod -u 1000 www-data

CMD ["nginx"]

EXPOSE 80
EXPOSE 443
