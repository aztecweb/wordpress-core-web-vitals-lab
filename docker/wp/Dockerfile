FROM wordpress:php7.4-fpm-alpine as base

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
COPY --from=wordpress:cli /usr/bin/mysql /usr/local/bin/mysql

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

FROM base as tests

ENV TMPDIR /cwv-perf-optimize/.tmp
ENV WP_TESTS_DIR ${TMPDIR}/wordpress-tests-lib

# subversion is required by Wordpress Unit test installer
RUN apk add --update --no-cache subversion

# mysqladmin is required by Wordpress Unit test installer
COPY --from=wordpress:cli /usr/bin/mysqladmin /usr/local/bin/mysqladmin

# Add composer binarty to install PHPUnit
COPY --from=composer /usr/bin/composer /usr/local/bin/composer

RUN set -ex; \
    \
    # Install PHPUnit globally
    composer --global config bin-dir /usr/local/bin; \
    composer global require \
        # PHPUnit 7 is a requirement to WordPress Unit tests
        phpunit/phpunit:7.x \
        # PHPUnit watcher keep the tests running
        spatie/phpunit-watcher:^1.10

FROM base as coding-standards

# Add composer binarty to install PHP Coding Standards
# Composer 1.x is required by phpcodesniffer-composer-installer
COPY --from=composer:1 /usr/bin/composer /usr/local/bin/composer

RUN set -ex; \
    \
    # Install WordPress Coding Standards globally
    composer --global config bin-dir /usr/local/bin; \
    composer global require \
        # Required to autoload installed coding standards
        dealerdirect/phpcodesniffer-composer-installer:^0.6 \
        # .phpcs.xml.dist required coding standards
        wp-coding-standards/wpcs \
        phpcompatibility/phpcompatibility-wp
