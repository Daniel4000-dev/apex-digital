<?php
/**
 * Template Name: Campaign Landing Page
 * Description: Editor-managed campaign landing page powered by ACF Pro, Timber/Twig, Foundation XY Grid, and Gravity Forms.
 *
 * @package Agency_Site
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Ensure Composer autoloader is available
$composer_autoload = dirname( get_template_directory(), 2 ) . '/vendor/autoload.php';
if ( file_exists( $composer_autoload ) ) {
	require_once $composer_autoload;
}

$campaign_post_id = get_the_ID();

// 1. Resolve ACF Pro Campaign Fields with Safe Fallback Defaults
$hero_badge      = '';
$hero_heading    = '';
$hero_subheading = '';
$hero_image_url  = '';
$intro_heading   = '';
$intro_content   = '';
$benefits_data   = array();
$faqs_data       = array();
$cta_text        = '';
$cta_url         = '';
$gf_form_id      = 0;

if ( function_exists( 'get_field' ) ) {
	$hero_badge      = get_field( 'campaign_hero_badge', $campaign_post_id );
	$hero_heading    = get_field( 'campaign_hero_heading', $campaign_post_id );
	$hero_subheading = get_field( 'campaign_hero_subheading', $campaign_post_id );
	$hero_image_url  = get_field( 'campaign_hero_image', $campaign_post_id );
	$intro_heading   = get_field( 'campaign_intro_heading', $campaign_post_id );
	$intro_content   = get_field( 'campaign_intro_content', $campaign_post_id );
	$benefits_data   = get_field( 'campaign_benefits', $campaign_post_id );
	$faqs_data       = get_field( 'campaign_faqs', $campaign_post_id );
	$cta_text        = get_field( 'campaign_cta_text', $campaign_post_id );
	$cta_url         = get_field( 'campaign_cta_url', $campaign_post_id );
	$gf_form_id      = (int) get_field( 'campaign_gf_form_id', $campaign_post_id );
} else {
	// Native post meta fallback
	$hero_badge      = get_post_meta( $campaign_post_id, 'campaign_hero_badge', true );
	$hero_heading    = get_post_meta( $campaign_post_id, 'campaign_hero_heading', true );
	$hero_subheading = get_post_meta( $campaign_post_id, 'campaign_hero_subheading', true );
	$hero_image_url  = get_post_meta( $campaign_post_id, 'campaign_hero_image', true );
	$intro_heading   = get_post_meta( $campaign_post_id, 'campaign_intro_heading', true );
	$intro_content   = get_post_meta( $campaign_post_id, 'campaign_intro_content', true );
	$cta_text        = get_post_meta( $campaign_post_id, 'campaign_cta_text', true );
	$cta_url         = get_post_meta( $campaign_post_id, 'campaign_cta_url', true );
	$gf_form_id      = (int) get_post_meta( $campaign_post_id, 'campaign_gf_form_id', true );
}

// 2. Safe, Professional Defaults (when fields are unconfigured or new)
if ( empty( $hero_badge ) ) {
	$hero_badge = __( 'Limited Q1 Cohort · 5 Slots Available', 'agency-site' );
}

if ( empty( $hero_heading ) ) {
	$hero_heading = __( 'Q1 Performance Growth Sprint', 'agency-site' );
}

if ( empty( $hero_subheading ) ) {
	$hero_subheading = __( 'A 4-week intensive engineering sprint combining technical SEO teardowns, landing page CRO, and high-intent paid search alignment to maximize enquiry conversion.', 'agency-site' );
}

if ( empty( $hero_image_url ) && has_post_thumbnail( $campaign_post_id ) ) {
	$hero_image_url = get_the_post_thumbnail_url( $campaign_post_id, 'agency-hero' );
}

if ( empty( $intro_heading ) ) {
	$intro_heading = __( 'Designed for immediate commercial impact.', 'agency-site' );
}

if ( empty( $intro_content ) ) {
	$intro_content = __( 'Most agency engagements get bogged down in multi-month onboarding without shipping tangible performance improvements. The Q1 Performance Growth Sprint is a tightly scoped 4-week engagement with senior strategists focused entirely on unblocking your enquiry funnel.', 'agency-site' );
}

if ( empty( $benefits_data ) || ! is_array( $benefits_data ) ) {
	$benefits_data = array(
		array(
			'title'       => __( 'Technical & UX Teardown', 'agency-site' ),
			'description' => __( 'Full audit of Core Web Vitals, mobile tap targets, crawl path bottlenecks, and form drop-off friction across your top 5 commercial landing pages.', 'agency-site' ),
			'metric'      => __( '100% WCAG & Speed Baseline', 'agency-site' ),
		),
		array(
			'title'       => __( 'High-Intent Search Architecture', 'agency-site' ),
			'description' => __( 'Reorganize commercial service pages and topical authority clusters to capture high-value buyer searches and eliminate internal keyword cannibalization.', 'agency-site' ),
			'metric'      => __( '+25% Organic Visibility', 'agency-site' ),
		),
		array(
			'title'       => __( 'Paid Funnel & Creative Alignment', 'agency-site' ),
			'description' => __( 'Direct connection between paid advertising messaging and landing page conversion proof, eliminating ad spend waste on unqualified clicks.', 'agency-site' ),
			'metric'      => __( 'Sub-3s Dedicated Landing Path', 'agency-site' ),
		),
		array(
			'title'       => __( 'Conversion Engineering & Live Handoff', 'agency-site' ),
			'description' => __( 'Production deployment of high-converting enquiry flows, automated CRM webhook routing, spam protection, and complete handover documentation.', 'agency-site' ),
			'metric'      => __( 'Zero-Leakage Ingress System', 'agency-site' ),
		),
	);
}

if ( empty( $faqs_data ) || ! is_array( $faqs_data ) ) {
	$faqs_data = array(
		array(
			'question' => __( 'What is required from our internal team before the sprint starts?', 'agency-site' ),
			'answer'   => __( 'We require access to Google Search Console, Google Analytics 4, ad accounts (if active), and your WordPress staging or production environment. We conduct an initial 60-minute kick-off interview with your commercial lead.', 'agency-site' ),
		),
		array(
			'question' => __( 'Can this sprint be conducted on an existing custom WordPress build?', 'agency-site' ),
			'answer'   => __( 'Yes. Our team specializes in custom classic PHP themes, ACF Pro architectures, and modular WordPress environments. We never mandate complete rewrites when targeted surgical refactoring yields faster ROI.', 'agency-site' ),
		),
		array(
			'question' => __( 'How are enquiries captured and delivered during the engagement?', 'agency-site' ),
			'answer'   => __( 'All enquiry submissions are recorded securely in your WordPress database, verified against honeypot/rate-limit filters, and dispatched to your CRM or endpoint via signed HMAC-SHA256 webhooks with zero duplicate dispatches.', 'agency-site' ),
		),
		array(
			'question' => __( 'What happens after the 4-week sprint concludes?', 'agency-site' ),
			'answer'   => __( 'You receive a complete technical runbook, measured Core Web Vitals reports, and full ownership of all custom theme assets and Twig templates. Ongoing quarterly maintenance retainers are available upon request.', 'agency-site' ),
		),
	);
}

if ( empty( $cta_text ) ) {
	$cta_text = __( 'Apply for Q1 Sprint', 'agency-site' );
}

if ( empty( $cta_url ) ) {
	$cta_url = '#campaign-enquiry';
}

// 3. Resolve Gravity Forms Embedding
$gravity_form_html = '';
if ( ! $gf_form_id ) {
	$gf_form_id = (int) apply_filters( 'agency_campaign_gravity_form_id', 0, $campaign_post_id );
}

if ( $gf_form_id > 0 && function_exists( 'gravity_form' ) ) {
	ob_start();
	gravity_form( $gf_form_id, false, false, false, null, true );
	$gravity_form_html = ob_get_clean();
}

// 4. Timber Twig Rendering
if ( class_exists( '\Timber\Timber' ) ) {
	$context             = \Timber\Timber::context();
	$context['post']     = \Timber\Timber::get_post( $campaign_post_id );
	$context['campaign'] = array(
		'title'             => get_the_title( $campaign_post_id ),
		'hero_badge'        => $hero_badge,
		'hero_heading'      => $hero_heading,
		'hero_subheading'   => $hero_subheading,
		'hero_image_url'    => $hero_image_url,
		'intro_heading'     => $intro_heading,
		'intro_content'     => $intro_content,
		'benefits'          => $benefits_data,
		'faqs'              => $faqs_data,
		'cta_text'          => $cta_text,
		'cta_url'           => $cta_url,
		'gravity_form_html' => $gravity_form_html,
		'enquiry_nonce'     => wp_create_nonce( 'agency_contact_action_nonce' ),
	);

	\Timber\Timber::render( 'campaign.twig', $context );
} else {
	// Graceful Fallback if Timber is uninstalled or Composer autoload missing
	get_header();
	?>
	<main id="main-content" class="campaign-foundation-scope" role="main">
		<div class="grid-container py-12">
			<div class="grid-x grid-padding-x">
				<div class="cell small-12">
					<div class="p-6 bg-amber-50 border border-amber-200 text-amber-900 mb-8 font-mono text-xs">
						<?php esc_html_e( 'Notice: Timber/Twig package is currently uninstalled. Displaying native PHP campaign fallback.', 'agency-site' ); ?>
					</div>
					<h1 class="text-4xl font-extrabold text-ink mb-4"><?php echo esc_html( $hero_heading ); ?></h1>
					<p class="text-lg text-ink/80 mb-8"><?php echo esc_html( $hero_subheading ); ?></p>
				</div>
			</div>
		</div>
	</main>
	<?php
	get_footer();
}
