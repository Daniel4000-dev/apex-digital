<?php
/**
 * Agency Site Theme Customizer
 *
 * @package Agency_Site
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function agency_site_customize_register( $wp_customize ) {
	// Panel: Agency Settings
	$wp_customize->add_panel(
		'agency_theme_panel',
		array(
			'title'       => __( 'Agency Site Settings', 'agency-site' ),
			'description' => __( 'Customize hero sections, stats, contact info, and branding.', 'agency-site' ),
			'priority'    => 20,
		)
	);

	// Section: Hero Section
	$wp_customize->add_section(
		'agency_hero_section',
		array(
			'title'    => __( 'Homepage Hero', 'agency-site' ),
			'panel'    => 'agency_theme_panel',
			'priority' => 10,
		)
	);

	// Hero Badge
	$wp_customize->add_setting(
		'agency_hero_badge',
		array(
			'default'           => __( 'Digital Marketing & Web Design', 'agency-site' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'agency_hero_badge',
		array(
			'label'   => __( 'Hero Badge Text', 'agency-site' ),
			'section' => 'agency_hero_section',
			'type'    => 'text',
		)
	);

	// Hero Headline
	$wp_customize->add_setting(
		'agency_hero_headline',
		array(
			'default'           => __( 'Turn more visits into enquiries.', 'agency-site' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'agency_hero_headline',
		array(
			'label'   => __( 'Hero Headline', 'agency-site' ),
			'section' => 'agency_hero_section',
			'type'    => 'text',
		)
	);

	// Hero Subheading
	$wp_customize->add_setting(
		'agency_hero_subhead',
		array(
			'default'           => __( 'We help growing businesses improve their websites, get found in search and turn advertising clicks into enquiries.', 'agency-site' ),
			'sanitize_callback' => 'sanitize_textarea_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'agency_hero_subhead',
		array(
			'label'   => __( 'Hero Subhead', 'agency-site' ),
			'section' => 'agency_hero_section',
			'type'    => 'textarea',
		)
	);

	// Hero CTA Primary Text
	$wp_customize->add_setting(
		'agency_hero_cta_text',
		array(
			'default'           => __( 'Discuss your project', 'agency-site' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'agency_hero_cta_text',
		array(
			'label'   => __( 'Primary CTA Text', 'agency-site' ),
			'section' => 'agency_hero_section',
			'type'    => 'text',
		)
	);

	// Hero CTA Primary Link
	$wp_customize->add_setting(
		'agency_hero_cta_link',
		array(
			'default'           => home_url( '/contact/' ),
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'agency_hero_cta_link',
		array(
			'label'   => __( 'Primary CTA Link', 'agency-site' ),
			'section' => 'agency_hero_section',
			'type'    => 'text',
		)
	);

	// Hero CTA Secondary Text
	$wp_customize->add_setting(
		'agency_hero_sec_cta_text',
		array(
			'default'           => __( 'Explore our services', 'agency-site' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'agency_hero_sec_cta_text',
		array(
			'label'   => __( 'Secondary CTA Text', 'agency-site' ),
			'section' => 'agency_hero_section',
			'type'    => 'text',
		)
	);

	// Hero CTA Secondary Link
	$wp_customize->add_setting(
		'agency_hero_sec_cta_link',
		array(
			'default'           => home_url( '/services/' ),
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'agency_hero_sec_cta_link',
		array(
			'label'   => __( 'Secondary CTA Link', 'agency-site' ),
			'section' => 'agency_hero_section',
			'type'    => 'text',
		)
	);

	// Section: Agency Stats
	$wp_customize->add_section(
		'agency_stats_section',
		array(
			'title'    => __( 'Key Statistics', 'agency-site' ),
			'panel'    => 'agency_theme_panel',
			'priority' => 20,
		)
	);

	$stats = array(
		'1' => array(
			'value' => '$45M+',
			'label' => 'Client Revenue Driven',
		),
		'2' => array(
			'value' => '340%',
			'label' => 'Average ROI Increase',
		),
		'3' => array(
			'value' => '98%',
			'label' => 'Client Retention Rate',
		),
		'4' => array(
			'value' => '150+',
			'label' => 'Successful Campaigns',
		),
	);

	foreach ( $stats as $idx => $stat ) {
		$wp_customize->add_setting(
			"agency_stat_{$idx}_val",
			array(
				'default'           => $stat['value'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"agency_stat_{$idx}_val",
			array(
				/* translators: %d: stat counter index */
				'label'   => sprintf( __( 'Stat %d Number', 'agency-site' ), $idx ),
				'section' => 'agency_stats_section',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			"agency_stat_{$idx}_lbl",
			array(
				'default'           => $stat['label'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"agency_stat_{$idx}_lbl",
			array(
				/* translators: %d: stat counter index */
				'label'   => sprintf( __( 'Stat %d Label', 'agency-site' ), $idx ),
				'section' => 'agency_stats_section',
				'type'    => 'text',
			)
		);
	}

	// Section: Header & CTA
	$wp_customize->add_section(
		'agency_header_section',
		array(
			'title'    => __( 'Header & Navigation', 'agency-site' ),
			'panel'    => 'agency_theme_panel',
			'priority' => 5,
		)
	);

	$wp_customize->add_setting(
		'agency_header_cta_text',
		array(
			'default'           => __( 'Discuss your project', 'agency-site' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'agency_header_cta_text',
		array(
			'label'   => __( 'Header Button Label', 'agency-site' ),
			'section' => 'agency_header_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'agency_header_cta_link',
		array(
			'default'           => home_url( '/contact/' ),
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'agency_header_cta_link',
		array(
			'label'   => __( 'Header Button Link', 'agency-site' ),
			'section' => 'agency_header_section',
			'type'    => 'text',
		)
	);

	// Section: Contact Info
	$wp_customize->add_section(
		'agency_contact_section',
		array(
			'title'    => __( 'Contact Information', 'agency-site' ),
			'panel'    => 'agency_theme_panel',
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'agency_email',
		array(
			'default'           => 'growth@apexagency.digital',
			'sanitize_callback' => 'sanitize_email',
		)
	);
	$wp_customize->add_control(
		'agency_email',
		array(
			'label'   => __( 'Email Address', 'agency-site' ),
			'section' => 'agency_contact_section',
			'type'    => 'email',
		)
	);

	$wp_customize->add_setting(
		'agency_phone',
		array(
			'default'           => '+1 (800) 555-0199',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'agency_phone',
		array(
			'label'   => __( 'Phone Number', 'agency-site' ),
			'section' => 'agency_contact_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'agency_address',
		array(
			'default'           => '100 Innovation Blvd, Suite 400, San Francisco, CA 94105',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'agency_address',
		array(
			'label'   => __( 'Office Address', 'agency-site' ),
			'section' => 'agency_contact_section',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'agency_hours',
		array(
			'default'           => 'Mon – Fri: 9:00 AM – 6:00 PM PST',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'agency_hours',
		array(
			'label'   => __( 'Business Hours', 'agency-site' ),
			'section' => 'agency_contact_section',
			'type'    => 'text',
		)
	);

	// Section: Social Links
	$wp_customize->add_section(
		'agency_social_section',
		array(
			'title'    => __( 'Social Media Profiles', 'agency-site' ),
			'panel'    => 'agency_theme_panel',
			'priority' => 40,
		)
	);

	$socials = array(
		'twitter'   => 'Twitter / X',
		'linkedin'  => 'LinkedIn',
		'instagram' => 'Instagram',
		'github'    => 'GitHub',
	);
	foreach ( $socials as $key => $name ) {
		$wp_customize->add_setting(
			"agency_social_{$key}",
			array(
				'default'           => 'https://' . $key . '.com',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			"agency_social_{$key}",
			array(
				'label'   => $name . ' ' . __( 'URL', 'agency-site' ),
				'section' => 'agency_social_section',
				'type'    => 'url',
			)
		);
	}
}
add_action( 'customize_register', 'agency_site_customize_register' );
