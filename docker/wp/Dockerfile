FROM wordpress:php7.4-fpm-alpine

RUN set -ex; \
    \
    # Image build dependencies
    apk add --update --no-cache --virtual .build-deps \
        autoconf \
        build-base \
        gcc \
    ; \
    # Install Xdebug extension
    pecl install xdebug; \
    docker-php-ext-enable xdebug; \
    \
    # Remove build dependencies
    apk del .build-deps

# Add WP-CLI binary to image
COPY --from=wordpress:cli /usr/local/bin/wp /usr/local/bin/wp

# Add WP-CLI MySQL client dependency to image
COPY --from=wordpress:cli /usr/bin/mysql /usr/bin/mysql

# Install, enable and configure Xdebug
RUN { \
	echo 'xdebug.mode = ${XDEBUG_MODE}'; \
	echo 'xdebug.start_with_request = yes'; \
	echo 'xdebug.client_host = host.docker.internal'; \
	echo 'xdebug.log = /tmp/xdebug.log'; \
} > /usr/local/etc/php/conf.d/xdebug.ini

# Change PAGER environment variable to WP-CLI work with busybox less
ENV PAGER more

# Rewrite default image entrypoint to don't copy wordpress to /var/www/html
COPY docker-entrypoint.sh /usr/local/bin/

# Copy install command to image
COPY wp-install.sh /usr/local/bin/wp-install
