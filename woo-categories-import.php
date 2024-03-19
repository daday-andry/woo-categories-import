<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/daday-andry
 * @since             1.0.0
 * @package           Woo_Categories_Import
 *
 * @wordpress-plugin
 * Plugin Name:       Woo Categeries Import
 * Plugin URI:        https://github.com/daday-andry/woo-categories-import
 * Description:       CSV Importer for WooCommerce facilitates seamless bulk import of product categories and subcategories from CSV files into your WooCommerce store. Effortlessly manage your product catalog with this user-friendly plugin.
 * Version:           1.0.0
 * Author:            daday-andry
 * Author URI:        https://github.com/daday-andry/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-categories-import
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WOO_CATEGORIES_IMPORT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo-categories-import-activator.php
 */
function activate_woo_categories_import() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-categories-import-activator.php';
	Woo_Categories_Import_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-categories-import-deactivator.php
 */
function deactivate_woo_categories_import() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-categories-import-deactivator.php';
	Woo_Categories_Import_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woo_categories_import' );
register_deactivation_hook( __FILE__, 'deactivate_woo_categories_import' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woo-categories-import.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woo_categories_import() {

	$plugin = new Woo_Categories_Import();
	$plugin->run();

}
run_woo_categories_import();
