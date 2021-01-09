<?php
/**
 * The wp-config file for tests
 *
 * @package WP_Cwv_CLI
 */

// Load project commands.
require_once __DIR__ . '/../load-commands.php';

define( 'DB_NAME', 'wordpress' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', 'db' );
define( 'DB_HOST', 'db' );
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

$table_prefix = 'wp_'; //phpcs:disable WordPress.WP.GlobalVariablesOverride.Prohibited

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

require_once ABSPATH . 'wp-settings.php';
