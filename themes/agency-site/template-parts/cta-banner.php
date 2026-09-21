<?php
/**
 * Template part for displaying a reusable conversion CTA banner
 *
 * @package Agency_Site
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cta_headline = $args['headline'] ?? __( 'Ready to turn more visits into enquiries?', 'agency-site' );
$cta_subhead  = $args['subhead'] ?? __( 'We help growing businesses improve their websites, get found in search and turn advertising clicks into enquiries.', 'agency-site' );
$cta_button   = $args['button_text'] ?? get_theme_mod( 'agency_hero_cta_text', __( 'Discuss your project', 'agency-site' ) );
$cta_link     = $args['button_link'] ?? get_theme_mod( 'agency_hero_cta_link', home_url( '/contact/' ) );
?>
<section class="bg-gradient-to-br from-agency-900 via-dark-900 to-agency-950 text-white py-16 lg:py-20 relative overflow-hidden">
	<div class="absolute -top-24 -left-24 w-96 h-96 bg-agency-500/10 rounded-full blur-3xl pointer-events-none"></div>
	<div class="absolute -bottom-24 -right-24 w-96 h-96 bg-accent-500/10 rounded-full blur-3xl pointer-events-none"></div>

	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
		<div class="bg-dark-800/80 backdrop-blur-xl border border-slate-700/60 rounded-3xl p-8 sm:p-12 lg:p-16 text-center max-w-4xl mx-auto shadow-2xl">
			<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-agency-500/20 text-agency-300 border border-agency-500/30 uppercase tracking-widest mb-6">
				<?php esc_html_e( 'Start a Conversation', 'agency-site' ); ?>
			</span>
			<h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight mb-6 font-heading">
				<?php echo esc_html( $cta_headline ); ?>
			</h2>
			<p class="text-slate-300 text-lg sm:text-xl max-w-2xl mx-auto mb-8 font-normal leading-relaxed">
				<?php echo esc_html( $cta_subhead ); ?>
			</p>
			<div class="flex flex-col sm:flex-row items-center justify-center gap-4">
				<a href="<?php echo esc_url( $cta_link ); ?>" class="btn-primary !bg-agency-500 hover:!bg-agency-400 !text-white !py-3.5 !px-8 text-base w-full sm:w-auto">
					<span><?php echo esc_html( $cta_button ); ?></span>
					<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
				</a>
				<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="btn-secondary !bg-dark-700/80 !text-white !border-slate-600 hover:!bg-dark-600 !py-3.5 !px-8 text-base w-full sm:w-auto">
					<?php esc_html_e( 'Explore our services', 'agency-site' ); ?>
				</a>
			</div>
		</div>
	</div>
</section>

