<?php
/**
 * The Blog Listing Template: Editorial Studio Aesthetic
 *
 * @package Agency_Site
 */

get_header();
?>

<!-- Blog Hero -->
<section class="py-16 md:py-24 border-b border-ink/15 bg-ivory">
	<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
		<span class="font-mono text-xs uppercase tracking-widest text-ink/60 block mb-3">01 / EDITORIAL GUIDES</span>
		<h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-ink tracking-tight font-heading mb-6 leading-tight">
			Insights, Guides & <span class="font-serif italic font-normal text-cobalt">Technical Strategies</span>
		</h1>
		<p class="text-lg sm:text-xl text-ink/80 max-w-2xl mx-auto font-normal leading-relaxed">
			<?php esc_html_e( 'Practical guides, technical SEO teardowns, and actionable advice to help your business get found and turn visitors into enquiries.', 'agency-site' ); ?>
		</p>

		<!-- Category Filter Tags -->
		<?php
		$categories = get_categories( array( 'hide_empty' => true ) );
		if ( ! empty( $categories ) ) :
			?>
			<div class="mt-8 flex flex-wrap items-center justify-center gap-2">
				<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ) ); ?>" class="editorial-tag !border-cobalt !bg-cobalt !text-white">
					All Notes
				</a>
				<?php foreach ( $categories as $category_item ) : ?>
					<a href="<?php echo esc_url( get_category_link( $category_item->term_id ) ); ?>" class="editorial-tag hover:border-cobalt hover:text-cobalt transition-colors">
						<?php echo esc_html( $category_item->name ); ?> (<?php echo esc_html( $category_item->count ); ?>)
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<!-- Blog Content Grid -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
	<div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
		
		<!-- Main Articles Column (8 cols) -->
		<div class="lg:col-span-8 space-y-12">
			
			<?php
			if ( have_posts() ) :
				$post_count = 0;
				while ( have_posts() ) :
					the_post();
					++$post_count;

					// Featured Highlight for first post on page 1
					if ( 1 === $post_count && ! is_paged() ) :
						?>
				<article class="bg-ivory border border-ink/20 p-8 sm:p-10 transition-colors duration-200 hover:border-cobalt group">
						<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" class="block aspect-[21/9] overflow-hidden border border-ink/15 mb-6">
							<?php the_post_thumbnail( 'agency-hero', array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300' ) ); ?>
						</a>
					<?php else : ?>
						<a href="<?php the_permalink(); ?>" class="block aspect-[21/9] bg-ink/5 border border-ink/15 p-6 mb-6 flex flex-col justify-between group-hover:bg-cobalt/5 transition-colors">
							<div class="flex items-center justify-between font-mono text-xs text-ink/60 uppercase">
								<span>FEATURED DEEP DIVE</span>
								<span class="w-2 h-2 bg-cobalt"></span>
							</div>
							<div class="font-mono text-xs text-ink/40 uppercase tracking-widest">
								APEX DIGITAL · TECHNICAL EDITORIAL
							</div>
						</a>
					<?php endif; ?>

					<div class="flex items-center gap-3 font-mono text-xs text-ink/60 mb-4">
						<?php
						$cats = get_the_category();
						if ( ! empty( $cats ) ) {
							echo '<span class="text-cobalt font-semibold uppercase">' . esc_html( $cats[0]->name ) . '</span>';
							echo '<span>/</span>';
						}
						?>
						<span><?php echo esc_html( get_the_date( 'F j, Y' ) ); ?></span>
						<span>/</span>
						<span><?php echo esc_html( agency_site_reading_time() ); ?> min read</span>
					</div>

					<h2 class="text-2xl sm:text-3xl font-extrabold text-ink font-heading mb-4 leading-tight group-hover:text-cobalt transition-colors">
						<a href="<?php the_permalink(); ?>">
							<?php the_title(); ?>
						</a>
					</h2>

					<div class="text-ink/80 text-base leading-relaxed mb-6 font-normal">
						<?php the_excerpt(); ?>
					</div>

					<div class="pt-6 border-t border-ink/15 flex items-center justify-between font-mono text-xs">
						<span class="text-ink/60"><?php the_author(); ?></span>
						<a href="<?php the_permalink(); ?>" class="font-bold text-ink group-hover:text-cobalt inline-flex items-center gap-1 transition-colors">
							<span>Read Full Breakdown</span>
							<svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
						</a>
					</div>
				</article>

				<div class="grid grid-cols-1 sm:grid-cols-2 gap-8 pt-4">
						<?php
						continue;
					endif;

					if ( 1 === $post_count && is_paged() ) {
						echo '<div class="grid grid-cols-1 sm:grid-cols-2 gap-8">';
					}

					get_template_part( 'template-parts/post-card' );

				endwhile;

				if ( $post_count > 1 || is_paged() ) {
					echo '</div>';
				}
				?>

				<!-- Pagination -->
				<div class="pt-8">
					<?php agency_site_pagination(); ?>
				</div>

				<?php
			else :
				?>
				<div class="bg-ivory border border-ink/20 p-12 text-center">
					<h3 class="text-xl font-bold text-ink font-heading mb-2"><?php esc_html_e( 'No Articles Published Yet', 'agency-site' ); ?></h3>
					<p class="text-ink/70 text-sm mb-6"><?php esc_html_e( 'Our editorial team is preparing new technical notes. Explore our capabilities in the meantime.', 'agency-site' ); ?></p>
					<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="btn-primary"><?php esc_html_e( 'Explore Services', 'agency-site' ); ?></a>
				</div>
				<?php
			endif;
			?>

		</div>

		<!-- Sidebar Column (4 cols) -->
		<aside class="lg:col-span-4 space-y-8">
			
			<!-- Custom Search Widget -->
			<div class="border border-ink/20 p-6 bg-ivory">
				<h3 class="font-mono text-xs uppercase tracking-widest text-ink/60 mb-4"><?php esc_html_e( 'Search Insights', 'agency-site' ); ?></h3>
				<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex gap-2">
					<input 
						type="search" 
						name="s" 
						value="<?php echo esc_attr( get_search_query() ); ?>" 
						placeholder="Search growth topics..." 
						class="w-full px-3 py-2 bg-ivory border border-ink/20 text-ink text-sm focus:outline-none focus:border-cobalt"
					>
					<button type="submit" class="btn-primary !px-4 !py-2 text-xs uppercase" aria-label="<?php esc_attr_e( 'Search', 'agency-site' ); ?>">
						<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
					</button>
				</form>
			</div>

			<!-- Dynamic Sidebar Widgets -->
			<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
				<?php dynamic_sidebar( 'sidebar-1' ); ?>
			<?php endif; ?>

			<!-- Studio Newsletter / Consultation Invitation -->
			<div class="border border-ink/20 p-6 bg-ivory space-y-4">
				<span class="font-mono text-xs uppercase tracking-widest text-cobalt font-bold block">DIRECT ACCESS</span>
				<h3 class="text-lg font-bold text-ink font-heading"><?php esc_html_e( 'Have a specific project in mind?', 'agency-site' ); ?></h3>
				<p class="text-xs sm:text-sm text-ink/80 leading-relaxed font-normal">
					<?php esc_html_e( 'We provide upfront technical reviews of existing WordPress codebases and search positioning.', 'agency-site' ); ?>
				</p>
				<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn-primary w-full text-center !py-3 text-xs uppercase tracking-wider font-semibold">
					<?php esc_html_e( 'Discuss your project', 'agency-site' ); ?>
				</a>
			</div>

		</aside>

	</div>
</div>

<?php
get_footer();
