<?php
/**
 * Plugin Name: Agency Site Core
 * Plugin URI: https://example.com/agency-site-core
 * Description: Essential companion plugin for the Agency Site theme. Handles the Services custom post type, custom meta fields, consultation enquiry processing, webhook integrations, technical SEO, and analytics tracking.
 * Version: 1.0.0
 * Author: Antigravity
 * Author URI: https://example.com
 * License: GPL-2.0-or-later
 * Text Domain: agency-site-core
 * Requires at least: 6.0
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'AGENCY_CORE_VERSION', '1.0.0' );
define( 'AGENCY_CORE_FILE', __FILE__ );
define( 'AGENCY_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'AGENCY_CORE_URL', plugin_dir_url( __FILE__ ) );

// Autoload plugin classes
require_once AGENCY_CORE_DIR . 'includes/class-cpt-service.php';
require_once AGENCY_CORE_DIR . 'includes/class-webhook-dispatcher.php';
require_once AGENCY_CORE_DIR . 'includes/class-enquiry-handler.php';
require_once AGENCY_CORE_DIR . 'includes/class-seo-manager.php';
require_once AGENCY_CORE_DIR . 'includes/class-analytics-manager.php';
require_once AGENCY_CORE_DIR . 'includes/class-admin-settings.php';
require_once AGENCY_CORE_DIR . 'includes/class-acf-integration.php';
require_once AGENCY_CORE_DIR . 'includes/class-gravity-forms-integration.php';

final class Agency_Site_Core {

	private static $instance = null;

	public $service_cpt;
	public $enquiry_handler;
	public $seo_manager;
	public $analytics_manager;
	public $admin_settings;
	public $acf_integration;
	public $gravity_forms_integration;

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		$this->service_cpt               = new Agency_Core_CPT_Service();
		$this->enquiry_handler           = new Agency_Core_Enquiry_Handler();
		$this->seo_manager               = new Agency_Core_SEO_Manager();
		$this->analytics_manager         = new Agency_Core_Analytics_Manager();
		$this->acf_integration           = new Agency_Core_ACF_Integration();
		$this->gravity_forms_integration = new Agency_Core_Gravity_Forms_Integration();

		if ( is_admin() ) {
			$this->admin_settings = new Agency_Core_Admin_Settings();
		}

		register_activation_hook( AGENCY_CORE_FILE, array( $this, 'activate' ) );
		register_deactivation_hook( AGENCY_CORE_FILE, array( $this, 'deactivate' ) );
	}

	public function activate() {
		// Register post types and flush rewrite rules
		$this->service_cpt->register_post_type();
		$this->enquiry_handler->register_enquiry_cpt();
		flush_rewrite_rules();
	}

	public function deactivate() {
		flush_rewrite_rules();
	}
}

function agency_site_core() {
	return Agency_Site_Core::instance();
}

// Boot plugin
add_action( 'plugins_loaded', 'agency_site_core' );
