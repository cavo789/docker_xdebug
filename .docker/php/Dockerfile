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

# Optional, name and ID of the user used inside this container
# 1000 is the userid in the host when coding under linux (Ubuntu/Debian)
# (you can retrieve it by running `echo $UID` in a prompt)
# ==> reusing the same ID will allow to avoid error "You don't have access to this file"
# since the owner in the host will be the owner in the container (even if the name is different)
ARG OS_USERNAME=christophe
ARG OS_USERID=1000

# We'll use the FPM version; i.e. without Apache
# We'll create a separate Docker service for Apache or nginx
FROM php:${PHP_VERSION}-fpm

# Create a new user on Linux
ARG OS_USERNAME
ARG OS_USERID
RUN useradd -G www-data,root -u ${OS_USERID} -d /home/${OS_USERNAME} ${OS_USERNAME}
RUN mkdir -p /home/${OS_USERNAME}/.composer; \
    chown -R ${OS_USERNAME}:${OS_USERNAME} /home/${OS_USERNAME}; \
    chown -R ${OS_USERNAME}:${OS_USERNAME} /var/www

# xDebug - start #####################################################
ARG XDEBUG_INSTALL
ARG XDEBUG_MAJOR_VERSION
ARG XDEBUG_FULL_VERSION

RUN echo "Install xDebug? $XDEBUG_INSTALL (version ${XDEBUG_FULL_VERSION})"; \
    if [ "$XDEBUG_INSTALL" = "true" ]; then \
    pecl install xdebug-${XDEBUG_FULL_VERSION}; \
    docker-php-ext-enable xdebug; \
    rm -r /tmp/pear/*; \
    fi

# Copy the xdebug ini file even we don't use it (xdebug disabled)
COPY .docker/php/conf.d/xdebug_v${XDEBUG_MAJOR_VERSION}.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
# xDebug - end #######################################################

# Switch from root to our Linux user. Note that from now, permissions are more restrictive.
# We can put this line in comment and run everything as root but it's a bad idea since the idea
# under Docker is to be as close as possible to the test / production server
USER ${OS_USERNAME}

# --------------------------------------------------------
#! As from here, the Linux user is ours, no more root:root
# --------------------------------------------------------

# Set the bash prompt; display the name of the container and the current username in the prompt
ARG APPLICATION_NAME
RUN /bin/bash -c "echo \"PS1='\e[0;33mDOCKER - ${APPLICATION_NAME}\e[0m - \e[0;36m$(whoami)\e[0m \w #  '\" >> ~/.bashrc "

WORKDIR /var/www/html

# Copy files from the host to Docker - start #########################
COPY --chown=${OS_USERNAME}:${OS_USERNAME} src .
# Copy files from the host to Docker - end ###########################
