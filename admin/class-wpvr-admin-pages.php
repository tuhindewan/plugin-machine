<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://rextheme.com/
 * @since      1.0.0
 *
 * @package    Wpvr
 * @subpackage Wpvr/admin
 */

class Wpvr_Admin_Pages {

	/**
	 * Admin page setup is specified in this area.
	 */
	function wpvr_add_admin_pages() {

		add_menu_page( 'WP VR', 'WP VR', 'manage_options', 'wpvr', array( $this, 'wpvr_admin_doc'),plugins_url(). '/wpvr/images/icon.png' , 25);

		add_submenu_page( 'wpvr', 'WP VR', 'Get Started','manage_options', 'wpvr', array( $this, 'wpvr_admin_doc'));

		add_submenu_page( 'wpvr', 'WP VR', 'Tours','manage_options', 'edit.php?post_type=wpvr_item', NULL);

		add_submenu_page( 'wpvr', 'WP VR', 'Add New Tour','manage_options', 'post-new.php?post_type=wpvr_item', NULL);

		do_action('wpvr_pro_license_page');

	}

	function wpvr_admin_doc() {
        require_once plugin_dir_path(__FILE__) . '/partials/wpvr_documentation.php';
	}
	function wpvr_pro_admin_doc() {
        require_once plugin_dir_path(__FILE__) . '/partials/wpvr_license.php';
	}
}
