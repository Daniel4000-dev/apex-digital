<?php
/**
 * The template for displaying all default pages: Editorial Studio Aesthetic
 *
 * @package Agency_Site
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

<header class="py-16 md:py-24 bg-ivory border-b border-ink/15">
	<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
		<h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-ink tracking-tight font-heading mb-4">
			<?php the_title(); ?>
		</h1>
		<?php if ( has_excerpt() ) : ?>
			<p class="text-lg text-ink/80 max-w-2xl mx-auto font-normal"><?php echo esc_html( get_the_excerpt() ); ?></p>
		<?php endif; ?>
	</div>
</header>

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="mb-10 border border-ink/20 overflow-hidden">
				<?php the_post_thumbnail( 'agency-hero', array( 'class' => 'w-full h-auto object-cover' ) ); ?>
			</div>
		<?php endif; ?>

		<div class="prose prose-lg max-w-none text-ink prose-headings:font-heading prose-headings:font-bold prose-headings:text-ink prose-p:text-ink/80 prose-a:text-cobalt">
			<?php the_content(); ?>
		</div>

		<?php
		wp_link_pages(
			array(
				'before' => '<div class="page-links mt-8 pt-4 border-t border-ink/15 text-sm font-mono flex items-center gap-2"><span class="text-ink/60">Pages:</span>',
				'after'  => '</div>',
			)
		);
		?>
	</article>
</div>

	<?php
endwhile;

get_footer();
