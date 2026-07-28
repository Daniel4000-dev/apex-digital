<?php
/**
 * Agency Site functions and definitions
 *
 * @package Agency_Site
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'AGENCY_SITE_VERSION', '1.0.0' );
define( 'AGENCY_SITE_DIR', get_template_directory() );
define( 'AGENCY_SITE_URI', get_template_directory_uri() );

// Include includes
require_once AGENCY_SITE_DIR . '/inc/customizer.php';
require_once AGENCY_SITE_DIR . '/inc/cpt-services.php';
require_once AGENCY_SITE_DIR . '/inc/template-tags.php';

/**
 * Theme Setup
 */
function agency_site_setup() {
	// Make theme available for translation
	load_theme_textdomain( 'agency-site', AGENCY_SITE_DIR . '/languages' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage document title
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 675, true ); // 16:9
	add_image_size( 'agency-card', 600, 400, true );
	add_image_size( 'agency-hero', 1600, 900, true );

	// Register navigation menus
	register_nav_menus(
		array(
			'primary'  => esc_html__( 'Primary Navigation', 'agency-site' ),
			'footer'   => esc_html__( 'Footer Quick Links', 'agency-site' ),
			'services' => esc_html__( 'Footer Services Links', 'agency-site' ),
		)
	);

	// HTML5 markup support
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Custom Logo support
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 280,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	// Gutenberg features
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'customize-selective-refresh-widgets' );
}
add_action( 'after_setup_theme', 'agency_site_setup' );

/**
 * Register Widget Areas
 */
function agency_site_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Blog Sidebar', 'agency-site' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Appears on the blog listing and single article pages.', 'agency-site' ),
			'before_widget' => '<section id="%1$s" class="widget mb-8 p-6 bg-slate-50 rounded-2xl border border-slate-100 %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title text-base font-bold text-slate-900 mb-4 pb-2 border-b border-slate-200">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Column 1', 'agency-site' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Appears in the first footer column.', 'agency-site' ),
			'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="text-white font-semibold text-sm tracking-wide uppercase mb-4">',
			'after_title'   => '</h4>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Column 2', 'agency-site' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'Appears in the second footer column.', 'agency-site' ),
			'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="text-white font-semibold text-sm tracking-wide uppercase mb-4">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'agency_site_widgets_init' );

/**
 * Enqueue Scripts and Styles
 */
function agency_site_scripts() {
	// Google Fonts: Plus Jakarta Sans
	wp_enqueue_style(
		'agency-fonts',
		'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap',
		array(),
		null
	);

	// Main Compiled Tailwind Stylesheet
	$css_path = AGENCY_SITE_DIR . '/assets/dist/css/style.css';
	$css_ver  = file_exists( $css_path ) ? filemtime( $css_path ) : AGENCY_SITE_VERSION;
	wp_enqueue_style(
		'agency-styles',
		AGENCY_SITE_URI . '/assets/dist/css/style.css',
		array( 'agency-fonts' ),
		$css_ver
	);

	// Vanilla JavaScript
	$js_path = AGENCY_SITE_DIR . '/assets/dist/js/main.js';
	$js_ver  = file_exists( $js_path ) ? filemtime( $js_path ) : AGENCY_SITE_VERSION;
	wp_enqueue_script(
		'agency-main',
		AGENCY_SITE_URI . '/assets/dist/js/main.js',
		array(),
		$js_ver,
		true
	);

	// Localize Script for AJAX contact form
	wp_localize_script(
		'agency-main',
		'agencySiteData',
		array(
			'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
			'nonce'      => wp_create_nonce( 'agency_contact_action_nonce' ),
			'siteUrl'    => home_url( '/' ),
			'successMsg' => esc_html__( 'Thank you! Your message has been received. Our growth strategist will contact you within 24 hours.', 'agency-site' ),
			'errorMsg'   => esc_html__( 'There was an error sending your message. Please try again or reach out directly via email.', 'agency-site' ),
		)
	);

	// Threaded comments
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'agency_site_scripts' );

/**
 * Handle Contact Form Submission (Fallback if Agency Site Core plugin is not active)
 */
if ( ! class_exists( 'Agency_Core_Enquiry_Handler' ) ) {
	function agency_site_handle_contact_submission() {
		check_ajax_referer( 'agency_contact_action_nonce', 'security' );

		$name    = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : '';
		$email   = isset( $_POST['email'] ) ? sanitize_email( $_POST['email'] ) : '';
		$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( $_POST['phone'] ) : '';
		$service = isset( $_POST['service'] ) ? sanitize_text_field( $_POST['service'] ) : '';
		$budget  = isset( $_POST['budget'] ) ? sanitize_text_field( $_POST['budget'] ) : '';
		$message = isset( $_POST['message'] ) ? sanitize_textarea_field( $_POST['message'] ) : '';

		if ( empty( $name ) || empty( $email ) || ! is_email( $email ) || empty( $message ) ) {
			wp_send_json_error(
				array(
					'message' => esc_html__( 'Please fill in all required fields with a valid email address.', 'agency-site' ),
				)
			);
			wp_die();
		}

		$admin_email = get_option( 'admin_email' );
		$subject     = sprintf( '[%s Lead] Inbound Consultation Request from %s', get_bloginfo( 'name' ), $name );
		$body        = "You received a new growth consultation inquiry from the website contact form:\n\n";
		$body       .= "Name: {$name}\n";
		$body       .= "Email: {$email}\n";
		$body       .= "Phone: {$phone}\n";
		$body       .= "Service Needed: {$service}\n";
		$body       .= "Monthly Budget: {$budget}\n\n";
		$body       .= "Project Details:\n{$message}\n\n";
		$body       .= 'Sent from: ' . home_url( '/' ) . "\n";
		$body       .= 'Date: ' . current_time( 'mysql' ) . "\n";

		$headers = array(
			'Content-Type: text/plain; charset=UTF-8',
			'From: ' . get_bloginfo( 'name' ) . ' <' . $admin_email . '>',
			'Reply-To: ' . $name . ' <' . $email . '>',
		);

		@wp_mail( $admin_email, $subject, $body, $headers );

		wp_send_json_success(
			array(
				'message' => esc_html__( 'Thank you! Your inquiry has been sent successfully. A senior strategist will review your submission and reply shortly.', 'agency-site' ),
			)
		);
		wp_die();
	}
	add_action( 'wp_ajax_agency_submit_contact', 'agency_site_handle_contact_submission' );
	add_action( 'wp_ajax_nopriv_agency_submit_contact', 'agency_site_handle_contact_submission' );
}

/**
 * Fallback menu rendering with clean Tailwind styles if no custom menu is assigned
 */
function agency_site_fallback_menu() {
	$current_url = home_url( add_query_arg( array(), $GLOBALS['wp']->request ?? '' ) );
	$items       = array(
		array(
			'url'   => home_url( '/' ),
			'title' => __( 'Home', 'agency-site' ),
		),
		array(
			'url'   => home_url( '/services/' ),
			'title' => __( 'Services', 'agency-site' ),
		),
		array(
			'url'   => home_url( '/blog/' ),
			'title' => __( 'Blog & Insights', 'agency-site' ),
		),
		array(
			'url'   => home_url( '/contact/' ),
			'title' => __( 'Contact', 'agency-site' ),
		),
	);

	echo '<ul class="flex items-center gap-1 md:gap-2 text-sm font-medium text-slate-700">';
	foreach ( $items as $item ) {
		$is_active    = ( trailingslashit( $item['url'] ) === trailingslashit( $current_url ) || ( $item['url'] === home_url( '/' ) && is_front_page() ) );
		$active_class = $is_active ? 'text-agency-600 font-semibold bg-agency-50' : 'text-slate-600 hover:text-agency-600 hover:bg-slate-50';
		echo '<li>';
		echo '<a href="' . esc_url( $item['url'] ) . '" class="px-3.5 py-2 rounded-lg transition-colors ' . esc_attr( $active_class ) . '">';
		echo esc_html( $item['title'] );
		echo '</a>';
		echo '</li>';
	}
	echo '</ul>';
}

/**
 * Filter wp_nav_menu output to apply Tailwind styles
 */
function agency_site_nav_menu_link_attributes( $atts, $item, $args ) {
	if ( isset( $args->theme_location ) && $args->theme_location === 'primary' ) {
		$current_classes = isset( $atts['class'] ) ? $atts['class'] : '';
		$is_active       = in_array( 'current-menu-item', $item->classes ?? array() ) || in_array( 'current_page_item', $item->classes ?? array() );

		$base = 'px-3.5 py-2 rounded-lg text-sm font-medium transition-colors ';
		if ( $is_active ) {
			$base .= 'text-agency-600 font-semibold bg-agency-50 ';
		} else {
			$base .= 'text-slate-600 hover:text-agency-600 hover:bg-slate-50 ';
		}
		$atts['class'] = trim( $current_classes . ' ' . $base );
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'agency_site_nav_menu_link_attributes', 10, 3 );
