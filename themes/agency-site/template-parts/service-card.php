<?php
/**
 * Template part for displaying a service card: Editorial Studio Aesthetic
 *
 * @package Agency_Site
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$service_title = $args['title'] ?? get_the_title();
$tagline       = $args['tagline'] ?? get_post_meta( get_the_ID(), '_agency_service_tagline', true );
$desc          = $args['desc'] ?? get_the_excerpt();
$price         = $args['price'] ?? get_post_meta( get_the_ID(), '_agency_service_price', true );
$badge         = $args['badge'] ?? get_post_meta( get_the_ID(), '_agency_service_badge', true );
$icon          = $args['icon'] ?? get_post_meta( get_the_ID(), '_agency_service_icon', true ) ?: 'chart';
$deliverables  = $args['deliverables'] ?? array();
$service_link  = $args['link'] ?? ( get_post_type() === 'agency_service' ? get_permalink() : home_url( '/services/' ) );

if ( empty( $deliverables ) && get_the_ID() ) {
	$raw_deliv = get_post_meta( get_the_ID(), '_agency_service_deliverables', true );
	if ( ! empty( $raw_deliv ) ) {
		$deliverables = array_filter( array_map( 'trim', explode( "\n", $raw_deliv ) ) );
	}
}

if ( trim( (string) $desc ) === trim( (string) $tagline ) ) {
	$content = get_the_content();
	$desc    = ! empty( $content ) ? wp_trim_words( wp_strip_all_tags( $content ), 26 ) : '';
}
?>
<div class="h-full bg-ivory border border-ink/20 p-8 flex flex-col justify-between group transition-colors duration-200 hover:border-cobalt relative">
	<?php if ( ! empty( $badge ) ) : ?>
		<div class="absolute top-6 right-6">
			<span class="editorial-tag !text-[10px]">
				<?php echo esc_html( $badge ); ?>
			</span>
		</div>
	<?php endif; ?>

	<div>
		<div class="w-12 h-12 border border-ink/20 bg-ivory text-ink flex items-center justify-center mb-6 group-hover:bg-cobalt group-hover:text-white group-hover:border-cobalt transition-colors duration-200">
			<?php echo agency_site_get_icon( $icon, 'w-6 h-6' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>

		<h3 class="text-2xl font-bold text-ink mb-2 font-heading">
			<a href="<?php echo esc_url( $service_link ); ?>" class="hover:text-cobalt transition-colors">
				<?php echo esc_html( $service_title ); ?>
			</a>
		</h3>

		<?php if ( ! empty( $tagline ) ) : ?>
			<p class="text-xs font-mono text-cobalt font-medium mb-3"><?php echo esc_html( $tagline ); ?></p>
		<?php endif; ?>

		<div class="text-ink/80 text-sm leading-relaxed mb-6 font-normal">
			<?php echo wp_kses_post( wpautop( $desc ) ); ?>
		</div>

		<?php if ( ! empty( $deliverables ) ) : ?>
			<div class="border-t border-ink/15 pt-5 mb-6 space-y-2">
				<?php foreach ( array_slice( $deliverables, 0, 3 ) as $deliverable ) : ?>
					<div class="flex items-start gap-2 text-xs text-ink/70 font-mono">
						<span class="text-cobalt font-bold">+</span>
						<span><?php echo esc_html( $deliverable ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>

	<div class="pt-4 border-t border-ink/15 flex items-center justify-between font-mono text-xs">
		<span class="text-ink/60"><?php echo esc_html( $price ?: __( 'Custom Scope', 'agency-site' ) ); ?></span>
		<a href="<?php echo esc_url( $service_link ); ?>" class="font-bold text-ink group-hover:text-cobalt inline-flex items-center gap-1 transition-colors">
			<span>Scope & Details</span>
			<svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
		</a>
	</div>
</div>
