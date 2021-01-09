<?php
/**
 * Plugin Name: Core Web Vitals Performance Optimize
 *
 * @package Cwv_Perf_Optimize
 */

namespace Cwv_Perf_Optimize;

require_once __DIR__ . '/autoload.php';

/**
 * Bootstrap performance tricks
 */
function plugin_bootstrap() {
	if ( is_admin() ) {
		return;
	}

	$has_hooks = array(
		new \Cwv_Perf_Optimize\WordPress\Defer_Script(),
	);

	foreach ( $has_hooks as $class ) {
		$class->hooks();
	}
}
add_action( 'init', __NAMESPACE__ . '\plugin_bootstrap' );
