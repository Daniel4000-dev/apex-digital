<?php
/**
 * ACF Pro Integration for Agency Services
 *
 * Registers field groups programmatically and configures acf-json auto-sync
 * for seamless editable service content (tagline, pricing, badge, deliverables, FAQs).
 *
 * @package Agency_Site_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Agency_Core_ACF_Integration {

	public function __construct() {
		add_action( 'acf/init', array( $this, 'register_field_group' ) );
		add_filter( 'acf/settings/save_json', array( $this, 'set_save_json_path' ) );
		add_filter( 'acf/settings/load_json', array( $this, 'set_load_json_path' ) );
	}

	/**
	 * Register ACF Field Group programmatically for agency_service CPT
	 */
	public function register_field_group() {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		acf_add_local_field_group(
			array(
				'key'                   => 'group_agency_service_meta',
				'title'                 => __( 'Service Specifications & Deliverables', 'agency-site-core' ),
				'fields'                => array(
					array(
						'key'          => 'field_agency_service_tagline',
						'label'        => __( 'Service Tagline', 'agency-site-core' ),
						'name'         => '_service_tagline',
						'type'         => 'text',
						'instructions' => __( 'One punchy strategic summary sentence.', 'agency-site-core' ),
					),
					array(
						'key'          => 'field_agency_service_pricing',
						'label'        => __( 'Pricing / Retainer Indicator', 'agency-site-core' ),
						'name'         => '_service_pricing',
						'type'         => 'text',
						'instructions' => __( 'e.g. "From $4,500/mo" or "Custom Engagement".', 'agency-site-core' ),
					),
					array(
						'key'          => 'field_agency_service_badge',
						'label'        => __( 'Highlight Badge', 'agency-site-core' ),
						'name'         => '_service_badge',
						'type'         => 'text',
						'instructions' => __( 'e.g. "Most Popular" or "Enterprise Ready".', 'agency-site-core' ),
					),
					array(
						'key'          => 'field_agency_service_deliverables',
						'label'        => __( 'Key Deliverables (1 per line)', 'agency-site-core' ),
						'name'         => '_service_deliverables',
						'type'         => 'textarea',
						'rows'         => 5,
						'instructions' => __( 'Enter each concrete deliverable on a new line.', 'agency-site-core' ),
					),
					array(
						'key'          => 'field_agency_service_faqs',
						'label'        => __( 'Service FAQs', 'agency-site-core' ),
						'name'         => '_service_faqs',
						'type'         => 'repeater',
						'instructions' => __( 'Add questions and detailed answers for the FAQ accordion.', 'agency-site-core' ),
						'sub_fields'   => array(
							array(
								'key'   => 'field_agency_faq_question',
								'label' => __( 'Question', 'agency-site-core' ),
								'name'  => 'question',
								'type'  => 'text',
							),
							array(
								'key'   => 'field_agency_faq_answer',
								'label' => __( 'Answer', 'agency-site-core' ),
								'name'  => 'answer',
								'type'  => 'textarea',
								'rows'  => 3,
							),
						),
					),
				),
				'location'              => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'agency_service',
						),
					),
				),
				'menu_order'            => 0,
				'position'              => 'normal',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
			)
		);
	}

	// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
	public function set_save_json_path( $path ) {
		$theme_json_dir = get_template_directory() . '/acf-json';
		if ( ! file_exists( $theme_json_dir ) ) {
			wp_mkdir_p( $theme_json_dir );
		}
		return $theme_json_dir;
	}

	public function set_load_json_path( $paths ) {
		unset( $paths[0] );
		$paths[] = get_template_directory() . '/acf-json';
		return $paths;
	}
}
