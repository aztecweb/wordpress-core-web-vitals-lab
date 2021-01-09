<?php
/**
 * Recipe cest test class
 *
 * @package WP_Cwv_CLI
 */

/**
 * Test recipe command
 */
class RecipeCest {

	/**
	 * Test load subcommand
	 *
	 * @param FunctionalTester $i Tester actor.
	 * @return void
	 */
	public function load_subcommand( FunctionalTester $i ) {
		$i->cli( array( 'recipe', 'load' ) );
		$i->seeInShellOutput( 'Hello World!' );
	}
}
