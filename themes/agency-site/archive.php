<?php
/**
 * The template for displaying archive pages
 *
 * @package Agency_Site
 */

get_header();
?>

<div class="py-16 md:py-20 bg-gradient-to-b from-white via-agency-50/40 to-slate-50 border-b border-slate-200/60">
	<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
		<span class="badge-tag mb-4">Archive View</span>
		<h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight font-heading mb-4">
			<?php the_archive_title(); ?>
		</h1>
		<?php if ( get_the_archive_description() ) : ?>
			<div class="text-slate-600 text-sm max-w-xl mx-auto">
				<?php the_archive_description(); ?>
			</div>
		<?php endif; ?>
	</div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
	<?php if ( have_posts() ) : ?>
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<?php get_template_part( 'template-parts/post-card' ); ?>
			<?php endwhile; ?>
		</div>

		<div class="pt-12">
			<?php agency_site_pagination(); ?>
		</div>
	<?php else : ?>
		<div class="bg-white rounded-3xl p-12 text-center border border-slate-200">
			<h2 class="text-xl font-bold text-slate-900 font-heading mb-2">No Articles Found</h2>
			<p class="text-slate-600 text-sm mb-6">There are no articles listed under this archive yet.</p>
			<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="btn-primary">Browse All Articles</a>
		</div>
	<?php endif; ?>
</div>

<?php
get_footer();

