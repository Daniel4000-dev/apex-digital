<?php
/**
 * The template for displaying all single posts
 *
 * @package Agency_Site
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<!-- Article Header -->
	<header class="py-16 md:py-20 bg-gradient-to-b from-white via-agency-50/30 to-slate-50 border-b border-slate-200/60">
		<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
			
			<div class="flex items-center justify-center gap-3 text-xs mb-6">
				<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ) ); ?>" class="font-bold text-agency-600 hover:text-agency-700">
					← Back to Blog
				</a>
				<span class="text-slate-300">•</span>
				<?php
				$categories = get_the_category();
				if ( ! empty( $categories ) ) {
					echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '" class="font-semibold text-agency-700 bg-agency-100/80 px-3 py-0.5 rounded-full">' . esc_html( $categories[0]->name ) . '</a>';
				}
				?>
			</div>

			<h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight font-heading mb-6 leading-tight">
				<?php the_title(); ?>
			</h1>

			<div class="flex flex-wrap items-center justify-center gap-4 text-xs sm:text-sm text-slate-600">
				<div class="flex items-center gap-2">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 36, '', '', array( 'class' => 'rounded-full border border-slate-200' ) ); ?>
					<span class="font-bold text-slate-900"><?php the_author(); ?></span>
				</div>
				<span class="text-slate-300">•</span>
				<span><?php echo esc_html( get_the_date( 'F j, Y' ) ); ?></span>
				<span class="text-slate-300">•</span>
				<span class="inline-flex items-center gap-1">
					<svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
					<?php echo esc_html( agency_site_reading_time() ); ?> min read
				</span>
			</div>

		</div>
	</header>

	<!-- Main Content & Layout -->
	<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
		
		<!-- Featured Image -->
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="mb-12 rounded-3xl overflow-hidden shadow-soft border border-slate-200/80">
				<?php the_post_thumbnail( 'agency-hero', array( 'class' => 'w-full h-auto object-cover' ) ); ?>
				<?php if ( get_the_post_thumbnail_caption() ) : ?>
					<p class="text-xs text-center text-slate-500 py-2.5 bg-slate-50 border-t border-slate-100 italic">
						<?php the_post_thumbnail_caption(); ?>
					</p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<!-- Post Content with Rich Typography -->
		<div class="prose prose-lg prose-slate max-w-none prose-headings:font-heading prose-headings:font-bold prose-headings:text-slate-900 prose-a:text-agency-600 hover:prose-a:text-agency-700 prose-img:rounded-2xl prose-blockquote:border-agency-500 prose-blockquote:bg-agency-50/50 prose-blockquote:py-2 prose-blockquote:px-5 prose-blockquote:rounded-r-xl">
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

		<!-- Tags List -->
		<?php
		$post_tags = get_the_tags();
		if ( $post_tags ) :
			?>
			<div class="mt-10 pt-6 border-t border-slate-200 flex flex-wrap items-center gap-2">
				<span class="text-xs font-bold uppercase tracking-wider text-slate-400 mr-2">Tags:</span>
				<?php foreach ( $post_tags as $tag_item ) : ?>
					<a href="<?php echo esc_url( get_tag_link( $tag_item->term_id ) ); ?>" class="text-xs font-medium px-3 py-1 rounded-full bg-slate-100 text-slate-700 hover:bg-agency-50 hover:text-agency-600 transition-colors">
						#<?php echo esc_html( $tag_item->name ); ?>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<!-- Social Share Bar & Copy Link -->
		<div class="mt-8 p-6 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
			<span class="text-xs font-bold uppercase tracking-wider text-slate-600">Share This Strategy:</span>
			<div class="flex items-center gap-2">
				<a 
					href="https://twitter.com/intent/tweet?url=<?php echo rawurlencode( get_permalink() ); ?>&text=<?php echo rawurlencode( get_the_title() ); ?>" 
					target="_blank" 
					rel="noopener noreferrer" 
					class="px-3.5 py-1.5 rounded-lg bg-white border border-slate-200 text-xs font-semibold text-slate-700 hover:text-black hover:border-slate-300 transition-colors shadow-xs"
				>
					Twitter / X
				</a>
				<a 
					href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo rawurlencode( get_permalink() ); ?>" 
					target="_blank" 
					rel="noopener noreferrer" 
					class="px-3.5 py-1.5 rounded-lg bg-white border border-slate-200 text-xs font-semibold text-slate-700 hover:text-agency-700 hover:border-slate-300 transition-colors shadow-xs"
				>
					LinkedIn
				</a>
				<button 
					type="button" 
					id="copy-article-link" 
					data-url="<?php echo esc_url( get_permalink() ); ?>" 
					class="px-3.5 py-1.5 rounded-lg bg-agency-600 text-white text-xs font-semibold hover:bg-agency-700 transition-colors shadow-xs flex items-center gap-1.5 cursor-pointer"
				>
					<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
					<span>Copy Link</span>
				</button>
			</div>
		</div>

		<!-- Author Bio Box -->
		<div class="mt-12 p-8 rounded-3xl bg-white border border-slate-200/80 shadow-soft flex flex-col sm:flex-row items-center sm:items-start gap-6 text-center sm:text-left">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 72, '', '', array( 'class' => 'rounded-2xl border-2 border-slate-100 shrink-0' ) ); ?>
			<div class="space-y-2">
				<span class="text-[11px] font-bold uppercase tracking-wider text-agency-600 block">Written by</span>
				<h3 class="text-lg font-bold text-slate-900 font-heading"><?php the_author(); ?></h3>
				<p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
					<?php
					$author_desc = get_the_author_meta( 'description' );
					echo esc_html( $author_desc ?: 'Digital Strategist at ' . get_bloginfo( 'name' ) . ', writing about website development, technical search visibility, and conversion improvements.' );
					?>
				</p>
				<div class="pt-2">
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="text-xs font-bold text-agency-600 hover:text-agency-700">
						View all articles by <?php the_author(); ?> →
					</a>
				</div>
			</div>
		</div>

		<!-- Post Navigation (Previous / Next) -->
		<nav class="mt-12 pt-8 border-t border-slate-200 grid grid-cols-1 sm:grid-cols-2 gap-4">
			<?php
			$prev_post = get_previous_post();
			$next_post = get_next_post();
			?>
			<div>
				<?php if ( $prev_post ) : ?>
					<a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="block p-4 rounded-2xl bg-white border border-slate-200 hover:border-agency-300 transition-colors shadow-xs group">
						<span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">← Previous Article</span>
						<span class="text-sm font-bold text-slate-800 group-hover:text-agency-600 transition-colors line-clamp-1"><?php echo esc_html( get_the_title( $prev_post->ID ) ); ?></span>
					</a>
				<?php endif; ?>
			</div>
			<div class="text-right">
				<?php if ( $next_post ) : ?>
					<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="block p-4 rounded-2xl bg-white border border-slate-200 hover:border-agency-300 transition-colors shadow-xs group">
						<span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Next Article →</span>
						<span class="text-sm font-bold text-slate-800 group-hover:text-agency-600 transition-colors line-clamp-1"><?php echo esc_html( get_the_title( $next_post->ID ) ); ?></span>
					</a>
				<?php endif; ?>
			</div>
		</nav>

		<!-- Comments Section -->
		<?php
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
		?>

	</div>
</article>

	<?php
endwhile;

get_footer();

