#!/bin/bash
#
# Install a WordPress application from scratch

# Download a fresh version of WordPress. It will be skipped if already exists the WordPress files into the public
# directory
echo 'Downloading WordPress'
wp --allow-root core download

# Create the wp-config.php inner public directory if it doesn't exist
# The extra code is to allow serve the WordPress agnostically
echo 'Creating wp-config.php file'
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

define('WP_HOME', "{\$scheme}://{\$_SERVER['HTTP_HOST']}/");
define('WP_SITEURL', "{\$scheme}://{\$_SERVER['HTTP_HOST']}/");
PHP

# Create the installation data on database if it doesn't exist yet
echo 'Installing WordPress'
wp --allow-root core install --url=https://localhost --title="Core Web Vitals Lab" --admin_user=admin --admin_password=admin --admin_email=admin@admin.com
