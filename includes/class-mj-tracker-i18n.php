<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.google.com
 * @since      1.3.0
 *
 * @package    MJ_Settings
 * @subpackage MJ_Settings/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.3.0
 * @package    MJ Tracker
 * @subpackage mj-tracker/includes
 * @author     Performance Advertising Company
 */
class MJ_Tracker_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.3.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'mj-tracker',
			false,
			plugin_dir_path(__FILE__) . 'languages/'
		);

	}



}
