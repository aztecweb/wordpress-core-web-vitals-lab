<?php
/**
 * Plugin test case class
 *
 * @package Cwv_Perf_Optimize
 */

namespace Cwv_Perf_Optimize\Tests;

use WP_Mock;
use WP_Mock\Tools\TestCase;

/**
 * Undocumented class
 */
abstract class Test_Case extends TestCase {

	/**
	 * Set up tests
	 *
	 * @return void
	 */
	public function setUp() : void {
		WP_Mock::setUp();
	}

	/**
	 * Tear down tests
	 *
	 * @return void
	 */
	public function tearDown() : void {
		WP_Mock::tearDown();
	}
}
