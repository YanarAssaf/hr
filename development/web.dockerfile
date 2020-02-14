FROM nginx:1.16.1-alpine

ADD development/vhost.conf /etc/nginx/conf.d/default.conf

COPY public /var/www/public