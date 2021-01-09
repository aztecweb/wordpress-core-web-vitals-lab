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
COPY --from=wordpress:cli /usr/bin/mysqldump /usr/local/bin/mysqldump

# Install, enable and configure Xdebug
RUN { \
	echo 'xdebug.mode = ${XDEBUG_MODE}'; \
	echo 'xdebug.start_with_request = yes'; \
	echo 'xdebug.client_host = host.docker.internal'; \
	echo 'xdebug.log = /tmp/xdebug.log'; \
} > /usr/local/etc/php/conf.d/xdebug.ini

# Change PAGER environment variable to WP-CLI work with busybox less
ENV PAGER more

# Change WP-CLI cache directory to avoid versioning
ENV WP_CLI_CACHE_DIR /tmp/wp-cli-cache

# Rewrite default image entrypoint to don't copy wordpress to /var/www/html
COPY docker-entrypoint.sh /usr/local/bin/

# Copy install command to image
COPY wp-install.sh /usr/local/bin/wp-install

FROM base as tests

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
        # A mocking library to take the pain out of unit testing for WordPress
        10up/wp_mock \
        # PHPUnit
        phpunit/phpunit \
        # PHPUnit watcher keep the tests running
        spatie/phpunit-watcher

FROM base as cli-tests

# PHP extension required by Codeception
RUN docker-php-ext-install \
    pdo_mysql

# Add composer binarty to install PHPUnit
COPY --from=composer /usr/bin/composer /usr/local/bin/composer

RUN set -ex; \
    \
    composer --global config bin-dir /usr/local/bin; \
    # WordPress functional and acceptance tests library
    composer global require \
        lucatume/wp-browser \
        codeception/module-asserts \
        codeception/module-phpbrowser \
        codeception/module-webdriver \
        codeception/module-db \
        codeception/module-filesystem \
        codeception/module-cli \
        codeception/util-universalframework

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
