<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    MJ Tracker
 * @subpackage mj-tracker/admin
 * @author     Performance Advertising Company
 */
class MJ_Tracker_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.3.0
	 * @access   private
	 * @var      string    $MJ_Tracker    The ID of this plugin.
	 */
	private $MJ_Tracker;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.3.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * All options for the Performance Advertising Company scripts.
	 *
	 * @since    1.3.0
	 * @access   private
	 * @var      array    $mj_tracker_options    An array of options for the Performance Advertising Company Scripts.
	 */
	private $mj_tracker_options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.3.0
	 * @param      string    $MJ_Tracker       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($MJ_Tracker, $version)
	{

		$this->MJ_Tracker = $MJ_Tracker;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.3.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in MJ_Tracker_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The MJ_Tracker_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->MJ_Tracker, plugin_dir_url(__FILE__) . 'css/mj-tracker-admin.css', array(), $this->version, 'all');

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.3.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in MJ_Tracker_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The MJ_Tracker_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->MJ_Tracker, plugin_dir_url(__FILE__) . 'js/mj-tracker-admin.js', array('jquery'), $this->version, false);

	}

	/**
	 * Add the MJ Tracker page
	 *
	 * @since    1.3.0
	 */



	public function pixel_add_kpi_page()
	{

		add_menu_page(
			'MJ Tracker',
			// page_title
			'MJ Tracker',
			// menu_title
			'manage_options',
			// capability
			'mj-tracker',
			// menu_slug
			array($this, 'pixel_mj_tracker_create_admin_page'),
			// function
			'dashicons-admin-generic',
			// icon_url
			2 // position
		);

	}

	public function pixel_mj_tracker_create_admin_page()
	{
		$this->mj_tracker_options = get_option('mj_tracker_option_name'); ?>

		<div class="wrap">
			<h2>MJ Tracker</h2>
			<p></p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
				settings_fields('mj_tracker_option_group');
				do_settings_sections('mj-tracker-admin');
				submit_button();
				?>
			</form>
		</div>
	<?php }

	/**
	 * Add the setting sections and fields
	 *
	 * @since    1.3.0
	 */


	public function pixel_register_settings()
	{

		register_setting(
			'mj_tracker_option_group',
			// option_group
			'mj_tracker_option_name',
			// option_name
			array($this, 'pixel_mj_tracker_sanitize') // sanitize_callback
		);

		add_settings_section(
			'Tracker_setting_section',
			// id
			'Universal Tracker (MVP)',
			// title
			array($this, 'pixel_Tracker_section_info'),
			// callback
			'mj-tracker-admin' // page
		);

		add_settings_field(
			'pixel_Tracker_app_id',
			// id
			'APP ID',
			// title
			array($this, 'pixel_Tracker_app_id_callback'),
			// callback
			'mj-tracker-admin',
			// page
			'Tracker_setting_section' // section
		);

		add_settings_field(
			'pixel_Tracker_cart',
			// id
			'Cart',
			// title
			array($this, 'pixel_Tracker_cart_callback'),
			// callback
			'mj-tracker-admin',
			// page
			'Tracker_setting_section' // section
		);

	}

	public function pixel_mj_tracker_sanitize($input)
	{
		$sanitary_values = array();
		if (isset($input['pixel_Tracker_app_id'])) {
			$sanitary_values['pixel_Tracker_app_id'] = sanitize_text_field($input['pixel_Tracker_app_id']);
		}

		if (isset($input['pixel_Tracker_cart'])) {
			$sanitary_values['pixel_Tracker_cart'] = $input['pixel_Tracker_cart'];
		}

		if (isset($input['pixel_Tracker_testing'])) {
			$sanitary_values['pixel_Tracker_testing'] = $input['pixel_Tracker_testing'];
		}

		return $sanitary_values;
	}

	public function pixel_Tracker_section_info()
	{

	}

	public function pixel_Tracker_app_id_callback()
	{
		printf(
			'<input class="regular-text" type="text" name="mj_tracker_option_name[pixel_Tracker_app_id]" id="pixel_Tracker_app_id" value="%s">',
			isset($this->mj_tracker_options['pixel_Tracker_app_id']) ? esc_attr($this->mj_tracker_options['pixel_Tracker_app_id']) : ''
		);
	}

	public function pixel_Tracker_cart_callback()
	{

		$options = array(
			"none" => "none",
			"jane" => "jane",
			"dutchie-subdomain" => "dutchie-subdomain",
			"dutchie-iframe" => "dutchie-iframe",
			"meadow" => "meadow",
			"tymber" => "tymber",
			"woocommerce" => "woocommerce",
			"greenrush" => "greenrush",
			"buddi" => "buddi",
			"shopify" => "shopify",
			"lightspeed" => "lightspeed",
			"olla" => "olla",
			"grassdoor" => "grassdoor",
			"wefunder" => "wefunder",
			"ecwid" => "ecwid",
			"square" => "square",
			"dutchieplus" => "dutchieplus",
			"webjoint" => "webjoint",
			"sticky-leaf" => "sticky-leaf",
			"dispense" => "dispense",
			"bigcommerce" => "bigcommerce",
			"yotpo" => "yotpo"
		);
	
		$selected = isset($this->mj_tracker_options["pixel_Tracker_cart"]) ? $this->mj_tracker_options["pixel_Tracker_cart"] : "none";
	
		echo '<select name="mj_tracker_option_name[pixel_Tracker_cart]" id="pixel_Tracker_cart">';
		foreach ($options as $value => $label) {
			$selected_attr = selected($selected, $value, false);
			echo '<option value="' . esc_attr($value) . '" ' . esc_attr($selected_attr) . '>' . esc_html($label) . '</option>';
		}
		echo '</select>';

	}

}