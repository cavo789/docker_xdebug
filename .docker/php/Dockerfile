# Desired target PHP version, See https://hub.docker.com/_/php for more
ARG PHP_VERSION=7.4

# Should we install xDebug?
ARG XDEBUG_INSTALL=false

# If yes, which version to install (the major will be used to select the good xdebug.ini file)?
ARG XDEBUG_MAJOR_VERSION=3

# If yes, which version to install (the full version number)?
ARG XDEBUG_FULL_VERSION=3.0.4

# The application name like f.i. "MySample"
ARG APPLICATION_NAME=""

# We'll use the FPM version; i.e. without Apache
# We'll create a separate Docker service for Apache or nginx
FROM php:${PHP_VERSION}-fpm

# xDebug - start #####################################################
ARG XDEBUG_INSTALL
ARG XDEBUG_MAJOR_VERSION
ARG XDEBUG_FULL_VERSION

RUN echo "Install xDebug? $XDEBUG_INSTALL (version ${XDEBUG_FULL_VERSION})"; \
    if [ "$XDEBUG_INSTALL" = "true" ]; then \
    pecl install xdebug-${XDEBUG_FULL_VERSION}; \
    docker-php-ext-enable xdebug; \
    cp ./.docker/php/conf.d/xdebug_v${XDEBUG_MAJOR_VERSION}.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    rm -r /tmp/pear/*; \
    fi
# xDebug - end #######################################################

# Set the bash prompt; display the name of the container and the current username in the prompt
ARG APPLICATION_NAME
RUN /bin/bash -c "echo \"PS1='\e[0;33mDOCKER - ${APPLICATION_NAME}\e[0m - \e[0;36m$(whoami)\e[0m \w #  '\" >> ~/.bashrc "

RUN mkdir -p /var/www/src

WORKDIR /var/www/src

# Copy files from the host to Docker - start #########################
COPY src .
# Copy files from the host to Docker - end ###########################
