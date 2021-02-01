FROM wordpress:php7.4-fpm-alpine as base

RUN set -ex; \
    \
    # Image build dependencies
    apk add --update --no-cache --virtual .build-deps \
        autoconf \
        build-base \
        gcc \
        libzip-dev \
    ; \
    # Install PHP extensions dependency
    pecl install xdebug; \
    docker-php-ext-enable xdebug; \
    docker-php-ext-install zip; \
    \
    # Remove build dependencies
    apk del .build-deps

# Add WP-CLI MySQL client dependency to image
COPY --from=wordpress:cli /usr/bin/mysql /usr/local/bin/mysql

# Install, enable and configure Xdebug
RUN { \
	echo 'xdebug.mode = ${XDEBUG_MODE}'; \
	echo 'xdebug.start_with_request = yes'; \
	echo 'xdebug.client_host = host.docker.internal'; \
	echo 'xdebug.log = /tmp/xdebug.log'; \
} > /usr/local/etc/php/conf.d/xdebug.ini


# Change PAGER environment variable to WP-CLI work with busybox less
ENV PATH ${PATH}:/vendor/bin

# Change PAGER environment variable to WP-CLI work with busybox less
ENV PAGER more

# Rewrite default image entrypoint to don't copy wordpress to /var/www/html
COPY docker-entrypoint.sh /usr/local/bin/

# Copy install command to image
COPY wp-install.sh /usr/local/bin/wp-install

FROM base as tests

RUN set -ex; \
    \
    # Install tests PHP dependency
    docker-php-ext-install pdo_mysql
