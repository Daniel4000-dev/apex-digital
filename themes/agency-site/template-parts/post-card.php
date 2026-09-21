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
<article id="post-<?php the_ID(); ?>" <?php post_class( 'h-full bg-white rounded-3xl overflow-hidden border border-slate-200/80 shadow-soft card-hover flex flex-col justify-between' ); ?>>
	<div>
		<?php if ( has_post_thumbnail() ) : ?>
			<a href="<?php the_permalink(); ?>" class="block aspect-video overflow-hidden group">
				<?php the_post_thumbnail( 'agency-card', array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300' ) ); ?>
			</a>
		<?php else : ?>
			<a href="<?php the_permalink(); ?>" class="block aspect-video bg-gradient-to-tr from-slate-900 via-agency-950 to-slate-800 p-6 flex flex-col justify-between relative overflow-hidden group">
				<div class="absolute -right-8 -top-8 w-32 h-32 bg-agency-500/10 rounded-full blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>
				<div class="flex items-center justify-between text-xs text-agency-300 font-semibold uppercase tracking-wider relative z-10">
					<span>Editorial Guide</span>
					<svg class="w-5 h-5 text-agency-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
				</div>
				<div class="flex items-center gap-2 relative z-10">
					<span class="w-2 h-2 rounded-full bg-agency-400"></span>
					<span class="text-slate-300 text-xs font-medium tracking-wide">Apex Digital Strategy Note</span>
				</div>
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

