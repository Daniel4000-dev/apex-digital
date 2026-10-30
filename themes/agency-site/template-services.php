<?php
/**
 * Template Name: Service Landing Page
 *
 * @package Agency_Site
 */

get_header();
?>

<!-- Hero Section -->
<section class="py-16 md:py-24 border-b border-ink/15 bg-ivory">
	<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
		<span class="font-mono text-xs uppercase tracking-widest text-ink/60 block mb-3">01 / STUDIO CAPABILITIES</span>
		<h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-ink tracking-tight font-heading mb-6 leading-tight">
			Services Designed to Turn Visits <span class="font-serif italic font-normal text-cobalt">Into Enquiries</span>
		</h1>
		<p class="text-lg sm:text-xl text-ink/80 mb-8 leading-relaxed max-w-2xl mx-auto font-normal">
			<?php esc_html_e( 'We help growing businesses improve their websites, get found in search and turn advertising clicks into enquiries.', 'agency-site' ); ?>
		</p>
		<div class="flex flex-wrap items-center justify-center gap-3 text-xs font-mono text-ink/70">
			<span class="editorial-tag">
				<span class="w-1.5 h-1.5 bg-cobalt"></span>
				<?php esc_html_e( 'Defined Scope & Milestones', 'agency-site' ); ?>
			</span>
			<span class="editorial-tag">
				<span class="w-1.5 h-1.5 bg-coral"></span>
				<?php esc_html_e( 'Transparent Execution', 'agency-site' ); ?>
			</span>
			<span class="editorial-tag">
				<span class="w-1.5 h-1.5 bg-ink"></span>
				<?php esc_html_e( 'Direct Enquiry Attribution', 'agency-site' ); ?>
			</span>
		</div>
	</div>
</section>

<!-- Detailed Services Listing Section -->
<section class="py-16 lg:py-24 border-b border-ink/15 bg-ivory">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		
		<div class="space-y-12">
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
					$num_str      = sprintf( '%02d', $index );
					$tagline      = get_post_meta( get_the_ID(), '_agency_service_tagline', true );
					$price        = get_post_meta( get_the_ID(), '_agency_service_price', true );
					$deliverables = get_post_meta( get_the_ID(), '_agency_service_deliverables', true );
					$icon_type    = get_post_meta( get_the_ID(), '_agency_service_icon', true ) ?: 'chart';
					$badge        = get_post_meta( get_the_ID(), '_agency_service_badge', true );
					$items        = ! empty( $deliverables ) ? array_filter( array_map( 'trim', explode( "\n", $deliverables ) ) ) : array();
					?>
				<div class="bg-ivory border border-ink/20 p-8 sm:p-12 transition-colors duration-200 hover:border-cobalt">
					<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
						
						<!-- Service Main Overview (7 cols) -->
						<div class="lg:col-span-7 space-y-5">
							<div class="flex items-center gap-3">
								<span class="font-mono text-sm font-bold text-cobalt"><?php echo esc_html( $num_str ); ?> /</span>
								<div class="w-10 h-10 border border-ink/20 bg-ivory text-ink flex items-center justify-center">
									<?php echo agency_site_get_icon( $icon_type, 'w-5 h-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</div>
								<?php if ( $badge ) : ?>
									<span class="editorial-tag !text-[11px]">
										<?php echo esc_html( $badge ); ?>
									</span>
								<?php endif; ?>
							</div>

							<h2 class="text-2xl sm:text-3xl font-extrabold text-ink font-heading">
								<a href="<?php the_permalink(); ?>" class="hover:text-cobalt transition-colors">
									<?php the_title(); ?>
								</a>
							</h2>

							<?php if ( $tagline ) : ?>
								<p class="text-xs sm:text-sm font-mono text-cobalt font-medium"><?php echo esc_html( $tagline ); ?></p>
							<?php endif; ?>

							<div class="text-ink/80 text-base leading-relaxed font-normal">
								<?php the_content(); ?>
							</div>

							<div class="pt-4 flex flex-wrap items-center gap-4">
								<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>?service=<?php echo rawurlencode( get_the_title() ); ?>" class="btn-primary !py-3 !px-6 text-xs uppercase tracking-wider font-semibold">
									<span><?php esc_html_e( 'Get Scope & Proposal', 'agency-site' ); ?></span>
									<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
								</a>
								<a href="<?php the_permalink(); ?>" class="btn-secondary !py-3 !px-6 text-xs uppercase tracking-wider font-semibold">
									<span><?php esc_html_e( 'View Details', 'agency-site' ); ?></span>
								</a>
								<?php if ( $price ) : ?>
									<span class="text-xs font-mono text-ink/70 px-3 py-2 border border-ink/15"><?php echo esc_html( $price ); ?></span>
								<?php endif; ?>
							</div>
						</div>

						<!-- Core Deliverables Column (5 cols) -->
						<div class="lg:col-span-5 space-y-6">
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="border border-ink/20 aspect-[16/9] overflow-hidden">
									<?php the_post_thumbnail( 'agency-card', array( 'class' => 'w-full h-full object-cover' ) ); ?>
								</div>
							<?php endif; ?>
							<div class="bg-ink/5 border border-ink/15 p-6 sm:p-8">
								<h3 class="text-xs font-mono uppercase tracking-widest text-ink/60 mb-4"><?php esc_html_e( 'Core Deliverables & Outputs', 'agency-site' ); ?></h3>
							<?php if ( ! empty( $items ) ) : ?>
								<ul class="space-y-3">
									<?php foreach ( $items as $item ) : ?>
										<li class="flex items-start gap-2.5 text-xs sm:text-sm text-ink/80 font-mono">
											<span class="text-cobalt font-bold mt-0.5">+</span>
											<span><?php echo esc_html( $item ); ?></span>
										</li>
									<?php endforeach; ?>
								</ul>
							<?php else : ?>
								<p class="text-xs text-ink/60 font-mono"><?php esc_html_e( 'Custom scoping and deliverables defined per project brief.', 'agency-site' ); ?></p>
							<?php endif; ?>
						</div>

					</div>
				</div>
					<?php
				endwhile;
				wp_reset_postdata();
			else :
				foreach ( $services as $srv ) :
					++$index;
					$num_str = sprintf( '%02d', $index );
					?>
				<div class="bg-ivory border border-ink/20 p-8 sm:p-12 transition-colors duration-200 hover:border-cobalt">
					<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
						<div class="lg:col-span-7 space-y-5">
							<div class="flex items-center gap-3">
								<span class="font-mono text-sm font-bold text-cobalt"><?php echo esc_html( $num_str ); ?> /</span>
								<div class="w-10 h-10 border border-ink/20 bg-ivory text-ink flex items-center justify-center">
									<?php echo agency_site_get_icon( $srv['icon'], 'w-5 h-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</div>
								<?php if ( ! empty( $srv['badge'] ) ) : ?>
									<span class="editorial-tag !text-[11px]"><?php echo esc_html( $srv['badge'] ); ?></span>
								<?php endif; ?>
							</div>

							<h2 class="text-2xl sm:text-3xl font-extrabold text-ink font-heading">
								<?php echo esc_html( $srv['title'] ); ?>
							</h2>

							<p class="text-xs sm:text-sm font-mono text-cobalt font-medium"><?php echo esc_html( $srv['tagline'] ); ?></p>
							<p class="text-ink/80 text-base leading-relaxed font-normal"><?php echo esc_html( $srv['desc'] ); ?></p>

							<div class="pt-4 flex flex-wrap items-center gap-4">
								<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>?service=<?php echo rawurlencode( $srv['title'] ); ?>" class="btn-primary !py-3 !px-6 text-xs uppercase tracking-wider font-semibold">
									<span><?php esc_html_e( 'Get Scope & Proposal', 'agency-site' ); ?></span>
									<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
								</a>
								<span class="text-xs font-mono text-ink/70 px-3 py-2 border border-ink/15"><?php echo esc_html( $srv['price'] ); ?></span>
							</div>
						</div>

						<div class="lg:col-span-5 bg-ink/5 border border-ink/15 p-6 sm:p-8">
							<h3 class="text-xs font-mono uppercase tracking-widest text-ink/60 mb-4"><?php esc_html_e( 'Core Deliverables & Outputs', 'agency-site' ); ?></h3>
							<ul class="space-y-3">
								<?php foreach ( $srv['deliverables'] as $item ) : ?>
									<li class="flex items-start gap-2.5 text-xs sm:text-sm text-ink/80 font-mono">
										<span class="text-cobalt font-bold mt-0.5">+</span>
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

<!-- 4-Stage Project Delivery Framework -->
<section class="py-16 lg:py-24 border-b border-ink/15 bg-ivory">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="max-w-3xl mb-14">
			<span class="font-mono text-xs uppercase tracking-widest text-ink/60 block mb-2">02 / ENGAGEMENT MODEL</span>
			<h2 class="text-3xl sm:text-4xl font-extrabold text-ink tracking-tight font-heading mb-4">
				<?php esc_html_e( 'Our 4-Stage Architecture Framework', 'agency-site' ); ?>
			</h2>
			<p class="text-ink/80 text-base sm:text-lg font-normal leading-relaxed">
				<?php esc_html_e( 'Predictability comes from process. Here is how we deliver measurable value from the initial sprint onwards.', 'agency-site' ); ?>
			</p>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
			<div class="border border-ink/20 p-6 bg-ivory flex flex-col justify-between">
				<div>
					<div class="font-mono text-sm font-bold text-cobalt mb-4">01 / AUDIT</div>
					<h3 class="text-lg font-bold text-ink mb-2 font-heading"><?php esc_html_e( 'Full Stack Audit', 'agency-site' ); ?></h3>
					<p class="text-xs sm:text-sm text-ink/80 leading-relaxed font-normal">We inspect technical SEO health, Core Web Vitals, server response times, and checkout/enquiry drop-offs.</p>
				</div>
			</div>

			<div class="border border-ink/20 p-6 bg-ivory flex flex-col justify-between">
				<div>
					<div class="font-mono text-sm font-bold text-coral mb-4">02 / STRATEGY</div>
					<h3 class="text-lg font-bold text-ink mb-2 font-heading"><?php esc_html_e( 'Architecture & Modeling', 'agency-site' ); ?></h3>
					<p class="text-xs sm:text-sm text-ink/80 leading-relaxed font-normal">We map out 90-day targets, design tested conversion wireframes, and build robust attribution pipelines.</p>
				</div>
			</div>

			<div class="border border-ink/20 p-6 bg-ivory flex flex-col justify-between">
				<div>
					<div class="font-mono text-sm font-bold text-ink mb-4">03 / SPRINTS</div>
					<h3 class="text-lg font-bold text-ink mb-2 font-heading"><?php esc_html_e( 'Focused Sprints', 'agency-site' ); ?></h3>
					<p class="text-xs sm:text-sm text-ink/80 leading-relaxed font-normal">Production theme deployments, high-speed landing templates, and clean campaign bidding adjustments.</p>
				</div>
			</div>

			<div class="border border-ink/20 p-6 bg-ivory flex flex-col justify-between">
				<div>
					<div class="font-mono text-sm font-bold text-cobalt mb-4">04 / EVOLUTION</div>
					<h3 class="text-lg font-bold text-ink mb-2 font-heading"><?php esc_html_e( 'Continuous Care', 'agency-site' ); ?></h3>
					<p class="text-xs sm:text-sm text-ink/80 leading-relaxed font-normal">Monthly performance reviews, security dependency patches, and ongoing conversion rate optimization.</p>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Frequently Asked Questions Accordion -->
<section class="py-16 lg:py-24 bg-ivory">
	<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="mb-14">
			<span class="font-mono text-xs uppercase tracking-widest text-ink/60 block mb-2">03 / CLARITY</span>
			<h2 class="text-3xl sm:text-4xl font-extrabold text-ink tracking-tight font-heading mb-4">
				<?php esc_html_e( 'Frequently Asked Service Questions', 'agency-site' ); ?>
			</h2>
			<p class="text-ink/80 text-base font-normal">
				<?php esc_html_e( 'Clear answers regarding scopes, timelines, technical architecture, and communication.', 'agency-site' ); ?>
			</p>
		</div>

		<div class="border-t border-ink/15 divide-y divide-ink/15" id="faq-accordion">
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
				<div class="faq-item py-6">
					<button type="button" class="faq-toggle w-full text-left flex items-center justify-between text-base sm:text-lg font-bold text-ink hover:text-cobalt focus:outline-none transition-colors" aria-expanded="false">
						<span><?php echo esc_html( $faq['q'] ); ?></span>
						<span class="faq-icon ml-4 font-mono text-sm text-ink/40 shrink-0 transform transition-transform duration-200">+</span>
					</button>
					<div class="faq-content hidden pt-4 text-sm sm:text-base text-ink/80 leading-relaxed font-normal">
						<?php echo esc_html( $faq['a'] ); ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
get_footer();
