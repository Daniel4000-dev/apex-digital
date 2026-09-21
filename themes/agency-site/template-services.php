<?php
/**
 * Template Name: Service Landing Page
 *
 * @package Agency_Site
 */

get_header();
?>

<!-- Hero Section -->
<section class="py-16 md:py-24 bg-gradient-to-b from-white via-agency-50/40 to-slate-50 border-b border-slate-200/60">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-3xl">
		<span class="badge-tag mb-4"><?php esc_html_e( 'Our Capabilities', 'agency-site' ); ?></span>
		<h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-slate-900 tracking-tight font-heading mb-6">
			<?php esc_html_e( 'Services Designed to Turn Visits Into Enquiries', 'agency-site' ); ?>
		</h1>
		<p class="text-lg sm:text-xl text-slate-600 mb-8 leading-relaxed">
			<?php esc_html_e( 'We help growing businesses improve their websites, get found in search and turn advertising clicks into enquiries.', 'agency-site' ); ?>
		</p>
		<div class="flex flex-wrap items-center justify-center gap-3 text-xs sm:text-sm font-semibold text-slate-700">
			<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-white border border-slate-200 shadow-xs">
				<svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
				<?php esc_html_e( 'Defined Scope & Milestones', 'agency-site' ); ?>
			</span>
			<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-white border border-slate-200 shadow-xs">
				<svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
				<?php esc_html_e( 'Transparent Execution', 'agency-site' ); ?>
			</span>
			<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-white border border-slate-200 shadow-xs">
				<svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
				<?php esc_html_e( 'Enquiry Attribution', 'agency-site' ); ?>
			</span>
		</div>
	</div>
</section>

<!-- Detailed Services Listing Section -->
<section class="py-20 lg:py-28 bg-slate-50">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		
		<div class="space-y-16">
			<?php
			$services        = agency_site_get_default_services();
			$custom_services = new WP_Query(
				array(
					'post_type'      => 'agency_service',
					'posts_per_page' => -1,
					'orderby'        => 'menu_order date',
					'order'          => 'ASC',
				)
			);

			$index = 0;
			if ( $custom_services->have_posts() ) :
				while ( $custom_services->have_posts() ) :
					$custom_services->the_post();
					++$index;
					$tagline      = get_post_meta( get_the_ID(), '_agency_service_tagline', true );
					$price        = get_post_meta( get_the_ID(), '_agency_service_price', true );
					$deliverables = get_post_meta( get_the_ID(), '_agency_service_deliverables', true );
					$icon_type    = get_post_meta( get_the_ID(), '_agency_service_icon', true ) ?: 'chart';
					$badge        = get_post_meta( get_the_ID(), '_agency_service_badge', true );
					$items        = ! empty( $deliverables ) ? array_filter( array_map( 'trim', explode( "\n", $deliverables ) ) ) : array();
					$is_even      = ( $index % 2 === 0 );
					?>
				<div class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200/80 shadow-soft">
					<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
						<div class="lg:col-span-7 space-y-6">
							<div class="flex items-center gap-3">
								<div class="w-12 h-12 rounded-xl bg-agency-50 text-agency-600 flex items-center justify-center">
                                    <?php echo agency_site_get_icon($icon_type, 'w-6 h-6'); // phpcs:ignore ?>
								</div>
								<?php if ( $badge ) : ?>
									<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-agency-50 text-agency-700 border border-agency-200">
										<?php echo esc_html( $badge ); ?>
									</span>
								<?php endif; ?>
							</div>

							<h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">
								<?php the_title(); ?>
							</h2>

							<?php if ( $tagline ) : ?>
								<p class="text-sm font-semibold text-agency-600"><?php echo esc_html( $tagline ); ?></p>
							<?php endif; ?>

							<div class="text-slate-600 text-base leading-relaxed">
								<?php the_content(); ?>
							</div>

							<div class="pt-4 flex flex-wrap items-center gap-4">
								<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>?service=<?php echo rawurlencode( get_the_title() ); ?>" class="btn-primary">
									<span>Get Scope & Proposal</span>
									<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
								</a>
								<?php if ( $price ) : ?>
									<span class="text-sm font-bold text-slate-600 bg-slate-100 px-4 py-2.5 rounded-full border border-slate-200"><?php echo esc_html( $price ); ?></span>
								<?php endif; ?>
							</div>
						</div>

						<div class="lg:col-span-5 bg-slate-50 rounded-2xl p-6 sm:p-8 border border-slate-200">
							<h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">Core Deliverables & Outputs</h3>
							<ul class="space-y-3">
								<?php foreach ( $items as $item ) : ?>
									<li class="flex items-start gap-3 text-sm text-slate-700">
										<svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
										<span><?php echo esc_html( $item ); ?></span>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				</div>
					<?php
				endwhile;
				wp_reset_postdata();
			else :
				foreach ( $services as $srv ) :
					++$index;
					?>
				<div class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200/80 shadow-soft">
					<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
						<div class="lg:col-span-7 space-y-6">
							<div class="flex items-center gap-3">
								<div class="w-12 h-12 rounded-xl bg-agency-50 text-agency-600 flex items-center justify-center">
                                    <?php echo agency_site_get_icon($srv['icon'], 'w-6 h-6'); // phpcs:ignore ?>
								</div>
								<?php if ( ! empty( $srv['badge'] ) ) : ?>
									<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-agency-50 text-agency-700 border border-agency-200">
										<?php echo esc_html( $srv['badge'] ); ?>
									</span>
								<?php endif; ?>
							</div>

							<h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">
								<?php echo esc_html( $srv['title'] ); ?>
							</h2>

							<p class="text-sm font-semibold text-agency-600"><?php echo esc_html( $srv['tagline'] ); ?></p>

							<p class="text-slate-600 text-base leading-relaxed">
								<?php echo esc_html( $srv['desc'] ); ?>
							</p>

							<div class="pt-4 flex flex-wrap items-center gap-4">
								<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>?service=<?php echo rawurlencode( $srv['title'] ); ?>" class="btn-primary">
									<span>Get Scope & Proposal</span>
									<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
								</a>
								<span class="text-sm font-bold text-slate-600 bg-slate-100 px-4 py-2.5 rounded-full border border-slate-200"><?php echo esc_html( $srv['price'] ); ?></span>
							</div>
						</div>

						<div class="lg:col-span-5 bg-slate-50 rounded-2xl p-6 sm:p-8 border border-slate-200">
							<h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">Core Deliverables & Outputs</h3>
							<ul class="space-y-3">
								<?php foreach ( $srv['deliverables'] as $item ) : ?>
									<li class="flex items-start gap-3 text-sm text-slate-700">
										<svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
										<span><?php echo esc_html( $item ); ?></span>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				</div>
					<?php
				endforeach;
			endif;
			?>
		</div>

	</div>
</section>

<!-- 4-Step Process Section -->
<section class="py-20 lg:py-28 bg-white border-y border-slate-100">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="max-w-3xl mx-auto text-center mb-16">
			<span class="badge-tag mb-3">How We Partner</span>
			<h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-heading mb-4">
				Our 4-Stage Growth Architecture Framework
			</h2>
			<p class="text-slate-600 text-base sm:text-lg">
				Predictability comes from process. Here is exactly what our first 90 days look like together.
			</p>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
			<div class="bg-slate-50 p-6 rounded-2xl border border-slate-200">
				<div class="w-10 h-10 rounded-xl bg-agency-600 text-white font-extrabold flex items-center justify-center mb-4">
					01
				</div>
				<h3 class="text-lg font-bold text-slate-900 mb-2 font-heading">Full Funnel Audit</h3>
				<p class="text-sm text-slate-600">We inspect your tracking, search visibility, paid ad CAC, and landing page drop-offs to uncover immediate revenue leaks.</p>
			</div>

			<div class="bg-slate-50 p-6 rounded-2xl border border-slate-200">
				<div class="w-10 h-10 rounded-xl bg-agency-600 text-white font-extrabold flex items-center justify-center mb-4">
					02
				</div>
				<h3 class="text-lg font-bold text-slate-900 mb-2 font-heading">Strategy & Modeling</h3>
				<p class="text-sm text-slate-600">We map out 90-day targets, build multi-variant test roadmaps, and configure custom attribution analytics.</p>
			</div>

			<div class="bg-slate-50 p-6 rounded-2xl border border-slate-200">
				<div class="w-10 h-10 rounded-xl bg-agency-600 text-white font-extrabold flex items-center justify-center mb-4">
					03
				</div>
				<h3 class="text-lg font-bold text-slate-900 mb-2 font-heading">Agile Sprints</h3>
				<p class="text-sm text-slate-600">Weekly creative deployment, bidding updates, technical SEO improvements, and landing page experiments launched rapidly.</p>
			</div>

			<div class="bg-slate-50 p-6 rounded-2xl border border-slate-200">
				<div class="w-10 h-10 rounded-xl bg-agency-600 text-white font-extrabold flex items-center justify-center mb-4">
					04
				</div>
				<h3 class="text-lg font-bold text-slate-900 mb-2 font-heading">Scale & Compounding</h3>
				<p class="text-sm text-slate-600">We double down on winning channels, expand to complementary traffic sources, and optimize lifetime customer value.</p>
			</div>
		</div>
	</div>
</section>

<!-- Frequently Asked Questions Accordion -->
<section class="py-20 lg:py-28 bg-slate-50">
	<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="text-center mb-16">
			<span class="badge-tag mb-3">Got Questions?</span>
			<h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-heading mb-4">
				Frequently Asked Service Questions
			</h2>
			<p class="text-slate-600 text-base">
				Everything you need to know about working with our growth team.
			</p>
		</div>

		<div class="space-y-4" id="faq-accordion">
			<?php
			$faqs = array(
				array(
					'q' => 'How quickly can we expect to see measurable results?',
					'a' => 'Paid media improvements and conversion rate optimizations typically produce visible signal within the first 14 to 21 days. Organic search and technical authority projects show compounding traffic gains around weeks 6 through 12.',
				),
				array(
					'q' => 'Do you require long-term annual agency contracts?',
					'a' => 'No. We work on a 90-day initial acceleration period, followed by flexible monthly agreements. We believe in earning our client partnerships every single sprint based on performance.',
				),
				array(
					'q' => 'Who will be working on our account on a day-to-day basis?',
					'a' => 'You work directly with a Senior Growth Architect, supported by dedicated channel specialists (copywriter, designer, media buyer). You will never be handed off to an inexperienced account coordinator.',
				),
				array(
					'q' => 'What tech stack and tools do you use for reporting?',
					'a' => 'We integrate with Google Analytics 4, Looker Studio, Triple Whale / Northbeam (for DTC), HubSpot, Salesforce, and custom server-side attribution setups so you have 100% data transparency.',
				),
			);
			foreach ( $faqs as $i => $faq ) :
				?>
				<div class="faq-item bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
					<button type="button" class="faq-toggle w-full px-6 py-5 text-left flex items-center justify-between text-base font-bold text-slate-900 hover:text-agency-600 focus:outline-none" aria-expanded="false">
						<span><?php echo esc_html( $faq['q'] ); ?></span>
						<svg class="faq-icon w-5 h-5 text-slate-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
					</button>
					<div class="faq-content hidden px-6 pb-5 text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
						<?php echo esc_html( $faq['a'] ); ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
get_footer();

