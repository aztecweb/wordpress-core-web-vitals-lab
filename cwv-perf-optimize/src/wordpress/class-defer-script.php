<?php
/**
 * Defer JavaScript loading to help to eliminate the render-blocking resources
 *
 * Tested on version:
 * - WordPress: 5.6
 *
 * Oportunity/Diagnotiscs:
 * - Eliminate render-blocking resources
 *
 * @link https://web.dev/optimize-fid/#defer-unused-javascript
 * @link https://developers.google.com/web/fundamentals/performance/critical-rendering-path/
 * @link https://web.dev/render-blocking-resources/#how-to-eliminate-render-blocking-scripts
 *
 * @package Cwv_Perf_Optimize
 */

namespace Cwv_Perf_Optimize\WordPress;

/**
 * Defer JavaScript loading
 */
class Defer_Script {

	/**
	 * Load hooks
	 */
	public function hooks() {
		add_filter( 'script_loader_tag', array( $this, 'add_defer_attribute' ) );
	}

	/**
	 * Add defer attribute when script tag is rendered
	 *
	 * @param string $tag The current script tag.
	 * @return string The script tag with defer attribute.
	 */
	public function add_defer_attribute( $tag ) {
		$tag = str_replace( '></script>', ' defer></script>', $tag );

		return $tag;
	}
}
