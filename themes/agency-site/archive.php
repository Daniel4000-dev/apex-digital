<?php
/**
 * The template for displaying archive pages: Editorial Studio Aesthetic
 *
 * @package Agency_Site
 */

get_header();
?>

<header class="py-16 md:py-24 bg-ivory border-b border-ink/15">
	<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
		<span class="editorial-tag mb-4">ARCHIVE VIEW</span>
		<h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-ink tracking-tight font-heading mb-4">
			<?php the_archive_title(); ?>
		</h1>
		<?php if ( get_the_archive_description() ) : ?>
			<div class="text-ink/80 text-sm max-w-xl mx-auto font-normal leading-relaxed">
				<?php the_archive_description(); ?>
			</div>
		<?php endif; ?>
	</div>
</header>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
	<?php if ( have_posts() ) : ?>
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/post-card' );
			endwhile;
			?>
		</div>

		<div class="pt-12">
			<?php agency_site_pagination(); ?>
		</div>
	<?php else : ?>
		<div class="border border-ink/20 p-12 text-center bg-ivory">
			<h2 class="text-xl font-bold text-ink font-heading mb-2"><?php esc_html_e( 'No Articles Found', 'agency-site' ); ?></h2>
			<p class="text-ink/70 text-sm mb-6"><?php esc_html_e( 'There are no articles listed under this category yet.', 'agency-site' ); ?></p>
			<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="btn-primary"><?php esc_html_e( 'Browse All Articles', 'agency-site' ); ?></a>
		</div>
	<?php endif; ?>
</div>

<?php
get_footer();
