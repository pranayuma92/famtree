<?php

/*
Plugin Name: FamTree
Description: The family tree structure visualization
Version: 1.0.8
Author: Doni & Pandu
License: GPLv2 or later
Text Domain: famtree
*/

/**
 * Define constant
 * @package famtree
 * @since 1.0.8
 */

define( 'FT_VERSION', '1.0.8' );
define( 'FT_SLUG', 'famtree' );
define( 'FT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'FT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once FT_PLUGIN_DIR . 'includes/main.php';
require_once FT_PLUGIN_DIR . 'includes/admin.php';
require_once FT_PLUGIN_DIR . 'framework/bootstrap.php';
require_once FT_PLUGIN_DIR . 'updater/plugin-update-checker.php';
$UpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/pranayuma92/famtree',
	__FILE__,
	'famtree'
);

return initFamTree();