<?php
/**
 * The template for displaying the Homepage: Editorial Studio Aesthetic
 *
 * @package Agency_Site
 */

get_header();

// Customizer values with fallbacks
$hero_badge    = get_theme_mod( 'agency_hero_badge', __( 'Apex Digital Studio · 2026', 'agency-site' ) );
$hero_headline = get_theme_mod( 'agency_hero_headline', __( 'Make your business hard to miss.', 'agency-site' ) );
$hero_subhead  = get_theme_mod( 'agency_hero_subhead', __( 'We help growing businesses improve their websites, get found in search and turn advertising clicks into enquiries.', 'agency-site' ) );
$hero_cta_text = get_theme_mod( 'agency_hero_cta_text', __( 'Discuss your project', 'agency-site' ) );
$hero_cta_link = get_theme_mod( 'agency_hero_cta_link', home_url( '/contact/' ) );
$hero_sec_text = get_theme_mod( 'agency_hero_sec_cta_text', __( 'Explore our services', 'agency-site' ) );
$hero_sec_link = get_theme_mod( 'agency_hero_sec_cta_link', home_url( '/services/' ) );
?>

<!-- 1. Hero Section: Split Editorial Composition -->
<section class="relative pt-12 pb-16 md:pt-20 md:pb-24 overflow-hidden border-b border-ink/15">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
			
			<!-- Left Column: Studio Proposition -->
			<div class="lg:col-span-7 space-y-6">
				<div class="inline-flex items-center gap-2 font-mono text-xs uppercase tracking-widest text-ink/70">
					<span class="w-2 h-2 bg-cobalt"></span>
					<span><?php echo esc_html( $hero_badge ); ?></span>
				</div>

				<h1 class="text-4xl sm:text-5xl md:text-6xl xl:text-7xl font-extrabold text-ink tracking-tight font-heading leading-[1.08]">
					Make your business <span class="font-serif italic font-normal text-cobalt">hard to miss.</span>
				</h1>

				<p class="text-lg sm:text-xl text-ink/80 leading-relaxed font-normal max-w-xl">
					<?php echo esc_html( $hero_subhead ); ?>
				</p>

				<div class="pt-2 flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
					<a href="<?php echo esc_url( $hero_cta_link ); ?>" class="btn-primary !py-4 !px-8 text-sm uppercase tracking-wider font-semibold text-center">
						<span><?php echo esc_html( $hero_cta_text ); ?></span>
						<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
					</a>
					<a href="<?php echo esc_url( $hero_sec_link ); ?>" class="btn-secondary !py-4 !px-8 text-sm uppercase tracking-wider font-semibold text-center">
						<span><?php echo esc_html( $hero_sec_text ); ?></span>
					</a>
				</div>

				<div class="pt-6 border-t border-ink/10 flex flex-wrap items-center gap-6 text-xs font-mono text-ink/60">
					<span>01 / Custom Architecture</span>
					<span>02 / Technical SEO</span>
					<span>03 / Conversion Paths</span>
				</div>
			</div>

			<!-- Right Column: Interactive HTML/CSS/SVG Poster Artwork -->
			<div class="lg:col-span-5">
				<div class="poster-viewport max-w-md mx-auto lg:max-w-none">
					
					<!-- Poster Switcher Tabs -->
					<div class="flex items-center justify-between border-t border-x border-ink/20 bg-ivory px-3 py-2 text-xs font-mono" role="tablist" aria-label="<?php esc_attr_e( 'Poster Design Studies', 'agency-site' ); ?>">
						<span class="text-[10px] uppercase tracking-wider text-ink/50 hidden sm:inline-block">STUDY</span>
						<div class="flex items-center gap-1 w-full sm:w-auto justify-end">
							<button 
								type="button" 
								id="study-tab-1" 
								role="tab" 
								aria-selected="true" 
								aria-controls="study-panel-1" 
								class="poster-tab-btn px-2.5 py-1 text-xs font-bold transition-colors bg-coral text-white"
								data-study="1"
							>
								01 Coral
							</button>
							<button 
								type="button" 
								id="study-tab-2" 
								role="tab" 
								aria-selected="false" 
								aria-controls="study-panel-2" 
								class="poster-tab-btn px-2.5 py-1 text-xs font-bold transition-colors bg-ivory text-ink hover:bg-ink/10"
								data-study="2"
							>
								02 Cobalt
							</button>
							<button 
								type="button" 
								id="study-tab-3" 
								role="tab" 
								aria-selected="false" 
								aria-controls="study-panel-3" 
								class="poster-tab-btn px-2.5 py-1 text-xs font-bold transition-colors bg-ivory text-ink hover:bg-ink/10"
								data-study="3"
							>
								03 Lime
							</button>
						</div>
					</div>

					<!-- Poster Artboard (Preserves aspect ratio, bounded pointer movement) -->
					<div id="poster-artboard" class="poster-canvas border border-ink/20 shadow-poster relative aspect-[4/5] overflow-hidden select-none">
						
						<!-- Study 1: Coral — "BE SEEN." -->
						<div id="study-panel-1" role="tabpanel" aria-labelledby="study-tab-1" class="study-panel absolute inset-0 bg-coral text-ink p-8 sm:p-10 flex flex-col justify-between transition-opacity duration-300 opacity-100 z-10">
							<div class="flex items-start justify-between border-b border-ink/20 pb-4">
								<div>
									<span class="font-mono text-xs uppercase tracking-widest block font-bold">POSTER STUDY / 01</span>
									<span class="text-[11px] font-mono text-ink/70">Scale & Presence</span>
								</div>
								<div class="w-7 h-7 border border-ink flex items-center justify-center font-mono text-xs font-bold">
									01
								</div>
							</div>

							<!-- Dynamic SVG Graphic Motif -->
							<div class="my-auto py-4 relative">
								<svg class="absolute right-0 top-1/2 -translate-y-1/2 w-44 h-44 text-ink/15 pointer-events-none" viewBox="0 0 100 100" fill="none" stroke="currentColor" stroke-width="1.5">
									<circle cx="50" cy="50" r="45" stroke-dasharray="2 3"></circle>
									<circle cx="50" cy="50" r="30"></circle>
									<circle cx="50" cy="50" r="15"></circle>
									<line x1="50" y1="0" x2="50" y2="100"></line>
									<line x1="0" y1="50" x2="100" y2="50"></line>
								</svg>
								<div class="font-heading font-black text-6xl sm:text-7xl lg:text-8xl tracking-tighter leading-[0.88] text-ink relative z-10">
									BE<br>SEEN.
								</div>
							</div>

							<div class="pt-4 border-t border-ink/20 flex items-center justify-between font-mono text-xs">
								<span>APEX DIGITAL</span>
								<span>2026 // STUDIO</span>
							</div>
						</div>

						<!-- Study 2: Cobalt — "FIND YOUR people." -->
						<div id="study-panel-2" role="tabpanel" aria-labelledby="study-tab-2" class="study-panel absolute inset-0 bg-cobalt text-ivory p-8 sm:p-10 flex flex-col justify-between transition-opacity duration-300 opacity-0 pointer-events-none z-0">
							<div class="flex items-start justify-between border-b border-ivory/20 pb-4">
								<div>
									<span class="font-mono text-xs uppercase tracking-widest block font-bold text-lime">POSTER STUDY / 02</span>
									<span class="text-[11px] font-mono text-ivory/70">Typography & Clarity</span>
								</div>
								<div class="w-7 h-7 border border-ivory flex items-center justify-center font-mono text-xs font-bold text-ivory">
									02
								</div>
							</div>

							<!-- Graphic Motif -->
							<div class="my-auto py-4 relative">
								<svg class="absolute -right-4 -bottom-4 w-48 h-48 text-ivory/10 pointer-events-none" viewBox="0 0 100 100" fill="none" stroke="currentColor" stroke-width="1">
									<rect x="10" y="10" width="80" height="80"></rect>
									<rect x="25" y="25" width="50" height="50"></rect>
									<line x1="10" y1="10" x2="90" y2="90"></line>
									<line x1="10" y1="90" x2="90" y2="10"></line>
								</svg>
								<div class="font-heading font-black text-4xl sm:text-5xl lg:text-6xl tracking-tight leading-none text-ivory relative z-10">
									FIND YOUR<br>
									<span class="font-serif italic font-normal text-lime text-5xl sm:text-6xl lg:text-7xl">people.</span>
								</div>
							</div>

							<div class="pt-4 border-t border-ivory/20 flex items-center justify-between font-mono text-xs text-ivory/80">
								<span>APEX DIGITAL</span>
								<span>2026 // FOCUS</span>
							</div>
						</div>

						<!-- Study 3: Lime — "MAKE IT MATTER." -->
						<div id="study-panel-3" role="tabpanel" aria-labelledby="study-tab-3" class="study-panel absolute inset-0 bg-lime text-ink p-8 sm:p-10 flex flex-col justify-between transition-opacity duration-300 opacity-0 pointer-events-none z-0">
							<div class="flex items-start justify-between border-b border-ink/20 pb-4">
								<div>
									<span class="font-mono text-xs uppercase tracking-widest block font-bold">POSTER STUDY / 03</span>
									<span class="text-[11px] font-mono text-ink/70">Contrast & Impact</span>
								</div>
								<div class="w-7 h-7 bg-ink text-lime flex items-center justify-center font-mono text-xs font-bold">
									03
								</div>
							</div>

							<!-- Graphic Motif -->
							<div class="my-auto py-4 relative">
								<svg class="absolute right-0 top-0 w-40 h-40 text-ink/15 pointer-events-none" viewBox="0 0 100 100" fill="none" stroke="currentColor" stroke-width="2">
									<polygon points="50,5 95,95 5,95"></polygon>
									<line x1="50" y1="5" x2="50" y2="95"></line>
								</svg>
								<div class="font-heading font-black text-5xl sm:text-6xl lg:text-7xl tracking-tighter leading-none text-ink relative z-10">
									MAKE IT<br>
									<span class="bg-cobalt text-white px-2 py-0.5 inline-block mt-1">MATTER.</span>
								</div>
							</div>

							<div class="pt-4 border-t border-ink/20 flex items-center justify-between font-mono text-xs">
								<span>APEX DIGITAL</span>
								<span>2026 // ACTION</span>
							</div>
						</div>

					</div>

					<p class="mt-3 text-[11px] font-mono text-ink/60 uppercase tracking-wider text-center">
						<?php esc_html_e( 'Design studies. Explorations in typography, scale and presence. Not client work or commercial claims.', 'agency-site' ); ?>
					</p>

				</div>
			</div>

		</div>
	</div>
</section>

<!-- 2. Studio Positioning Statement -->
<section class="py-16 lg:py-24 border-b border-ink/15">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-baseline">
			<div class="lg:col-span-4">
				<span class="font-mono text-xs uppercase tracking-widest text-ink/60 block mb-2">01 / MANIFESTO</span>
				<h2 class="text-xl font-bold font-heading text-ink">Built for genuine commercial clarity.</h2>
			</div>
			<div class="lg:col-span-8">
				<p class="text-2xl sm:text-3xl lg:text-4xl text-ink font-heading font-semibold leading-snug">
					We engineer custom WordPress websites and search campaigns designed to be <span class="font-serif italic font-normal text-cobalt">hard to ignore</span>. No synthetic metrics or bloated page-builders—just fast, resilient platforms that turn qualified visits into serious project enquiries.
				</p>
			</div>
		</div>
	</div>
</section>

<!-- 3. Numbered Service Rows -->
<section id="services" class="py-16 lg:py-24 border-b border-ink/15">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		
		<div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12">
			<div>
				<span class="font-mono text-xs uppercase tracking-widest text-ink/60 block mb-2">02 / CORE CAPABILITIES</span>
				<h2 class="text-3xl sm:text-4xl font-extrabold text-ink tracking-tight font-heading">
					<?php esc_html_e( 'Services Designed to Generate Enquiries', 'agency-site' ); ?>
				</h2>
			</div>
			<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="btn-secondary !py-2.5 !px-5 text-xs uppercase tracking-wider font-semibold self-start sm:self-auto">
				<?php esc_html_e( 'Explore All Capabilities', 'agency-site' ); ?> →
			</a>
		</div>

		<!-- Numbered Rows List -->
		<div class="border-t border-ink/15 divide-y divide-ink/15">
			<?php
			$services_query = new WP_Query(
				array(
					'post_type'      => 'agency_service',
					'posts_per_page' => 6,
					'orderby'        => 'menu_order date',
					'order'          => 'ASC',
				)
			);

			$service_idx = 0;
			if ( $services_query->have_posts() ) :
				while ( $services_query->have_posts() ) :
					$services_query->the_post();
					++$service_idx;
					$num_str       = sprintf( '%02d', $service_idx );
					$tagline       = get_post_meta( get_the_ID(), '_agency_service_tagline', true );
					$price         = get_post_meta( get_the_ID(), '_agency_service_price', true );
					$deliverables  = get_post_meta( get_the_ID(), '_agency_service_deliverables', true );
					$deliv_items   = ! empty( $deliverables ) ? array_slice( array_filter( array_map( 'trim', explode( "\n", $deliverables ) ) ), 0, 3 ) : array();
					$service_title = get_the_title();
					$service_link  = get_permalink();
					?>
				<div class="group py-8 lg:py-10 transition-colors duration-200 hover:bg-ivory/60">
					<div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
						
						<!-- Col 1: Number -->
						<div class="md:col-span-1">
							<span class="font-mono text-sm text-ink/50 group-hover:text-cobalt transition-colors font-bold">
								<?php echo esc_html( $num_str ); ?>
							</span>
						</div>

						<!-- Col 2: Title & Tagline -->
						<div class="md:col-span-5">
							<h3 class="text-xl sm:text-2xl font-bold font-heading text-ink group-hover:text-cobalt transition-colors">
								<a href="<?php echo esc_url( $service_link ); ?>" class="hover:underline">
									<?php echo esc_html( $service_title ); ?>
								</a>
							</h3>
							<?php if ( ! empty( $tagline ) ) : ?>
								<p class="text-xs sm:text-sm text-ink/70 mt-1"><?php echo esc_html( $tagline ); ?></p>
							<?php endif; ?>
						</div>

						<!-- Col 3: Deliverables Tags -->
						<div class="md:col-span-4">
							<?php if ( ! empty( $deliv_items ) ) : ?>
								<div class="flex flex-wrap gap-2">
									<?php foreach ( $deliv_items as $item ) : ?>
										<span class="editorial-tag !text-[11px] !py-0.5">
											<?php echo esc_html( $item ); ?>
										</span>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
						</div>

						<!-- Col 4: Action & Investment Indicator -->
						<div class="md:col-span-2 flex items-center justify-between md:justify-end gap-4 text-xs font-mono">
							<?php if ( ! empty( $price ) ) : ?>
								<span class="text-ink/60 hidden lg:inline-block"><?php echo esc_html( $price ); ?></span>
							<?php endif; ?>
							<?php
							/* translators: %s: service title */
							$service_aria_label = sprintf( __( 'View %s details', 'agency-site' ), $service_title );
							?>
							<a href="<?php echo esc_url( $service_link ); ?>" class="w-10 h-10 border border-ink/20 group-hover:border-cobalt group-hover:bg-cobalt group-hover:text-white flex items-center justify-center transition-all shrink-0" aria-label="<?php echo esc_attr( $service_aria_label ); ?>">
								<svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
							</a>
						</div>

					</div>
				</div>
					<?php
				endwhile;
				wp_reset_postdata();
			else :
				// Fallback default services rendered as sleek numbered rows
				$default_services = agency_site_get_default_services();
				foreach ( $default_services as $srv ) :
					++$service_idx;
					$num_str     = sprintf( '%02d', $service_idx );
					$deliv_items = ! empty( $srv['deliverables'] ) ? array_slice( $srv['deliverables'], 0, 3 ) : array();
					?>
				<div class="group py-8 lg:py-10 transition-colors duration-200 hover:bg-ivory/60">
					<div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
						<div class="md:col-span-1">
							<span class="font-mono text-sm text-ink/50 group-hover:text-cobalt transition-colors font-bold"><?php echo esc_html( $num_str ); ?></span>
						</div>
						<div class="md:col-span-5">
							<h3 class="text-xl sm:text-2xl font-bold font-heading text-ink group-hover:text-cobalt transition-colors">
								<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="hover:underline">
									<?php echo esc_html( $srv['title'] ); ?>
								</a>
							</h3>
							<p class="text-xs sm:text-sm text-ink/70 mt-1"><?php echo esc_html( $srv['tagline'] ); ?></p>
						</div>
						<div class="md:col-span-4">
							<div class="flex flex-wrap gap-2">
								<?php foreach ( $deliv_items as $item ) : ?>
									<span class="editorial-tag !text-[11px] !py-0.5"><?php echo esc_html( $item ); ?></span>
								<?php endforeach; ?>
							</div>
						</div>
						<div class="md:col-span-2 flex items-center justify-between md:justify-end gap-4 text-xs font-mono">
							<span class="text-ink/60 hidden lg:inline-block"><?php echo esc_html( $srv['price'] ); ?></span>
							<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="w-10 h-10 border border-ink/20 group-hover:border-cobalt group-hover:bg-cobalt group-hover:text-white flex items-center justify-center transition-all shrink-0">
								<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
							</a>
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

<!-- 4. Project Process Section -->
<section class="py-16 lg:py-24 border-b border-ink/15">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		
		<div class="max-w-3xl mb-14">
			<span class="font-mono text-xs uppercase tracking-widest text-ink/60 block mb-2">03 / PROJECT PROCESS</span>
			<h2 class="text-3xl sm:text-4xl font-extrabold text-ink tracking-tight font-heading mb-4">
				<?php esc_html_e( 'How Projects Are Planned, Delivered and Supported', 'agency-site' ); ?>
			</h2>
			<p class="text-base sm:text-lg text-ink/80 leading-relaxed font-normal">
				<?php esc_html_e( 'We replace guesswork with structured discovery, focused implementation sprints, and straightforward reporting.', 'agency-site' ); ?>
			</p>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
			
			<!-- Stage 1 -->
			<div class="border border-ink/20 p-8 flex flex-col justify-between bg-ivory">
				<div>
					<div class="font-mono text-sm font-bold text-cobalt mb-6">
						01 / DISCOVERY
					</div>
					<h3 class="text-xl font-bold text-ink font-heading mb-3">
						<?php esc_html_e( 'Audit & Technical Discovery', 'agency-site' ); ?>
					</h3>
					<p class="text-sm text-ink/80 leading-relaxed mb-6">
						<?php esc_html_e( 'We evaluate your current website performance, keyword rankings, and visitor drop-off points to define clear objectives and prioritize high-impact deliverables.', 'agency-site' ); ?>
					</p>
				</div>
				<div class="pt-4 border-t border-ink/15 text-xs font-mono text-ink/60">
					<span>Deliverable: Technical audit & roadmap</span>
				</div>
			</div>

			<!-- Stage 2 -->
			<div class="border border-ink/20 p-8 flex flex-col justify-between bg-ivory">
				<div>
					<div class="font-mono text-sm font-bold text-coral mb-6">
						02 / PRODUCTION
					</div>
					<h3 class="text-xl font-bold text-ink font-heading mb-3">
						<?php esc_html_e( 'Focused Execution Sprints', 'agency-site' ); ?>
					</h3>
					<p class="text-sm text-ink/80 leading-relaxed mb-6">
						<?php esc_html_e( 'We implement technical SEO fixes, build high-converting landing pages, and configure reliable conversion tracking so your campaigns launch cleanly.', 'agency-site' ); ?>
					</p>
				</div>
				<div class="pt-4 border-t border-ink/15 text-xs font-mono text-ink/60">
					<span>Deliverable: Production build & tracking</span>
				</div>
			</div>

			<!-- Stage 3 -->
			<div class="border border-ink/20 p-8 flex flex-col justify-between bg-ivory">
				<div>
					<div class="font-mono text-sm font-bold text-ink mb-6">
						03 / CARE & EVOLUTION
					</div>
					<h3 class="text-xl font-bold text-ink font-heading mb-3">
						<?php esc_html_e( 'Review & Ongoing Support', 'agency-site' ); ?>
					</h3>
					<p class="text-sm text-ink/80 leading-relaxed mb-6">
						<?php esc_html_e( 'We provide monthly performance summaries explaining enquiry trends, keyword movements, and recommendations for continued site refinement.', 'agency-site' ); ?>
					</p>
				</div>
				<div class="pt-4 border-t border-ink/15 text-xs font-mono text-ink/60">
					<span>Deliverable: Monthly report & maintenance</span>
				</div>
			</div>

		</div>

	</div>
</section>

<!-- 5. Editorial Article Previews -->
<section class="py-16 lg:py-24 border-b border-ink/15">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		
		<div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12 gap-4">
			<div>
				<span class="font-mono text-xs uppercase tracking-widest text-ink/60 block mb-2">04 / EDITORIAL GUIDES</span>
				<h2 class="text-3xl sm:text-4xl font-extrabold text-ink tracking-tight font-heading">
					<?php esc_html_e( 'Insights & Technical Notes', 'agency-site' ); ?>
				</h2>
			</div>
			<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ) ); ?>" class="btn-secondary !py-2.5 !px-5 text-xs uppercase tracking-wider font-semibold self-start sm:self-auto">
				<?php esc_html_e( 'View All Articles', 'agency-site' ); ?> →
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

<!-- 6. Strong Contact Invitation -->
<section class="py-16 lg:py-24 bg-ivory">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="border border-ink/20 p-8 sm:p-14 lg:p-20 bg-ivory flex flex-col lg:flex-row lg:items-center justify-between gap-10">
			<div class="max-w-2xl">
				<span class="font-mono text-xs uppercase tracking-widest text-cobalt font-bold block mb-3">05 / START A PROJECT</span>
				<h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-ink tracking-tight font-heading leading-tight mb-4">
					Ready to turn visits into serious enquiries?
				</h2>
				<p class="text-ink/80 text-base sm:text-lg leading-relaxed">
					Connect directly with our engineering and growth team to review your technical architecture and receive a clear proposal.
				</p>
			</div>
			<div class="shrink-0 flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
				<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn-primary !py-4 !px-8 text-sm uppercase tracking-wider font-semibold text-center">
					<span>Discuss your project</span>
					<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
				</a>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();
