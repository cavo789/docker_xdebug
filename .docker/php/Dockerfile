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

# Install PHP Tools (phan, phpunit, phpcov, phpstan, ...) or not?
ARG PHPTOOLS_INSTALL=false

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

# PHP tools - start ######################################
ARG PHPTOOLS_INSTALL

# URLs for PHP tools
#! To avoid breaking compatibility changes, prefer to force a version
#! Don't take the latest one.which can introduce BC (like a major version change does)
ENV URL_PHAN="https://github.com/phan/phan/releases/download/4.0.6/phan.phar"
ENV URL_PHPCBF="https://github.com/squizlabs/PHP_CodeSniffer/releases/download/3.6.0/phpcbf.phar"
ENV URL_PHPCOV="https://phar.phpunit.de/phpcov-8.2.0.phar"
ENV URL_PHPCS="https://github.com/squizlabs/PHP_CodeSniffer/releases/download/3.6.0/phpcs.phar"
ENV URL_PHPCSFIXER="https://github.com/FriendsOfPHP/PHP-CS-Fixer/releases/download/v2.19.0/php-cs-fixer.phar"
ENV URL_PHPUNIT="https://phar.phpunit.de/phpunit-9.5.5.phar"

RUN echo 'Install php tools (phan, php-cs-fixer, phpunit, ...) ${PHPTOOLS_INSTALL}'; \
    if [ "$PHPTOOLS_INSTALL" = "true" ]; then \
    # Required for phan
    pecl install ast-1.0.10; \
    docker-php-ext-enable ast; \
    # Required for phpcbf
    apt-get update -yqq; \
    apt-get install -y --no-install-recommends php-xmlwriter; \
    # For new repositories, using the .phar binary, put them in /usr/local/bin to make them accessible from everywhere
    cd /usr/local/bin/; \
    echo "Download phan from ${URL_PHAN}"; \
    curl -Lk "${URL_PHAN}" -o phan.phar; \
    chmod +x phan.phar; \
    echo "Download phpcbf from ${URL_PHPCBF}"; \
    curl -Lk "${URL_PHPCBF}" -o phpcbf.phar; \
    chmod +x phpcbf.phar; \
    echo "Download phpcs from ${URL_PHPCS}"; \
    curl -Lk "${URL_PHPCS}" -o phpcs.phar; \
    chmod +x phpcs.phar; \
    echo "Download php-cs-fixer from ${URL_PHPCSFIXER}"; \
    curl -Lk "${URL_PHPCSFIXER}" -o php-cs-fixer.phar; \
    chmod +x php-cs-fixer.phar; \
    echo "Download phpunit from ${URL_PHPUNIT}"; \
    curl -Lk "${URL_PHPUNIT}" -o phpunit.phar; \
    chmod +x phpunit.phar; \
    echo "Download phpcov from ${URL_PHPCOV}"; \
    curl -Lk "${URL_PHPCOV}" -o phpcov.phar; \
    chmod +x phpcov.phar; \
    # cleanup the apt-get install cache and any tmp folder
    apt-get clean; \
    rm -rf /tmp/*; \
    rm -rf /var/list/apt/*; \
    rm -rf /var/lib/apt/lists/*; \
    fi
# PHP tools - end ########################################

# Switch from root to our Linux user. Note that from now, permissions are more restrictive.
# We can put this line in comment and run everything as root but it's a bad idea since the idea
# under Docker is to be as close as possible to the test / production server
# USER ${OS_USERNAME}

# --------------------------------------------------------
#! As from here, the Linux user is ours, no more root:root
# --------------------------------------------------------

# Set the bash prompt; display the name of the container and the current username in the prompt
ARG APPLICATION_NAME
RUN /bin/bash -c "echo \"PS1='\e[0;33mDOCKER - ${APPLICATION_NAME}\e[0m - \e[0;36m$(whoami)\e[0m \w #  '\" >> ~/.bashrc "

WORKDIR /var/www/html

# Copy files from the host to Docker - start #########################
COPY --chown=${OS_USERNAME}:${OS_USERNAME} .config /var/www/.config
COPY --chown=${OS_USERNAME}:${OS_USERNAME} .devcontainer /var/www/.devcontainer
COPY --chown=${OS_USERNAME}:${OS_USERNAME} .vscode /var/www/.vscode
COPY --chown=${OS_USERNAME}:${OS_USERNAME} src /var/www/html
# Copy files from the host to Docker - end ###########################
