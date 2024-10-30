<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    MJ Tracker
 * @subpackage mj-tracker/public
 * @author     Performance Advertising Company
 */
class MJ_Tracker_Public {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.3.0
	 * @param      string    $MJ_Tracker       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $MJ_Tracker, $version ) {

		$this->MJ_Tracker = $MJ_Tracker;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.3.0
	 */
	public function enqueue_styles() {

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

		wp_enqueue_style( $this->MJ_Tracker, plugin_dir_url( __FILE__ ) . 'css/mj-tracker-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.3.0
	 */
	public function enqueue_scripts() {

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

		wp_enqueue_script( $this->MJ_Tracker, plugin_dir_url( __FILE__ ) . 'js/mj-tracker-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add the script on the header.
	 *
	 * @since    1.3.0
	 */
	public function pixel_display_Settings() {

		/**
		 * Display the header script
		 */

		function mj_head_script() {
			$environment = '';
			$mj_scripts_options = get_option('mj_tracker_option_name'); 

			$hs_app_id = $mj_scripts_options['pixel_Tracker_app_id'];
			$hs_cart = $mj_scripts_options['pixel_Tracker_cart'];

			if ($hs_cart != 'none') {
				$environment = '&environment=' . $hs_cart;
			}

			if ($hs_app_id !== "") {
				wp_enqueue_script('tags-cnna', 'https://tags.cnna.io/?appId=' . $hs_app_id . $environment, null, null, false);
			}
		}

		function mj_pixel_ads_tracker()
		{
			$product = array();
			global $wp_query;
			$mj_scripts_options = get_option('mj_tracker_option_name'); 
			$hs_cart = $mj_scripts_options['pixel_Tracker_cart'];

				if ($hs_cart === 'woocommerce') {
					
					if (!empty($wp_query->query_vars['order-received'])) {
						$order = wc_get_order($wp_query->query_vars['order-received']);
						$items = $order->get_items();
				
						if (!empty($items)) {
							foreach ($items as $item) {
								$product[] = $item->get_data();
							}
						}
				
						$check = get_post_meta($order->get_id(), 'thank_you_page_check', true);
				
						if ($check) {
							return;
						}
				
						update_post_meta($order->get_id(), 'thank_you_page_check', true);
				
						echo '<script>
							var transactionOrder = ' . $order . ';
							var transactionItems = ' . json_encode($product) . ';
						</script>';
					}
				}

		}

		add_action('wp_enqueue_scripts', 'mj_head_script');
		add_action('wp_head', 'mj_pixel_ads_tracker');

	}

}
