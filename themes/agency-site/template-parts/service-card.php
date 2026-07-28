<?php
/**
 * Template part for displaying a service card
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
?>
<div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-soft card-hover flex flex-col justify-between relative group">
	<?php if ( ! empty( $badge ) ) : ?>
		<div class="absolute top-6 right-6">
			<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-agency-50 text-agency-700 border border-agency-200">
				<?php echo esc_html( $badge ); ?>
			</span>
		</div>
	<?php endif; ?>

	<div>
		<div class="w-14 h-14 rounded-2xl bg-agency-50 text-agency-600 flex items-center justify-center mb-6 group-hover:bg-agency-600 group-hover:text-white transition-all duration-300 shadow-sm">
			<?php echo agency_site_get_icon( $icon, 'w-7 h-7' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>

		<h3 class="text-xl font-bold text-slate-900 mb-2 font-heading">
			<a href="<?php echo esc_url( $service_link ); ?>" class="hover:text-agency-600 transition-colors">
				<?php echo esc_html( $service_title ); ?>
			</a>
		</h3>

		<?php if ( ! empty( $tagline ) ) : ?>
			<p class="text-xs font-semibold text-agency-600 mb-3"><?php echo esc_html( $tagline ); ?></p>
		<?php endif; ?>

		<div class="text-slate-600 text-sm leading-relaxed mb-6">
			<?php echo wp_kses_post( wpautop( $desc ) ); ?>
		</div>

		<?php if ( ! empty( $deliverables ) ) : ?>
			<div class="border-t border-slate-100 pt-5 mb-6 space-y-2.5">
				<?php foreach ( array_slice( $deliverables, 0, 3 ) as $deliverable ) : ?>
					<div class="flex items-start gap-2.5 text-xs text-slate-600">
						<svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
						<span><?php echo esc_html( $deliverable ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>

	<div class="pt-4 border-t border-slate-100 flex items-center justify-between">
		<span class="text-xs font-bold text-slate-500"><?php echo esc_html( $price ?: __( 'Custom Retainer', 'agency-site' ) ); ?></span>
		<a href="<?php echo esc_url( $service_link ); ?>" class="inline-flex items-center gap-1.5 text-xs font-bold text-agency-600 hover:text-agency-700 transition-colors group-hover:translate-x-1 duration-200">
			<span>Learn More</span>
			<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
		</a>
	</div>
</div>

