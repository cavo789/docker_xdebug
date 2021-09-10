FROM httpd:alpine3.14

RUN apk update; \
    apk upgrade;

# Copy apache vhost file to proxy php requests to php-fpm container
COPY .docker/webserver/demo.apache.conf /usr/local/apache2/conf/demo.apache.conf

RUN echo "Include /usr/local/apache2/conf/demo.apache.conf" \
    >> /usr/local/apache2/conf/httpd.conf

RUN mkdir -p /var/www/html

WORKDIR /var/www/html

# Copy files from the host to Docker - start #########################
COPY src .
# Copy files from the host to Docker - end ###########################

