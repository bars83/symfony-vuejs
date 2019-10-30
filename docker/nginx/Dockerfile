FROM nginx:latest

COPY --chown=nginx:nginx ./public/build /var/www/html/public/build
COPY --chown=nginx:nginx ./docker/nginx/config/htpasswd /etc/nginx/conf/htpasswd
COPY --chown=nginx:nginx ./docker/nginx/config/nginx.conf /etc/nginx/conf.d/nginx.conf
COPY --chown=nginx:nginx ./docker/nginx/config/nginx.main.conf /etc/nginx/nginx.conf
#COPY --chown=nginx:nginx ./docker/nginx/config/site.template /etc/nginx/conf.d/site.template

RUN rm /etc/nginx/conf.d/default.conf

RUN apt-get update && apt-get install -y curl

RUN rm -rf /var/lib/apt/lists/*
