<?php
/**
 * The template for displaying individual Service CPT posts
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
	<header class="py-16 md:py-20 bg-gradient-to-b from-white via-agency-50/40 to-slate-50 border-b border-slate-200/60">
		<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
			<div class="flex items-center justify-center gap-2 mb-4">
				<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="text-xs font-semibold text-agency-600 hover:text-agency-700">← Back to All Services</a>
				<?php if ( $badge ) : ?>
					<span class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-bold bg-agency-100 text-agency-700 ml-2">
						<?php echo esc_html( $badge ); ?>
					</span>
				<?php endif; ?>
			</div>

			<h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight font-heading mb-4">
				<?php the_title(); ?>
			</h1>

			<?php if ( $tagline ) : ?>
				<p class="text-lg text-slate-600 max-w-2xl mx-auto"><?php echo esc_html( $tagline ); ?></p>
			<?php endif; ?>
		</div>
	</header>

	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
		<div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
			
			<div class="lg:col-span-8 space-y-8">
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="rounded-3xl overflow-hidden shadow-soft mb-8">
						<?php the_post_thumbnail( 'agency-hero', array( 'class' => 'w-full h-auto object-cover' ) ); ?>
					</div>
				<?php endif; ?>

				<div class="prose prose-lg prose-slate max-w-none prose-headings:font-heading prose-headings:font-bold prose-a:text-agency-600">
					<?php the_content(); ?>
				</div>

				<div class="bg-agency-50 border border-agency-200 rounded-3xl p-8 mt-12 flex flex-col sm:flex-row items-center justify-between gap-6">
					<div>
						<h3 class="text-xl font-bold text-slate-900 font-heading mb-1">Ready to deploy this capability?</h3>
						<p class="text-sm text-slate-600">Speak with our specialist to review your current setup and receive a custom roadmap.</p>
					</div>
					<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>?service=<?php echo rawurlencode( get_the_title() ); ?>" class="btn-primary shrink-0">
						<span>Schedule Consultation</span>
						<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
					</a>
				</div>
			</div>

			<aside class="lg:col-span-4 space-y-8">
				<div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-soft sticky top-28">
					<h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">Service Overview</h3>
					
					<?php if ( $price ) : ?>
						<div class="mb-6 pb-6 border-b border-slate-100">
							<span class="text-xs text-slate-500 block">Investment Indicator</span>
							<span class="text-2xl font-extrabold text-slate-900 block mt-1"><?php echo esc_html( $price ); ?></span>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $items ) ) : ?>
						<div class="mb-8">
							<h4 class="text-sm font-bold text-slate-900 mb-3">Included Deliverables:</h4>
							<ul class="space-y-3">
								<?php foreach ( $items as $item ) : ?>
									<li class="flex items-start gap-2.5 text-xs text-slate-600">
										<svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
										<span><?php echo esc_html( $item ); ?></span>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>

					<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>?service=<?php echo rawurlencode( get_the_title() ); ?>" class="btn-primary w-full text-center">
						Request Proposal
					</a>
				</div>
			</aside>

		</div>
	</div>
</article>

	<?php
endwhile;

get_footer();

