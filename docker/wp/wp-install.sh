#!/bin/bash
#
# Install a WordPress application from scratch

CONFIG_FILE=wp-config.php

# Download a fresh version of WordPress. It will be skipped if already exists the WordPress files into the public
# directory
echo 'Downloading WordPress'
wp --allow-root core download

# Create the wp-config.php inner public directory if it doesn't exist
# The extra code is to allow serve the WordPress agnostically
echo 'Creating wp-config.php file'
[ -f ${CONFIG_FILE} ] && echo 'Removing existent file' && rm ${CONFIG_FILE}
wp --allow-root config create --dbhost=db --dbname=db --dbuser=root --dbpass=db --extra-php <<PHP
/**
 * Set WordPress home and site URLs
 */
\$scheme = 'http';

// Adjust URL scheme to serve HTTPS requests
\$port = \$_SERVER['HTTP_X_FORWARDED_PORT'] ?? \$_SERVER['SERVER_PORT'];
\$port = intval( \$port );

if( in_array( \$port, array( 443, 44380 ) ) ) {
    \$_SERVER['HTTPS'] = 'on';
    \$scheme = 'https';
}

define( 'WP_HOME', "{\$scheme}://{\$_SERVER['HTTP_HOST']}/" );
define( 'WP_SITEURL', "{\$scheme}://{\$_SERVER['HTTP_HOST']}/" );

// Allow WordPress right on FS directly
define( 'FS_METHOD', 'direct' );
PHP

# Allow everybidy write con wp-content. Never do that on production!
chmod 777 -R wp-content

# Create the installation data on database if it doesn't exist yet
echo 'Installing WordPress'
wp --allow-root core install --url=https://localhost --title="Core Web Vitals Lab" --admin_user=admin --admin_password=admin --admin_email=admin@admin.com

# Create link symbolic to cwv-perf-optimize plugin and activate it
ln -sf /cwv-perf-optimize /var/www/html/wp-content/plugins/cwv-perf-optimize
wp --allow-root plugin activate cwv-perf-optimize
