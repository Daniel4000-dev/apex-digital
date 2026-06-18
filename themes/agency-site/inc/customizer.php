<?php
/**
 * Agency Site Theme Customizer
 *
 * @package Agency_Site
 */

if (!defined('ABSPATH')) {
    exit;
}

function agency_site_customize_register($wp_customize) {
    // Panel: Agency Settings
    $wp_customize->add_panel('agency_theme_panel', [
        'title'       => __('Agency Site Settings', 'agency-site'),
        'description' => __('Customize hero sections, stats, contact info, and branding.', 'agency-site'),
        'priority'    => 20,
    ]);

    // Section: Hero Section
    $wp_customize->add_section('agency_hero_section', [
        'title'    => __('Homepage Hero', 'agency-site'),
        'panel'    => 'agency_theme_panel',
        'priority' => 10,
    ]);

    // Hero Badge
    $wp_customize->add_setting('agency_hero_badge', [
        'default'           => __('Top-Rated Digital Growth Agency', 'agency-site'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('agency_hero_badge', [
        'label'    => __('Hero Badge Text', 'agency-site'),
        'section'  => 'agency_hero_section',
        'type'     => 'text',
    ]);

    // Hero Headline
    $wp_customize->add_setting('agency_hero_headline', [
        'default'           => __('We Scale High-Growth Brands With Data-Driven Marketing', 'agency-site'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('agency_hero_headline', [
        'label'    => __('Hero Headline', 'agency-site'),
        'section'  => 'agency_hero_section',
        'type'     => 'text',
    ]);

    // Hero Subheading
    $wp_customize->add_setting('agency_hero_subhead', [
        'default'           => __('From organic search dominance to multi-million dollar paid acquisition pipelines, we help modern companies achieve predictable, profitable revenue.', 'agency-site'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('agency_hero_subhead', [
        'label'    => __('Hero Subhead', 'agency-site'),
        'section'  => 'agency_hero_section',
        'type'     => 'textarea',
    ]);

    // Hero CTA Primary Text
    $wp_customize->add_setting('agency_hero_cta_text', [
        'default'           => __('Get Free Growth Audit', 'agency-site'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('agency_hero_cta_text', [
        'label'    => __('Primary CTA Text', 'agency-site'),
        'section'  => 'agency_hero_section',
        'type'     => 'text',
    ]);

    // Hero CTA Primary Link
    $wp_customize->add_setting('agency_hero_cta_link', [
        'default'           => '#contact',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('agency_hero_cta_link', [
        'label'    => __('Primary CTA Link', 'agency-site'),
        'section'  => 'agency_hero_section',
        'type'     => 'text',
    ]);

    // Hero CTA Secondary Text
    $wp_customize->add_setting('agency_hero_sec_cta_text', [
        'default'           => __('Explore Services', 'agency-site'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('agency_hero_sec_cta_text', [
        'label'    => __('Secondary CTA Text', 'agency-site'),
        'section'  => 'agency_hero_section',
        'type'     => 'text',
    ]);

    // Hero CTA Secondary Link
    $wp_customize->add_setting('agency_hero_sec_cta_link', [
        'default'           => '#services',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('agency_hero_sec_cta_link', [
        'label'    => __('Secondary CTA Link', 'agency-site'),
        'section'  => 'agency_hero_section',
        'type'     => 'text',
    ]);

    // Section: Agency Stats
    $wp_customize->add_section('agency_stats_section', [
        'title'    => __('Key Statistics', 'agency-site'),
        'panel'    => 'agency_theme_panel',
        'priority' => 20,
    ]);

    $stats = [
        '1' => ['value' => '$45M+', 'label' => 'Client Revenue Driven'],
        '2' => ['value' => '340%',  'label' => 'Average ROI Increase'],
        '3' => ['value' => '98%',   'label' => 'Client Retention Rate'],
        '4' => ['value' => '150+',  'label' => 'Successful Campaigns'],
    ];

    foreach ($stats as $idx => $stat) {
        $wp_customize->add_setting("agency_stat_{$idx}_val", [
            'default'           => $stat['value'],
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control("agency_stat_{$idx}_val", [
            'label'    => sprintf(__('Stat %d Number', 'agency-site'), $idx),
            'section'  => 'agency_stats_section',
            'type'     => 'text',
        ]);

        $wp_customize->add_setting("agency_stat_{$idx}_lbl", [
            'default'           => $stat['label'],
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control("agency_stat_{$idx}_lbl", [
            'label'    => sprintf(__('Stat %d Label', 'agency-site'), $idx),
            'section'  => 'agency_stats_section',
            'type'     => 'text',
        ]);
    }

    // Section: Header & CTA
    $wp_customize->add_section('agency_header_section', [
        'title'    => __('Header & Navigation', 'agency-site'),
        'panel'    => 'agency_theme_panel',
        'priority' => 5,
    ]);

    $wp_customize->add_setting('agency_header_cta_text', [
        'default'           => __('Book a Call', 'agency-site'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('agency_header_cta_text', [
        'label'    => __('Header Button Label', 'agency-site'),
        'section'  => 'agency_header_section',
        'type'     => 'text',
    ]);

    $wp_customize->add_setting('agency_header_cta_link', [
        'default'           => '#contact',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('agency_header_cta_link', [
        'label'    => __('Header Button Link', 'agency-site'),
        'section'  => 'agency_header_section',
        'type'     => 'text',
    ]);

    // Section: Contact Info
    $wp_customize->add_section('agency_contact_section', [
        'title'    => __('Contact Information', 'agency-site'),
        'panel'    => 'agency_theme_panel',
        'priority' => 30,
    ]);

    $wp_customize->add_setting('agency_email', [
        'default'           => 'growth@apexagency.digital',
        'sanitize_callback' => 'sanitize_email',
    ]);
    $wp_customize->add_control('agency_email', [
        'label'    => __('Email Address', 'agency-site'),
        'section'  => 'agency_contact_section',
        'type'     => 'email',
    ]);

    $wp_customize->add_setting('agency_phone', [
        'default'           => '+1 (800) 555-0199',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('agency_phone', [
        'label'    => __('Phone Number', 'agency-site'),
        'section'  => 'agency_contact_section',
        'type'     => 'text',
    ]);

    $wp_customize->add_setting('agency_address', [
        'default'           => '100 Innovation Blvd, Suite 400, San Francisco, CA 94105',
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    $wp_customize->add_control('agency_address', [
        'label'    => __('Office Address', 'agency-site'),
        'section'  => 'agency_contact_section',
        'type'     => 'textarea',
    ]);

    $wp_customize->add_setting('agency_hours', [
        'default'           => 'Mon – Fri: 9:00 AM – 6:00 PM PST',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('agency_hours', [
        'label'    => __('Business Hours', 'agency-site'),
        'section'  => 'agency_contact_section',
        'type'     => 'text',
    ]);

    // Section: Social Links
    $wp_customize->add_section('agency_social_section', [
        'title'    => __('Social Media Profiles', 'agency-site'),
        'panel'    => 'agency_theme_panel',
        'priority' => 40,
    ]);

    $socials = ['twitter' => 'Twitter / X', 'linkedin' => 'LinkedIn', 'instagram' => 'Instagram', 'github' => 'GitHub'];
    foreach ($socials as $key => $name) {
        $wp_customize->add_setting("agency_social_{$key}", [
            'default'           => 'https://' . $key . '.com',
            'sanitize_callback' => 'esc_url_raw',
        ]);
        $wp_customize->add_control("agency_social_{$key}", [
            'label'    => $name . ' ' . __('URL', 'agency-site'),
            'section'  => 'agency_social_section',
            'type'     => 'url',
        ]);
    }
}
add_action('customize_register', 'agency_site_customize_register');

