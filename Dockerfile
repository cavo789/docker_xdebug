FROM php:7-apache

# Install XDebug
RUN pecl install -f xdebug \
    docker-php-ext-enable xdebug \
    && echo "[xdebug]" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal"  >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_port=9001"  >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.default_enable=1"  >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.idekey=VSCODE"  >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=1"  >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_connect_back=0"  >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=1"  >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_log=/usr/local/etc/php/xdebug.log"  >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/xdebug.ini
