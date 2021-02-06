<?php
/**
 * PHPUnit bootstrap file
 *
 * @package Cwv_Perf_Optimize
 */

namespace Cwv_Perf_Optimize\Tests;

use WP_Mock;

WP_Mock::setUsePatchwork( true );
WP_Mock::bootstrap();

require_once '/app/cwv-perf-optimize/cwv-perf-optimize.php';
require_once __DIR__ . '/unit/class-test-case.php';
