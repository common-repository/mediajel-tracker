<?php

/**
 * @package          MJ Tracker
 *
 * Plugin Name:       MJ Tracker
 * Plugin URI:        https://wordpress.org/plugins/campaign-performance-tracker
 * Description:       Custom settings page for MJ Tracker
 * Version:           1.3.0
 * Author:            Performance Advertising Company
 * Author URI:        https://google.com
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       mj-tracker
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * 
 */
define( 'MJ_Tracker_VERSION', '1.3.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mj-tracker-activator.php
 */
function mj_on_tracker() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mj-tracker-activator.php';
	MJ_Tracker_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function mj_off_tracker() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mj-tracker-deactivator.php';
	MJ_Tracker_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'mj_on_tracker' );
register_deactivation_hook( __FILE__, 'mj_off_tracker' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mj-tracker.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since  1.3.0
 */
function mj_pixel_tracker() {

	$plugin = new mj_tracker();
	$plugin->run();

}
mj_pixel_tracker();
