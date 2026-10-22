<?php
/**
 * Template part for displaying a reusable conversion CTA banner: Editorial Studio Aesthetic
 *
 * @package Agency_Site
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cta_headline = $args['headline'] ?? __( 'Ready to make your business hard to miss?', 'agency-site' );
$cta_subhead  = $args['subhead'] ?? __( 'We help growing businesses improve their websites, get found in search and turn advertising clicks into enquiries.', 'agency-site' );
$cta_button   = $args['button_text'] ?? get_theme_mod( 'agency_hero_cta_text', __( 'Discuss your project', 'agency-site' ) );
$cta_link     = $args['button_link'] ?? get_theme_mod( 'agency_hero_cta_link', home_url( '/contact/' ) );
?>
<section class="bg-ivory border-t border-ink/15 py-16 lg:py-24 relative overflow-hidden">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="border border-ink/20 bg-ivory p-8 sm:p-14 lg:p-16 relative">
			<div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8">
				<div class="max-w-2xl">
					<span class="inline-flex items-center gap-2 font-mono text-xs uppercase tracking-widest text-ink/70 mb-4">
						<span class="w-1.5 h-1.5 bg-cobalt"></span>
						<?php esc_html_e( 'Project Inquiries & Engagements', 'agency-site' ); ?>
					</span>
					<h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-ink tracking-tight font-heading leading-tight mb-4">
						<?php echo esc_html( $cta_headline ); ?>
					</h2>
					<p class="text-ink/80 text-base sm:text-lg font-normal leading-relaxed">
						<?php echo esc_html( $cta_subhead ); ?>
					</p>
				</div>
				<div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 shrink-0">
					<a href="<?php echo esc_url( $cta_link ); ?>" class="btn-primary !py-4 !px-8 text-sm uppercase tracking-wider font-semibold text-center">
						<span><?php echo esc_html( $cta_button ); ?></span>
						<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
					</a>
					<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="btn-secondary !py-4 !px-8 text-sm uppercase tracking-wider font-semibold text-center">
						<?php esc_html_e( 'Explore our services', 'agency-site' ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>

