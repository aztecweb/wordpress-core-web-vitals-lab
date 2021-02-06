<?php
/**
 * Test Defer_Script
 *
 * @package Cwv_Perf_Optimize
 */

namespace Cwv_Perf_Optimize\Tests\WordPress;

use Cwv_Perf_Optimize\Tests\Test_Case;
use Cwv_Perf_Optimize\WordPress\Defer_Script;
use DOMDocument;

/**
 * Test Defer_Script class
 */
class Test_Defer_Script extends Test_Case {

	/**
	 * Test if hooks are being loaded correctly
	 *
	 * @doesNotPerformAssertions
	 */
	public function test_hooks() {
		$defer_script = new Defer_Script();

		\WP_Mock::expectFilterAdded( 'script_loader_tag', array( $defer_script, 'add_defer_attribute' ) );

		$defer_script->hooks();
	}

	/**
	 * Test if the defer attribute is being added
	 */
	public function test_add_defer_attribute() {
		$src = 'https://localhost/wp-includes/js/wp-embed.min.js?ver=5.6';
		$id  = 'wp-embed-js';
		$tag = "<script src='${src}' id='${id}'></script>"; // phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript

		$defer_script = new Defer_Script();
		$deferred_tag = $defer_script->add_defer_attribute( $tag );

		$document = new DOMDocument();
		$document->loadHTML( $deferred_tag );
		$script_element = $document->getElementsByTagName( 'script' )[0];

		$this->assertStringStartsWith( $src, $script_element->getAttribute( 'src' ) );
		$this->assertEquals( 'wp-embed-js', $script_element->getAttribute( 'id' ) );
		$this->assertTrue( $script_element->hasAttribute( 'defer' ) );
	}
}
