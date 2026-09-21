<?php
/**
 * The template for displaying the Homepage
 *
 * @package Agency_Site
 */

get_header();

// Customizer values with fallbacks
$hero_badge    = get_theme_mod( 'agency_hero_badge', __( 'Digital Marketing & Web Design', 'agency-site' ) );
$hero_headline = get_theme_mod( 'agency_hero_headline', __( 'Turn more visits into enquiries.', 'agency-site' ) );
$hero_subhead  = get_theme_mod( 'agency_hero_subhead', __( 'We help growing businesses improve their websites, get found in search and turn advertising clicks into enquiries.', 'agency-site' ) );
$hero_cta_text = get_theme_mod( 'agency_hero_cta_text', __( 'Discuss your project', 'agency-site' ) );
$hero_cta_link = get_theme_mod( 'agency_hero_cta_link', home_url( '/contact/' ) );
$hero_sec_text = get_theme_mod( 'agency_hero_sec_cta_text', __( 'Explore our services', 'agency-site' ) );
$hero_sec_link = get_theme_mod( 'agency_hero_sec_cta_link', home_url( '/services/' ) );
?>

<!-- 1. Hero Section -->
<section class="relative pt-12 pb-16 md:pt-20 md:pb-24 overflow-hidden bg-gradient-to-b from-white via-agency-50/30 to-slate-50">
	<!-- Subtle Ambient Glow -->
	<div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[550px] h-[300px] bg-gradient-to-tr from-agency-200/40 to-accent-200/30 rounded-full blur-3xl pointer-events-none -z-10"></div>

	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="text-center max-w-3xl mx-auto">
			
			<!-- Badge -->
			<div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-agency-50 border border-agency-200/80 text-agency-700 text-xs sm:text-sm font-semibold shadow-xs mb-6">
				<span class="w-2 h-2 rounded-full bg-agency-500"></span>
				<span><?php echo esc_html( $hero_badge ); ?></span>
			</div>

			<!-- Headline -->
			<h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-slate-900 tracking-tight leading-[1.14] mb-6 font-heading">
				<?php echo esc_html( $hero_headline ); ?>
			</h1>

			<!-- Subhead -->
			<p class="text-lg sm:text-xl text-slate-600 mb-10 leading-relaxed font-normal max-w-2xl mx-auto">
				<?php echo esc_html( $hero_subhead ); ?>
			</p>

			<!-- Actions -->
			<div class="flex flex-col sm:flex-row items-center justify-center gap-4">
				<a href="<?php echo esc_url( $hero_cta_link ); ?>" class="btn-primary !py-3.5 !px-8 text-base w-full sm:w-auto shadow-md">
					<span><?php echo esc_html( $hero_cta_text ); ?></span>
					<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
				</a>
				<a href="<?php echo esc_url( $hero_sec_link ); ?>" class="btn-secondary !py-3.5 !px-8 text-base w-full sm:w-auto">
					<span><?php echo esc_html( $hero_sec_text ); ?></span>
				</a>
			</div>

		</div>

		<!-- Sample Campaign Report Graphic (Clearly labelled illustrative data) -->
		<div class="mt-14 max-w-4xl mx-auto relative">
			<div class="rounded-2xl border border-slate-200/90 bg-white/90 p-2 shadow-xl backdrop-blur-sm">
				<div class="rounded-xl bg-slate-900 overflow-hidden text-white p-6 sm:p-8">
					<div class="flex flex-wrap items-center justify-between gap-4 pb-6 border-b border-slate-800">
						<div>
							<div class="text-xs uppercase tracking-wider text-agency-400 font-bold"><?php esc_html_e( 'Sample Campaign Report', 'agency-site' ); ?></div>
							<div class="text-lg sm:text-xl font-bold font-heading text-white mt-0.5"><?php esc_html_e( 'Quarterly Website & Enquiry Overview', 'agency-site' ); ?></div>
						</div>
						<div>
							<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-800 text-slate-300 border border-slate-700">
								<?php esc_html_e( 'Illustrative Data', 'agency-site' ); ?>
							</span>
						</div>
					</div>

					<div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 pt-6">
						<div class="bg-dark-800/90 p-4 rounded-xl border border-slate-800">
							<span class="text-xs text-slate-400 block"><?php esc_html_e( 'Search Impressions', 'agency-site' ); ?></span>
							<span class="text-2xl sm:text-3xl font-extrabold text-white block mt-1">128,400</span>
							<span class="text-xs text-slate-400 font-medium block mt-1"><?php esc_html_e( 'Organic search footprint', 'agency-site' ); ?></span>
						</div>
						<div class="bg-dark-800/90 p-4 rounded-xl border border-slate-800">
							<span class="text-xs text-slate-400 block"><?php esc_html_e( 'Website Visits', 'agency-site' ); ?></span>
							<span class="text-2xl sm:text-3xl font-extrabold text-white block mt-1">14,250</span>
							<span class="text-xs text-slate-400 font-medium block mt-1"><?php esc_html_e( 'Targeted visitor sessions', 'agency-site' ); ?></span>
						</div>
						<div class="bg-dark-800/90 p-4 rounded-xl border border-slate-800">
							<span class="text-xs text-slate-400 block"><?php esc_html_e( 'Enquiries Received', 'agency-site' ); ?></span>
							<span class="text-2xl sm:text-3xl font-extrabold text-agency-400 block mt-1">386</span>
							<span class="text-xs text-slate-400 font-medium block mt-1"><?php esc_html_e( 'Direct project submissions', 'agency-site' ); ?></span>
						</div>
						<div class="bg-dark-800/90 p-4 rounded-xl border border-slate-800">
							<span class="text-xs text-slate-400 block"><?php esc_html_e( 'Conversion Rate', 'agency-site' ); ?></span>
							<span class="text-2xl sm:text-3xl font-extrabold text-emerald-400 block mt-1">2.7%</span>
							<span class="text-xs text-slate-400 font-medium block mt-1"><?php esc_html_e( 'Visit-to-enquiry rate', 'agency-site' ); ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</section>

<!-- 2. Core Services Grid -->
<section id="services" class="py-16 lg:py-24 bg-slate-50">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		
		<div class="max-w-3xl mx-auto text-center mb-16">
			<span class="badge-tag mb-3"><?php esc_html_e( 'Our Capabilities', 'agency-site' ); ?></span>
			<h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight font-heading mb-4">
				<?php esc_html_e( 'Services Designed to Generate Enquiries', 'agency-site' ); ?>
			</h2>
			<p class="text-base sm:text-lg text-slate-600">
				<?php esc_html_e( 'From technical search visibility to paid media and landing page design, we focus on measurable improvements that help your business grow.', 'agency-site' ); ?>
			</p>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
			<?php
			$services_query = new WP_Query(
				array(
					'post_type'      => 'agency_service',
					'posts_per_page' => 6,
					'orderby'        => 'menu_order date',
					'order'          => 'ASC',
				)
			);

			if ( $services_query->have_posts() ) :
				while ( $services_query->have_posts() ) :
					$services_query->the_post();
					get_template_part( 'template-parts/service-card' );
				endwhile;
				wp_reset_postdata();
			else :
				// Render rich default services via template part
				$default_services = agency_site_get_default_services();
				foreach ( $default_services as $srv ) :
					get_template_part( 'template-parts/service-card', null, $srv );
				endforeach;
			endif;
			?>
		</div>

		<div class="mt-14 text-center">
			<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="btn-primary !py-3.5 !px-8">
				<span><?php esc_html_e( 'View All Services & Pricing', 'agency-site' ); ?></span>
				<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
			</a>
		</div>

	</div>
</section>

<!-- 3. Project Process: How We Plan, Deliver and Support -->
<section class="py-16 lg:py-24 bg-white border-y border-slate-100">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="max-w-3xl mx-auto text-center mb-16">
			<span class="badge-tag mb-3"><?php esc_html_e( 'Project Process', 'agency-site' ); ?></span>
			<h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight font-heading mb-4">
				<?php esc_html_e( 'How Projects Are Planned, Delivered and Supported', 'agency-site' ); ?>
			</h2>
			<p class="text-base sm:text-lg text-slate-600 leading-relaxed">
				<?php esc_html_e( 'We replace guesswork with structured discovery, focused implementation sprints, and straightforward reporting.', 'agency-site' ); ?>
			</p>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
			<!-- Stage 1 -->
			<div class="bg-slate-50 p-8 rounded-3xl border border-slate-200/80 shadow-soft flex flex-col justify-between">
				<div>
					<div class="w-12 h-12 rounded-2xl bg-agency-50 text-agency-600 font-extrabold text-lg flex items-center justify-center mb-6 shadow-xs">
						01
					</div>
					<h3 class="text-xl font-bold text-slate-900 font-heading mb-3">
						<?php esc_html_e( 'Audit & Discovery', 'agency-site' ); ?>
					</h3>
					<p class="text-sm text-slate-600 leading-relaxed mb-6">
						<?php esc_html_e( 'We evaluate your current website performance, keyword rankings, and visitor drop-off points to define clear objectives and prioritize high-impact deliverables.', 'agency-site' ); ?>
					</p>
				</div>
				<div class="pt-4 border-t border-slate-200/60 text-xs text-slate-500 font-medium">
					<span><?php esc_html_e( 'Deliverable: Technical audit & roadmap', 'agency-site' ); ?></span>
				</div>
			</div>

			<!-- Stage 2 -->
			<div class="bg-slate-50 p-8 rounded-3xl border border-slate-200/80 shadow-soft flex flex-col justify-between">
				<div>
					<div class="w-12 h-12 rounded-2xl bg-agency-50 text-agency-600 font-extrabold text-lg flex items-center justify-center mb-6 shadow-xs">
						02
					</div>
					<h3 class="text-xl font-bold text-slate-900 font-heading mb-3">
						<?php esc_html_e( 'Focused Execution Sprints', 'agency-site' ); ?>
					</h3>
					<p class="text-sm text-slate-600 leading-relaxed mb-6">
						<?php esc_html_e( 'We implement technical SEO fixes, build high-converting landing pages, and configure reliable conversion tracking so your campaigns launch cleanly.', 'agency-site' ); ?>
					</p>
				</div>
				<div class="pt-4 border-t border-slate-200/60 text-xs text-slate-500 font-medium">
					<span><?php esc_html_e( 'Deliverable: Production deployments & tested tracking', 'agency-site' ); ?></span>
				</div>
			</div>

			<!-- Stage 3 -->
			<div class="bg-slate-50 p-8 rounded-3xl border border-slate-200/80 shadow-soft flex flex-col justify-between">
				<div>
					<div class="w-12 h-12 rounded-2xl bg-agency-50 text-agency-600 font-extrabold text-lg flex items-center justify-center mb-6 shadow-xs">
						03
					</div>
					<h3 class="text-xl font-bold text-slate-900 font-heading mb-3">
						<?php esc_html_e( 'Review & Ongoing Support', 'agency-site' ); ?>
					</h3>
					<p class="text-sm text-slate-600 leading-relaxed mb-6">
						<?php esc_html_e( 'We provide monthly performance summaries explaining enquiry trends, keyword movements, and recommendations for continued site refinement.', 'agency-site' ); ?>
					</p>
				</div>
				<div class="pt-4 border-t border-slate-200/60 text-xs text-slate-500 font-medium">
					<span><?php esc_html_e( 'Deliverable: Monthly report & proactive maintenance', 'agency-site' ); ?></span>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- 4. Latest Articles / Blog Insights -->
<section class="py-16 lg:py-24 bg-slate-50">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		
		<div class="flex flex-col md:flex-row md:items-end justify-between mb-14 gap-4">
			<div>
				<span class="badge-tag mb-3"><?php esc_html_e( 'Educational Guides', 'agency-site' ); ?></span>
				<h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-heading">
					<?php esc_html_e( 'Latest Insights & Practical Strategies', 'agency-site' ); ?>
				</h2>
			</div>
			<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ) ); ?>" class="inline-flex items-center gap-1.5 text-sm font-bold text-agency-600 hover:text-agency-700 transition-colors">
				<span><?php esc_html_e( 'View All Articles', 'agency-site' ); ?></span>
				<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
			</a>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
			<?php
			$recent_posts = new WP_Query(
				array(
					'posts_per_page'      => 3,
					'post_status'         => 'publish',
					'ignore_sticky_posts' => 1,
				)
			);

			if ( $recent_posts->have_posts() ) :
				while ( $recent_posts->have_posts() ) :
					$recent_posts->the_post();
					get_template_part( 'template-parts/post-card' );
				endwhile;
				wp_reset_postdata();
			endif;
			?>
		</div>

	</div>
</section>

<?php
get_footer();
