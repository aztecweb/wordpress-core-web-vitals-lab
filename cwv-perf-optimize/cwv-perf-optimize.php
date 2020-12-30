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
	new \Cwv_Perf_Optimize\WordPress\Defer_Script();
}
add_action( 'init', __NAMESPACE__ . '\plugin_bootstrap' );
