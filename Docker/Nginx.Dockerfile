FROM nginx
ADD Docker/vhost.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/app
WORKDIR /var/www/cli

EXPOSE 8080