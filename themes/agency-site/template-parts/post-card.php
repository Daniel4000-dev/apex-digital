<?php
/**
 * Template part for displaying a blog article card
 *
 * @package Agency_Site
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'bg-white rounded-3xl overflow-hidden border border-slate-200/80 shadow-soft card-hover flex flex-col justify-between' ); ?>>
	<div>
		<?php if ( has_post_thumbnail() ) : ?>
			<a href="<?php the_permalink(); ?>" class="block aspect-video overflow-hidden group">
				<?php the_post_thumbnail( 'agency-card', array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300' ) ); ?>
			</a>
		<?php else : ?>
			<a href="<?php the_permalink(); ?>" class="block aspect-video bg-gradient-to-tr from-agency-700 to-agency-950 p-6 flex items-end">
				<span class="text-white/80 font-bold text-sm line-clamp-2"><?php the_title(); ?></span>
			</a>
		<?php endif; ?>

		<div class="p-6">
			<div class="flex items-center gap-2 text-xs text-slate-500 mb-3">
				<?php
				$cats = get_the_category();
				if ( ! empty( $cats ) ) {
					echo '<span class="font-semibold text-agency-600 bg-agency-50 px-2.5 py-0.5 rounded-full">' . esc_html( $cats[0]->name ) . '</span>';
				}
				?>
				<span>•</span>
				<span><?php echo esc_html( agency_site_reading_time() ); ?> min read</span>
			</div>

			<h3 class="text-lg font-bold text-slate-900 mb-2 font-heading leading-snug">
				<a href="<?php the_permalink(); ?>" class="hover:text-agency-600 transition-colors">
					<?php the_title(); ?>
				</a>
			</h3>

			<div class="text-slate-600 text-xs sm:text-sm line-clamp-2 mb-4">
				<?php the_excerpt(); ?>
			</div>
		</div>
	</div>

	<div class="px-6 pb-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
		<span><?php echo esc_html( get_the_date( 'M j, Y' ) ); ?></span>
		<a href="<?php the_permalink(); ?>" class="font-bold text-agency-600 hover:text-agency-700">Read More →</a>
	</div>
</article>

