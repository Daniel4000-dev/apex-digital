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

<!-- Main Footer: Editorial Studio Layout -->
<footer id="colophon" class="bg-ink text-ivory/70 border-t border-ink">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-12">
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-8 pb-12 border-b border-ivory/10">
			
			<!-- Column 1: Brand & Positioning (5 cols) -->
			<div class="lg:col-span-5 space-y-4">
				<div class="flex items-center gap-3">
					<span class="w-8 h-8 bg-cobalt text-white flex items-center justify-center font-bold text-sm tracking-wider shrink-0">
						A
					</span>
					<span class="font-heading font-extrabold text-xl text-ivory tracking-tight">
						<?php bloginfo( 'name' ); ?>
					</span>
					<span class="text-[10px] uppercase font-mono tracking-widest text-ivory/40">
						<?php esc_html_e( 'Studio', 'agency-site' ); ?>
					</span>
				</div>
				<p class="text-ivory/70 text-sm leading-relaxed max-w-sm">
					<?php esc_html_e( 'We help growing businesses improve their websites, get found in search and turn advertising clicks into enquiries.', 'agency-site' ); ?>
				</p>
				<p class="text-xs font-mono text-ivory/50 pt-2">
					<?php esc_html_e( 'Custom Engineering · Technical SEO · Creative Production', 'agency-site' ); ?>
				</p>
			</div>

			<!-- Column 2: Capabilities (3 cols) -->
			<div class="lg:col-span-3">
				<h4 class="text-ivory font-mono text-xs tracking-widest uppercase mb-4"><?php esc_html_e( 'Capabilities', 'agency-site' ); ?></h4>
				<ul class="space-y-2.5 text-sm">
					<li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="hover:text-ivory transition-colors"><?php esc_html_e( 'Website Design & Engineering', 'agency-site' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="hover:text-ivory transition-colors"><?php esc_html_e( 'Search Strategy & Technical SEO', 'agency-site' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="hover:text-ivory transition-colors"><?php esc_html_e( 'Performance Media & Ads', 'agency-site' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="hover:text-ivory transition-colors"><?php esc_html_e( 'Conversion Rate Optimization', 'agency-site' ); ?></a></li>
				</ul>
			</div>

			<!-- Column 3: Navigation (2 cols) -->
			<div class="lg:col-span-2">
				<h4 class="text-ivory font-mono text-xs tracking-widest uppercase mb-4"><?php esc_html_e( 'Index', 'agency-site' ); ?></h4>
				<ul class="space-y-2.5 text-sm">
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-ivory transition-colors"><?php esc_html_e( 'Home', 'agency-site' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="hover:text-ivory transition-colors"><?php esc_html_e( 'Services', 'agency-site' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="hover:text-ivory transition-colors"><?php esc_html_e( 'Blog & Insights', 'agency-site' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="hover:text-ivory transition-colors"><?php esc_html_e( 'Contact', 'agency-site' ); ?></a></li>
				</ul>
			</div>

			<!-- Column 4: Studio Enquiries (2 cols) -->
			<div class="lg:col-span-2 space-y-3">
				<h4 class="text-ivory font-mono text-xs tracking-widest uppercase mb-4"><?php esc_html_e( 'Enquiries', 'agency-site' ); ?></h4>
				<p class="text-xs text-ivory/70 leading-relaxed">
					<?php esc_html_e( 'Plan your next project with our engineering and growth team.', 'agency-site' ); ?>
				</p>
				<div>
					<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="inline-flex items-center gap-1.5 text-xs font-semibold text-lime hover:underline transition-all">
						<span><?php esc_html_e( 'Discuss your project', 'agency-site' ); ?></span>
						<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
					</a>
				</div>
				<p class="text-[11px] text-ivory/50">
					<a href="mailto:<?php echo esc_attr( get_theme_mod( 'agency_email', 'growth@apexagency.digital' ) ); ?>" class="hover:text-ivory transition-colors underline"><?php echo esc_html( get_theme_mod( 'agency_email', 'growth@apexagency.digital' ) ); ?></a>
				</p>
			</div>
		</div>

		<!-- Bottom Bar -->
		<div class="mt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-ivory/50">
			<div>
				<p>© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'agency-site' ); ?></p>
				<p class="text-[11px] text-ivory/40 mt-1">
					<?php esc_html_e( 'Apex Digital is a demonstration portfolio project for a fictional digital marketing agency. Client cases and metrics use illustrative sample data.', 'agency-site' ); ?>
				</p>
			</div>
			<div class="flex items-center gap-6 shrink-0">
				<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="hover:text-ivory transition-colors"><?php esc_html_e( 'Services', 'agency-site' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="hover:text-ivory transition-colors"><?php esc_html_e( 'Contact', 'agency-site' ); ?></a>
				<button id="back-to-top" type="button" class="inline-flex items-center gap-1 hover:text-ivory transition-colors cursor-pointer" aria-label="<?php esc_attr_e( 'Back to top of page', 'agency-site' ); ?>">
					<span><?php esc_html_e( 'Top', 'agency-site' ); ?></span>
					<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
				</button>
			</div>
		</div>

	</div>
</footer>

	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

