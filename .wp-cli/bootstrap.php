<?php
/**
 * Bootstrap WP-CLI.
 *
 * @package WP_Cwv_CLI
 */

namespace WP_Cwv_CLI;

// Skip if is wp-browser (functional tests).
if ( getenv( 'WPBROWSER_HOST_REQUEST' ) ) {
	return;
}

/*
 * Load WP_CLI class required by load-commands.php script.
 *
 * It is required in this point because the phar is not present on functional tests.
 */
require_once 'phar://wp-cli.phar/vendor/wp-cli/wp-cli/php/class-wp-cli.php';

require_once __DIR__ . '/load-commands.php';
