<?php
/**
 * The template for displaying comments
 *
 * @package Agency_Site
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area mt-16 pt-12 border-t border-slate-200">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title text-2xl font-bold text-slate-900 font-heading mb-8">
			<?php
			$comment_count = get_comments_number();
			if ( '1' === $comment_count ) {
				/* translators: %1$s: post title */
				printf( esc_html__( 'One comment on &ldquo;%1$s&rdquo;', 'agency-site' ), '<span>' . wp_kses_post( get_the_title() ) . '</span>' );
			} else {
				printf(
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'agency-site' ) ),
					esc_html( number_format_i18n( $comment_count ) ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			}
			?>
		</h2>

		<ol class="comment-list space-y-6 mb-12">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 48,
					'callback'    => function ( $comment, $args, $depth ) {
						$GLOBALS['comment'] = $comment; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
						?>
					<li id="comment-<?php comment_ID(); ?>" <?php comment_class( 'p-6 rounded-2xl bg-slate-50 border border-slate-200' ); ?>>
						<div class="flex items-start gap-4">
							<?php
							if ( 0 !== (int) $args['avatar_size'] ) {
								echo get_avatar( $comment, $args['avatar_size'], '', '', array( 'class' => 'rounded-full border border-slate-200' ) );
							}
							?>
							<div class="flex-grow">
								<div class="flex items-center justify-between mb-2">
									<h3 class="text-sm font-bold text-slate-900 font-heading"><?php comment_author(); ?></h3>
									<time class="text-xs text-slate-400" datetime="<?php comment_time( 'c' ); ?>">
										<?php
										/* translators: 1: date, 2: time */
										printf( esc_html__( '%1$s at %2$s', 'agency-site' ), esc_html( get_comment_date() ), esc_html( get_comment_time() ) );
										?>
									</time>
								</div>
								<?php if ( '0' === (string) $comment->comment_approved ) : ?>
									<p class="text-xs text-amber-600 italic mb-2">Your comment is awaiting moderation.</p>
								<?php endif; ?>
								<div class="text-slate-700 text-sm leading-relaxed mb-3">
									<?php comment_text(); ?>
								</div>
								<div class="text-xs font-semibold text-agency-600">
									<?php
									comment_reply_link(
										array_merge(
											$args,
											array(
												'depth' => $depth,
												'max_depth' => $args['max_depth'],
											)
										)
									);
									?>
								</div>
							</div>
						</div>
					</li>
						<?php
					},
				)
			);
		?>
		</ol>

		<?php the_comments_navigation(); ?>

	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments text-xs text-slate-400 italic">Comments are closed.</p>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'class_form'         => 'bg-white p-8 rounded-3xl border border-slate-200 shadow-soft space-y-4',
			'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title text-xl font-bold text-slate-900 font-heading mb-2">',
			'title_reply_after'  => '</h3>',
			'class_submit'       => 'btn-primary !py-3 !px-6 text-sm cursor-pointer',
			'comment_field'      => '<div class="comment-form-comment mb-4"><label for="comment" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">' . _x( 'Comment', 'noun', 'agency-site' ) . '</label><textarea id="comment" name="comment" cols="45" rows="4" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-agency-500"></textarea></div>',
			'fields'             => array(
				'author' => '<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4"><div><label for="author" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">' . __( 'Name', 'agency-site' ) . ' <span class="text-red-500">*</span></label><input id="author" name="author" type="text" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-agency-500"></div>',
				'email'  => '<div><label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">' . __( 'Email', 'agency-site' ) . ' <span class="text-red-500">*</span></label><input id="email" name="email" type="email" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-agency-500"></div></div>',
			),
		)
	);
	?>

</div>

