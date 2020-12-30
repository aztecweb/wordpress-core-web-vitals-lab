<?php
/**
 * Test Defer_Script
 *
 * @package Cwv_Perf_Optimize
 */

namespace Cwv_Perf_Optimize\Tests\WordPress;

use DOMDocument;
use WP_UnitTestCase;

/**
 * Test Defer_Script class
 */
class Test_Defer_Script extends WP_UnitTestCase {

	/**
	 * Test script_loader_tag filter
	 */
	public function test_defer_attribute() {
		$handle  = 'some-script';
		$src     = 'http://some-domain.com';
		$version = '0.0';

		wp_register_script( $handle, $src, array(), $version, false );
		wp_enqueue_script( $handle );

		$scripts = wp_scripts();

		ob_start();
		$scripts->do_item( $handle );
		$tag = ob_get_clean();

		$document = new DOMDocument();
		$document->loadHTML( $tag );
		$script_element = $document->getElementsByTagName( 'script' )[0];

		$this->assertEquals( 'text/javascript', $script_element->getAttribute( 'type' ) );
		$this->assertStringStartsWith( $src, $script_element->getAttribute( 'src' ) );
		$this->assertEquals( $handle . '-js', $script_element->getAttribute( 'id' ) );
		$this->assertTrue( $script_element->hasAttribute( 'defer' ) );
	}
}
