<?php
/**
 * The template for displaying search results: Editorial Studio Aesthetic
 *
 * @package Agency_Site
 */

get_header();
?>

<header class="py-16 md:py-24 bg-ivory border-b border-ink/15">
	<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
		<span class="editorial-tag mb-4">SEARCH RESULTS</span>
		<h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-ink tracking-tight font-heading mb-4">
			Results for: "<?php echo esc_html( get_search_query() ); ?>"
		</h1>
		<p class="font-mono text-xs text-ink/60">
			Found <?php echo esc_html( (string) $wp_query->found_posts ); ?> matching entries
		</p>
	</div>
</header>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
	<?php if ( have_posts() ) : ?>
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article class="bg-ivory border border-ink/20 p-6 flex flex-col justify-between transition-colors duration-200 hover:border-cobalt">
					<div>
						<span class="font-mono text-[11px] font-bold uppercase tracking-wider text-cobalt block mb-2">
							<?php echo esc_html( get_post_type() ); ?>
						</span>
						<h2 class="text-lg font-bold text-ink mb-2 font-heading leading-snug">
							<a href="<?php the_permalink(); ?>" class="hover:text-cobalt transition-colors">
								<?php the_title(); ?>
							</a>
						</h2>
						<div class="text-ink/80 text-xs sm:text-sm line-clamp-3 mb-4 leading-relaxed font-normal">
							<?php the_excerpt(); ?>
						</div>
					</div>
					<div class="pt-4 border-t border-ink/15 flex items-center justify-between text-xs font-mono text-ink/60">
						<span><?php echo esc_html( get_the_date( 'M j, Y' ) ); ?></span>
						<a href="<?php the_permalink(); ?>" class="font-bold text-ink hover:text-cobalt">Read Entry →</a>
					</div>
				</article>
			<?php endwhile; ?>
		</div>

		<div class="pt-12">
			<?php agency_site_pagination(); ?>
		</div>
	<?php else : ?>
		<div class="border border-ink/20 p-12 text-center bg-ivory max-w-lg mx-auto">
			<h2 class="text-xl font-bold text-ink font-heading mb-2"><?php esc_html_e( 'No Results Found', 'agency-site' ); ?></h2>
			<p class="text-ink/70 text-sm mb-6"><?php esc_html_e( 'Try different keywords or browse our core services.', 'agency-site' ); ?></p>
			<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex gap-2">
				<input 
					type="search" 
					name="s" 
					placeholder="Search again..." 
					class="w-full px-3 py-2 bg-ivory border border-ink/20 text-ink text-xs focus:outline-none focus:border-cobalt font-mono"
				>
				<button type="submit" class="btn-primary !px-4 !py-2 text-xs uppercase font-mono">Search</button>
			</form>
		</div>
	<?php endif; ?>
</div>

<?php
get_footer();
