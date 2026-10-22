<?php
/**
 * Template part for displaying a blog article card: Editorial Studio Aesthetic
 *
 * @package Agency_Site
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'h-full bg-ivory border border-ink/20 p-6 flex flex-col justify-between group transition-colors duration-200 hover:border-cobalt' ); ?>>
	<div>
		<?php if ( has_post_thumbnail() ) : ?>
			<a href="<?php the_permalink(); ?>" class="block aspect-[16/10] overflow-hidden border border-ink/10 mb-6">
				<?php the_post_thumbnail( 'agency-card', array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300' ) ); ?>
			</a>
		<?php else : ?>
			<!-- Distinctive Editorial Graphic Cover (No repeated headline) -->
			<a href="<?php the_permalink(); ?>" class="block aspect-[16/10] bg-ink/5 border border-ink/15 p-5 mb-6 flex flex-col justify-between relative overflow-hidden group-hover:bg-cobalt/5 transition-colors">
				<div class="flex items-center justify-between font-mono text-[11px] text-ink/60 uppercase tracking-wider">
					<span>NOTE / <?php echo esc_html( get_the_date( 'Y' ) ); ?></span>
					<span class="w-2 h-2 bg-cobalt"></span>
				</div>
				<!-- Editorial Grid Ornament -->
				<svg class="w-full h-12 text-ink/10 my-auto" viewBox="0 0 200 40" fill="none" stroke="currentColor" stroke-width="1">
					<line x1="0" y1="20" x2="200" y2="20"></line>
					<circle cx="20" cy="20" r="4" fill="currentColor"></circle>
					<circle cx="100" cy="20" r="4" fill="currentColor"></circle>
					<circle cx="180" cy="20" r="4" fill="currentColor"></circle>
				</svg>
				<div class="font-mono text-[10px] text-ink/40 uppercase tracking-widest">
					APEX DIGITAL · TECHNICAL INSIGHT
				</div>
			</a>
		<?php endif; ?>

		<div class="flex items-center gap-2 text-xs font-mono text-ink/60 mb-3">
			<?php
			$cats = get_the_category();
			if ( ! empty( $cats ) ) {
				echo '<span class="text-cobalt font-semibold">' . esc_html( $cats[0]->name ) . '</span>';
				echo '<span>/</span>';
			}
			?>
			<span><?php echo esc_html( agency_site_reading_time() ); ?> min read</span>
		</div>

		<h3 class="text-xl font-bold text-ink mb-3 font-heading leading-snug group-hover:text-cobalt transition-colors">
			<a href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
			</a>
		</h3>

		<div class="text-ink/75 text-sm leading-relaxed line-clamp-3 mb-6 font-normal">
			<?php the_excerpt(); ?>
		</div>
	</div>

	<div class="pt-4 border-t border-ink/15 flex items-center justify-between text-xs font-mono text-ink/60">
		<span><?php echo esc_html( get_the_date( 'M j, Y' ) ); ?></span>
		<a href="<?php the_permalink(); ?>" class="font-bold text-ink group-hover:text-cobalt inline-flex items-center gap-1 transition-colors">
			<span>Read Note</span>
			<svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
		</a>
	</div>
</article>
