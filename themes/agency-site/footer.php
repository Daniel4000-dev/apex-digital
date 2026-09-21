<?php
/**
 * Theme Footer
 *
 * @package Agency_Site
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
</main><!-- #main-content -->

<!-- Pre-Footer Conversion Banner -->
<?php get_template_part( 'template-parts/cta-banner' ); ?>

<!-- Main Footer -->
<footer id="colophon" class="bg-dark-900 text-slate-400 border-t border-slate-800">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-12">
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 lg:gap-8">
			
			<!-- Column 1: Brand & Bio (2 cols wide on desktop) -->
			<div class="lg:col-span-2 space-y-4">
				<div class="flex items-center gap-2.5">
					<span class="w-9 h-9 rounded-xl bg-gradient-to-tr from-agency-600 to-accent-600 flex items-center justify-center text-white font-bold text-lg shadow-md shrink-0">
						A
					</span>
					<span class="font-heading font-extrabold text-xl text-white tracking-tight">
						<?php bloginfo( 'name' ); ?>
					</span>
				</div>
				<p class="text-slate-400 text-sm leading-relaxed max-w-sm">
					<?php esc_html_e( 'We help growing businesses improve their websites, get found in search and turn advertising clicks into enquiries.', 'agency-site' ); ?>
				</p>
				<?php
				$socials = array(
					'twitter'   => array( 'name' => 'Twitter/X' ),
					'linkedin'  => array( 'name' => 'LinkedIn' ),
					'instagram' => array( 'name' => 'Instagram' ),
					'github'    => array( 'name' => 'GitHub' ),
				);

				$active_socials = array();
				foreach ( $socials as $slug => $data ) {
					$url = get_theme_mod( "agency_social_{$slug}", '' );
					if ( ! empty( $url ) && $url !== "https://{$slug}.com" && $url !== '#' ) {
						$active_socials[ $slug ] = array_merge( $data, array( 'url' => $url ) );
					}
				}
				if ( ! empty( $active_socials ) ) :
					?>
				<div class="flex items-center gap-3 pt-2">
					<?php foreach ( $active_socials as $slug => $item ) : ?>
						<a href="<?php echo esc_url( $item['url'] ); ?>" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-lg bg-dark-800 border border-slate-700/60 flex items-center justify-center text-slate-400 hover:text-white hover:bg-agency-600 hover:border-agency-500 transition-all duration-200" aria-label="<?php echo esc_attr( $item['name'] ); ?>">
							<span class="text-xs font-bold"><?php echo esc_html( substr( $item['name'], 0, 2 ) ); ?></span>
						</a>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
			</div>

			<!-- Column 2: Core Solutions -->
			<div>
				<h4 class="text-white font-semibold text-sm tracking-wide uppercase mb-4"><?php esc_html_e( 'Capabilities', 'agency-site' ); ?></h4>
				<ul class="space-y-2.5 text-sm">
					<li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="hover:text-agency-400 transition-colors"><?php esc_html_e( 'Search Engine Optimization', 'agency-site' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="hover:text-agency-400 transition-colors"><?php esc_html_e( 'Paid Media & Advertising', 'agency-site' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="hover:text-agency-400 transition-colors"><?php esc_html_e( 'Conversion Rate Optimization', 'agency-site' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="hover:text-agency-400 transition-colors"><?php esc_html_e( 'Web Development & Performance', 'agency-site' ); ?></a></li>
				</ul>
			</div>

			<!-- Column 3: Navigation -->
			<div>
				<h4 class="text-white font-semibold text-sm tracking-wide uppercase mb-4"><?php esc_html_e( 'Navigation', 'agency-site' ); ?></h4>
				<ul class="space-y-2.5 text-sm">
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-agency-400 transition-colors"><?php esc_html_e( 'Home', 'agency-site' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="hover:text-agency-400 transition-colors"><?php esc_html_e( 'Services', 'agency-site' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="hover:text-agency-400 transition-colors"><?php esc_html_e( 'Blog & Insights', 'agency-site' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="hover:text-agency-400 transition-colors"><?php esc_html_e( 'Contact', 'agency-site' ); ?></a></li>
				</ul>
			</div>

			<!-- Column 4: Contact & Consultations -->
			<div class="space-y-4">
				<h4 class="text-white font-semibold text-sm tracking-wide uppercase mb-4"><?php esc_html_e( 'Enquiries', 'agency-site' ); ?></h4>
				<p class="text-sm text-slate-400 leading-relaxed">
					<?php esc_html_e( 'Plan your next project with our growth and web specialists.', 'agency-site' ); ?>
				</p>
				<div>
					<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="inline-flex items-center gap-1.5 text-sm font-semibold text-agency-400 hover:text-white transition-colors">
						<span><?php esc_html_e( 'Discuss your project', 'agency-site' ); ?></span>
						<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
					</a>
				</div>
				<p class="text-xs text-slate-500">
					<?php esc_html_e( 'Enquiry Delivery:', 'agency-site' ); ?> <a href="mailto:<?php echo esc_attr( get_theme_mod( 'agency_email', 'growth@apexagency.digital' ) ); ?>" class="text-slate-400 hover:text-white transition-colors"><?php echo esc_html( get_theme_mod( 'agency_email', 'growth@apexagency.digital' ) ); ?></a>
				</p>
			</div>

		</div>

		<!-- Bottom Bar -->
		<div class="mt-16 pt-8 border-t border-slate-800 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-slate-500">
			<div>
				<p>© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'agency-site' ); ?></p>
				<p class="text-[11px] text-slate-400 mt-1">
					<?php esc_html_e( 'Apex Digital is a demonstration portfolio project for a fictional digital marketing agency. Client cases and metrics use illustrative sample data.', 'agency-site' ); ?>
				</p>
			</div>
			<div class="flex items-center gap-6 shrink-0">
				<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="hover:text-slate-400 transition-colors"><?php esc_html_e( 'Services', 'agency-site' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="hover:text-slate-400 transition-colors"><?php esc_html_e( 'Contact', 'agency-site' ); ?></a>
				<button id="back-to-top" type="button" class="inline-flex items-center gap-1 hover:text-white transition-colors cursor-pointer" aria-label="<?php esc_attr_e( 'Back to top of page', 'agency-site' ); ?>">
					<span><?php esc_html_e( 'Top', 'agency-site' ); ?></span>
					<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
				</button>
			</div>
		</div>

	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

