<?php
/**
 * The template for displaying all single posts: Editorial Studio Aesthetic
 *
 * @package Agency_Site
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<!-- Article Header -->
	<header class="py-16 md:py-24 bg-ivory border-b border-ink/15">
		<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
			
			<div class="flex items-center justify-center gap-3 font-mono text-xs mb-6">
				<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ) ); ?>" class="font-bold text-ink hover:text-cobalt transition-colors">
					← <?php esc_html_e( 'Back to All Notes', 'agency-site' ); ?>
				</a>
				<span class="text-ink/30">/</span>
				<?php
				$categories = get_the_category();
				if ( ! empty( $categories ) ) {
					echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '" class="text-cobalt font-semibold">' . esc_html( $categories[0]->name ) . '</a>';
				}
				?>
			</div>

			<h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-ink tracking-tight font-heading mb-6 leading-tight">
				<?php the_title(); ?>
			</h1>

			<div class="flex flex-wrap items-center justify-center gap-4 font-mono text-xs text-ink/70">
				<span><?php the_author(); ?></span>
				<span class="text-ink/30">/</span>
				<span><?php echo esc_html( get_the_date( 'F j, Y' ) ); ?></span>
				<span class="text-ink/30">/</span>
				<span><?php echo esc_html( agency_site_reading_time() ); ?> min read</span>
			</div>

		</div>
	</header>

	<!-- Main Content & Layout -->
	<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
		
		<!-- Featured Image -->
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="mb-12 border border-ink/20 overflow-hidden">
				<?php the_post_thumbnail( 'agency-hero', array( 'class' => 'w-full h-auto object-cover' ) ); ?>
				<?php if ( get_the_post_thumbnail_caption() ) : ?>
					<p class="text-xs text-center text-ink/60 py-2.5 bg-ivory border-t border-ink/15 font-mono italic">
						<?php the_post_thumbnail_caption(); ?>
					</p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<!-- Post Content with Rich Typography -->
		<div class="prose prose-lg max-w-none text-ink prose-headings:font-heading prose-headings:font-bold prose-headings:text-ink prose-p:text-ink/80 prose-p:leading-relaxed prose-a:text-cobalt prose-blockquote:border-cobalt prose-blockquote:bg-ink/5 prose-blockquote:py-2 prose-blockquote:px-5 prose-blockquote:rounded-none prose-img:border prose-img:border-ink/15">
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

		<!-- Tags List -->
		<?php
		$post_tags = get_the_tags();
		if ( $post_tags ) :
			?>
			<div class="mt-10 pt-6 border-t border-ink/15 flex flex-wrap items-center gap-2">
				<span class="font-mono text-xs uppercase tracking-wider text-ink/60 mr-2">Tags:</span>
				<?php foreach ( $post_tags as $tag_item ) : ?>
					<a href="<?php echo esc_url( get_tag_link( $tag_item->term_id ) ); ?>" class="editorial-tag !text-[11px] hover:border-cobalt hover:text-cobalt transition-colors">
						#<?php echo esc_html( $tag_item->name ); ?>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<!-- Share Bar & Copy Link -->
		<div class="mt-8 p-6 border border-ink/20 bg-ivory flex flex-col sm:flex-row items-center justify-between gap-4 font-mono text-xs">
			<span class="uppercase tracking-wider text-ink/60"><?php esc_html_e( 'Share Strategy Note:', 'agency-site' ); ?></span>
			<button 
				type="button" 
				id="copy-article-link" 
				data-url="<?php the_permalink(); ?>" 
				class="inline-flex items-center gap-2 px-4 py-2 border border-ink/20 hover:border-cobalt hover:text-cobalt transition-colors cursor-pointer"
			>
				<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
				<span><?php esc_html_e( 'Copy Link', 'agency-site' ); ?></span>
			</button>
		</div>

		<!-- Author Box -->
		<div class="mt-12 p-8 border border-ink/20 bg-ivory flex items-center gap-6">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 64, '', '', array( 'class' => 'border border-ink/20 shrink-0' ) ); ?>
			<div>
				<span class="font-mono text-xs uppercase tracking-widest text-cobalt block mb-1">WRITTEN BY</span>
				<h3 class="text-lg font-bold text-ink font-heading"><?php the_author(); ?></h3>
				<p class="text-xs sm:text-sm text-ink/80 mt-1 leading-relaxed">
					<?php echo esc_html( get_the_author_meta( 'description' ) ?: __( 'Growth and WordPress technical architect at Apex Digital, specializing in scalable web systems and commercial search visibility.', 'agency-site' ) ); ?>
				</p>
			</div>
		</div>

		<!-- Post Navigation -->
		<nav class="mt-12 pt-8 border-t border-ink/15 grid grid-cols-1 sm:grid-cols-2 gap-6 font-mono text-xs">
			<div>
				<?php
				$prev_post = get_previous_post();
				if ( $prev_post ) :
					?>
					<span class="text-ink/40 block mb-1">← PREVIOUS NOTE</span>
					<a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="font-bold text-ink hover:text-cobalt transition-colors font-sans text-base">
						<?php echo esc_html( get_the_title( $prev_post->ID ) ); ?>
					</a>
				<?php endif; ?>
			</div>
			<div class="text-left sm:text-right">
				<?php
				$next_post = get_next_post();
				if ( $next_post ) :
					?>
					<span class="text-ink/40 block mb-1">NEXT NOTE →</span>
					<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="font-bold text-ink hover:text-cobalt transition-colors font-sans text-base">
						<?php echo esc_html( get_the_title( $next_post->ID ) ); ?>
					</a>
				<?php endif; ?>
			</div>
		</nav>

		<!-- Comments Area -->
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
