<?php
/**
 * Recipe command
 *
 * @package WP_Cwv_CLI
 */

namespace WP_Cwv_CLI\Command;

use WP_CLI;

/**
 * Load installation recipes
 */
class Recipe {

	/**
	 * Load a recipe
	 */
	public function load() {
		WP_CLI::line( 'Hello World!' );
	}
}
