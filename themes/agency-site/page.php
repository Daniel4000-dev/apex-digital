<?php
/**
 * The template for displaying all default pages
 *
 * @package Agency_Site
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

<div class="py-16 md:py-20 bg-gradient-to-b from-white via-agency-50/30 to-slate-50 border-b border-slate-200/60">
	<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
		<h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight font-heading mb-4">
			<?php the_title(); ?>
		</h1>
		<?php if ( has_excerpt() ) : ?>
			<p class="text-lg text-slate-600 max-w-2xl mx-auto"><?php echo esc_html( get_the_excerpt() ); ?></p>
		<?php endif; ?>
	</div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="mb-10 rounded-3xl overflow-hidden shadow-soft">
				<?php the_post_thumbnail( 'agency-hero', array( 'class' => 'w-full h-auto object-cover' ) ); ?>
			</div>
		<?php endif; ?>

		<div class="prose prose-lg prose-slate max-w-none prose-headings:font-heading prose-headings:font-bold prose-a:text-agency-600">
			<?php the_content(); ?>
		</div>

		<?php
		wp_link_pages(
			array(
				'before' => '<div class="page-links mt-8 pt-4 border-t border-slate-200 text-sm font-semibold flex items-center gap-2"><span class="text-slate-500">Pages:</span>',
				'after'  => '</div>',
			)
		);
		?>
	</article>
</div>

	<?php
endwhile;

get_footer();

