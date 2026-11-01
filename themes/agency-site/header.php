<?php
/**
 * Theme Header
 *
 * @package Agency_Site
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'min-h-screen flex flex-col bg-ivory text-ink antialiased selection:bg-cobalt selection:text-white' ); ?>>
<?php wp_body_open(); ?>

<!-- Page Scroll Progress Indicator -->
<div id="page-scroll-progress" aria-hidden="true"></div>

<!-- Accessible Skip Link -->
<a class="screen-reader-text" href="#main-content">
	<?php esc_html_e( 'Skip to main content', 'agency-site' ); ?>
</a>

<!-- Primary Sticky Header: Editorial Studio Aesthetic -->
<header id="masthead" class="agency-header sticky top-0 z-50 transition-all duration-200 bg-ivory/95 backdrop-blur-md border-b border-ink/15">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="flex items-center justify-between h-16 sm:h-20">
			
			<!-- Site Brand / Logo -->
			<div class="flex items-center gap-3 min-w-0">
				<?php if ( has_custom_logo() ) : ?>
					<div class="site-logo">
						<?php the_custom_logo(); ?>
					</div>
				<?php else : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="group flex items-center gap-2.5 sm:gap-3 min-w-0" rel="home">
						<?php agency_site_brand_mark( 'header', 'w-8 h-8 sm:w-9 sm:h-9 shrink-0 transition-transform duration-200 group-hover:scale-95' ); ?>
						<div class="min-w-0 flex items-baseline gap-2">
							<span class="font-heading font-extrabold text-base sm:text-xl text-ink tracking-tight block group-hover:text-cobalt transition-colors truncate">
								<?php bloginfo( 'name' ); ?>
							</span>
							<span class="hidden md:inline-block text-[10px] uppercase font-mono tracking-widest text-ink/50 shrink-0">
								<?php esc_html_e( 'Studio', 'agency-site' ); ?>
							</span>
						</div>
					</a>
				<?php endif; ?>
			</div>

			<!-- Desktop Navigation -->
			<nav id="site-navigation" class="hidden lg:flex items-center gap-8" aria-label="<?php esc_attr_e( 'Primary Navigation', 'agency-site' ); ?>">
				<?php
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_id'        => 'primary-menu',
							'container'      => false,
							'menu_class'     => 'flex items-center gap-6 xl:gap-8 text-sm font-medium text-ink hover:text-cobalt',
							'depth'          => 2,
						)
					);
				} else {
					agency_site_fallback_menu();
				}
				?>
			</nav>

			<!-- Header Action CTA & Mobile Hamburger -->
			<div class="flex items-center gap-3 shrink-0">
				<a href="<?php echo esc_url( get_theme_mod( 'agency_header_cta_link', home_url( '/contact/' ) ) ); ?>" class="hidden sm:inline-flex btn-primary !py-2.5 !px-5 text-xs uppercase tracking-wider font-semibold">
					<span><?php echo esc_html( get_theme_mod( 'agency_header_cta_text', __( 'Discuss your project', 'agency-site' ) ) ); ?></span>
					<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
				</a>

				<!-- Mobile Menu Button -->
				<button 
					id="mobile-menu-toggle" 
					type="button" 
					class="lg:hidden p-2.5 text-ink hover:text-cobalt border border-ink/20 focus:outline-none focus:ring-2 focus:ring-cobalt" 
					aria-controls="mobile-menu-drawer" 
					aria-expanded="false" 
					aria-label="<?php esc_attr_e( 'Toggle mobile navigation menu', 'agency-site' ); ?>"
				>
					<!-- Open Icon (Hamburger) -->
					<svg id="hamburger-icon-open" class="w-5 h-5 block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
					</svg>
					<!-- Close Icon (X) -->
					<svg id="hamburger-icon-close" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
					</svg>
				</button>
			</div>

		</div>
	</div>

	<!-- Mobile Navigation Drawer Overlay -->
	<div id="mobile-menu-drawer" class="lg:hidden fixed inset-x-0 top-full bg-ivory border-b border-ink/20 shadow-xl transition-all duration-300 ease-in-out opacity-0 pointer-events-none -translate-y-2" aria-hidden="true">
		<div class="px-6 py-6 space-y-6 max-h-[85vh] overflow-y-auto">
			<nav aria-label="<?php esc_attr_e( 'Mobile Navigation', 'agency-site' ); ?>">
				<?php
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_id'        => 'mobile-menu-list',
							'container'      => false,
							'menu_class'     => 'flex flex-col space-y-2 text-base font-medium text-ink',
							'depth'          => 1,
						)
					);
				} else {
					$items = array(
						array(
							'url'   => home_url( '/' ),
							'title' => __( 'Home', 'agency-site' ),
						),
						array(
							'url'   => home_url( '/services/' ),
							'title' => __( 'Services', 'agency-site' ),
						),
						array(
							'url'   => home_url( '/blog/' ),
							'title' => __( 'Blog & Insights', 'agency-site' ),
						),
						array(
							'url'   => home_url( '/contact/' ),
							'title' => __( 'Contact', 'agency-site' ),
						),
					);
					echo '<ul class="flex flex-col space-y-2 text-base font-medium text-ink">';
					foreach ( $items as $item ) {
						echo '<li><a href="' . esc_url( $item['url'] ) . '" class="block px-4 py-2.5 text-ink hover:text-cobalt border-b border-ink/10 font-semibold">' . esc_html( $item['title'] ) . '</a></li>';
					}
					echo '</ul>';
				}
				?>
			</nav>

			<div class="pt-4 border-t border-ink/15 flex flex-col gap-3">
				<a href="<?php echo esc_url( get_theme_mod( 'agency_header_cta_link', home_url( '/contact/' ) ) ); ?>" class="btn-primary w-full text-center !py-3">
					<?php echo esc_html( get_theme_mod( 'agency_header_cta_text', __( 'Discuss your project', 'agency-site' ) ) ); ?>
				</a>
				<div class="text-center text-xs text-ink/70 pt-1">
					<p><?php esc_html_e( 'Direct Inquiries:', 'agency-site' ); ?> <a href="mailto:<?php echo esc_attr( get_theme_mod( 'agency_email', 'growth@apexagency.digital' ) ); ?>" class="text-cobalt font-medium underline"><?php echo esc_html( get_theme_mod( 'agency_email', 'growth@apexagency.digital' ) ); ?></a></p>
				</div>
			</div>
		</div>
	</div>
</header>

<main id="main-content" class="flex-grow">

