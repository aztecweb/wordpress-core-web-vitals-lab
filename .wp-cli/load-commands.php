<?php
/**
 * Load project WP-CLI commands.
 *
 * @package WP_Cwv_CLI
 */

namespace WP_Cwv_CLI;

// Require command classes.
require_once __DIR__ . '/src/command/class-recipe.php';

// Add the commands to WP-CLI.
\WP_CLI::add_command( 'recipe', __NAMESPACE__ . '\Command\Recipe' );
