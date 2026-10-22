<?php
/**
 * The template for displaying individual Service CPT posts: Editorial Studio Aesthetic
 *
 * @package Agency_Site
 */

get_header();

while ( have_posts() ) :
	the_post();
	$tagline      = get_post_meta( get_the_ID(), '_agency_service_tagline', true );
	$price        = get_post_meta( get_the_ID(), '_agency_service_price', true );
	$deliverables = get_post_meta( get_the_ID(), '_agency_service_deliverables', true );
	$icon_type    = get_post_meta( get_the_ID(), '_agency_service_icon', true ) ?: 'chart';
	$badge        = get_post_meta( get_the_ID(), '_agency_service_badge', true );
	$items        = ! empty( $deliverables ) ? array_filter( array_map( 'trim', explode( "\n", $deliverables ) ) ) : array();
	?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="py-16 md:py-24 bg-ivory border-b border-ink/15">
		<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
			<div class="flex items-center justify-center gap-3 mb-6 font-mono text-xs">
				<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="font-bold text-ink hover:text-cobalt transition-colors">
					← <?php esc_html_e( 'Back to All Services', 'agency-site' ); ?>
				</a>
				<?php if ( $badge ) : ?>
					<span class="editorial-tag !text-[10px]">
						<?php echo esc_html( $badge ); ?>
					</span>
				<?php endif; ?>
			</div>

			<h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-ink tracking-tight font-heading mb-6 leading-tight">
				<?php the_title(); ?>
			</h1>

			<?php if ( $tagline ) : ?>
				<p class="text-lg sm:text-xl text-ink/80 max-w-2xl mx-auto font-normal leading-relaxed"><?php echo esc_html( $tagline ); ?></p>
			<?php endif; ?>
		</div>
	</header>

	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
		<div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
			
			<!-- Main Service Content (8 cols) -->
			<div class="lg:col-span-8 space-y-10">
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="border border-ink/20 overflow-hidden mb-8">
						<?php the_post_thumbnail( 'agency-hero', array( 'class' => 'w-full h-auto object-cover' ) ); ?>
					</div>
				<?php endif; ?>

				<div class="prose prose-lg max-w-none text-ink prose-headings:font-heading prose-headings:font-bold prose-headings:text-ink prose-p:text-ink/80 prose-a:text-cobalt prose-li:text-ink/80">
					<?php the_content(); ?>
				</div>

				<!-- Direct Strategy Consultation Box -->
				<div class="border border-ink/20 p-8 sm:p-10 bg-ivory mt-12 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
					<div>
						<span class="font-mono text-xs uppercase tracking-widest text-cobalt block mb-1">DEPLOYMENT</span>
						<h3 class="text-xl font-bold text-ink font-heading"><?php esc_html_e( 'Ready to deploy this capability?', 'agency-site' ); ?></h3>
						<p class="text-sm text-ink/80 mt-1"><?php esc_html_e( 'Speak with our engineering specialist to review your setup and receive a custom roadmap.', 'agency-site' ); ?></p>
					</div>
					<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>?service=<?php echo rawurlencode( get_the_title() ); ?>" class="btn-primary !py-3.5 !px-6 text-xs uppercase tracking-wider font-semibold shrink-0">
						<span><?php esc_html_e( 'Schedule Consultation', 'agency-site' ); ?></span>
						<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
					</a>
				</div>
			</div>

			<!-- Sidebar Overview (4 cols) -->
			<aside class="lg:col-span-4 space-y-8">
				<div class="border border-ink/20 p-6 sm:p-8 bg-ivory sticky top-28">
					<h3 class="font-mono text-xs uppercase tracking-widest text-ink/60 mb-6"><?php esc_html_e( 'Capability Overview', 'agency-site' ); ?></h3>
					
					<?php if ( $price ) : ?>
						<div class="mb-6 pb-6 border-b border-ink/15">
							<span class="text-xs font-mono text-ink/60 block"><?php esc_html_e( 'Investment Indicator', 'agency-site' ); ?></span>
							<span class="text-2xl font-bold text-ink font-heading block mt-1"><?php echo esc_html( $price ); ?></span>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $items ) ) : ?>
						<div class="mb-8">
							<h4 class="text-xs font-mono uppercase tracking-widest text-ink/70 mb-4"><?php esc_html_e( 'Included Deliverables:', 'agency-site' ); ?></h4>
							<ul class="space-y-3 font-mono text-xs text-ink/80">
								<?php foreach ( $items as $item ) : ?>
									<li class="flex items-start gap-2">
										<span class="text-cobalt font-bold mt-0.5">+</span>
										<span><?php echo esc_html( $item ); ?></span>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>

					<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>?service=<?php echo rawurlencode( get_the_title() ); ?>" class="btn-primary w-full text-center !py-3.5 text-xs uppercase tracking-wider font-semibold">
						<?php esc_html_e( 'Request Proposal', 'agency-site' ); ?>
					</a>
				</div>
			</aside>

		</div>
	</div>
</article>

	<?php
endwhile;

get_footer();
