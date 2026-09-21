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
<body <?php body_class( 'min-h-screen flex flex-col bg-slate-50 text-slate-800 antialiased selection:bg-agency-500 selection:text-white' ); ?>>
<?php wp_body_open(); ?>

<!-- Accessible Skip Link -->
<a class="screen-reader-text" href="#main-content">
	<?php esc_html_e( 'Skip to main content', 'agency-site' ); ?>
</a>

<!-- Primary Sticky Header -->
<header id="masthead" class="agency-header sticky top-0 z-50 transition-all duration-300 bg-white/95 backdrop-blur-md border-b border-slate-200/80">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="flex items-center justify-between h-16 sm:h-20">
			
			<!-- Site Brand / Logo -->
			<div class="flex items-center gap-3 min-w-0">
				<?php if ( has_custom_logo() ) : ?>
					<div class="site-logo">
						<?php the_custom_logo(); ?>
					</div>
				<?php else : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="group flex items-center gap-2 sm:gap-2.5 min-w-0" rel="home">
						<span class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-tr from-agency-600 to-accent-600 flex items-center justify-center text-white font-bold text-base sm:text-xl shadow-md group-hover:scale-105 transition-transform duration-200 shrink-0">
							A
						</span>
						<div class="min-w-0">
							<span class="font-heading font-extrabold text-base sm:text-xl text-slate-900 tracking-tight block group-hover:text-agency-600 transition-colors truncate">
								<?php bloginfo( 'name' ); ?>
							</span>
							<span class="text-[9px] sm:text-[10px] uppercase tracking-wider font-semibold text-slate-400 block -mt-1 truncate">
								<?php echo esc_html( get_bloginfo( 'description' ) ?: 'Digital Marketing & Web Design' ); ?>
							</span>
						</div>
					</a>
				<?php endif; ?>
			</div>

			<!-- Desktop Navigation -->
			<nav id="site-navigation" class="hidden lg:flex items-center gap-6" aria-label="<?php esc_attr_e( 'Primary Navigation', 'agency-site' ); ?>">
				<?php
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_id'        => 'primary-menu',
							'container'      => false,
							'menu_class'     => 'flex items-center gap-1 xl:gap-2 text-sm font-medium text-slate-700',
							'depth'          => 2,
						)
					);
				} else {
					agency_site_fallback_menu();
				}
				?>
			</nav>

			<!-- Header Action CTA & Mobile Hamburger -->
			<div class="flex items-center gap-2 sm:gap-3 shrink-0">
				<a href="<?php echo esc_url( get_theme_mod( 'agency_header_cta_link', home_url( '/contact/' ) ) ); ?>" class="hidden sm:inline-flex btn-primary !py-2.5 !px-5 text-sm">
					<span><?php echo esc_html( get_theme_mod( 'agency_header_cta_text', __( 'Discuss your project', 'agency-site' ) ) ); ?></span>
					<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
				</a>

				<!-- Mobile Menu Button -->
				<button 
					id="mobile-menu-toggle" 
					type="button" 
					class="lg:hidden p-2.5 rounded-xl text-slate-700 hover:text-slate-900 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-agency-500" 
					aria-controls="mobile-menu-drawer" 
					aria-expanded="false" 
					aria-label="<?php esc_attr_e( 'Toggle mobile navigation menu', 'agency-site' ); ?>"
				>
					<!-- Open Icon (Hamburger) -->
					<svg id="hamburger-icon-open" class="w-6 h-6 block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
					</svg>
					<!-- Close Icon (X) -->
					<svg id="hamburger-icon-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
					</svg>
				</button>
			</div>

		</div>
	</div>

	<!-- Mobile Navigation Drawer Overlay -->
	<div id="mobile-menu-drawer" class="lg:hidden fixed inset-x-0 top-full bg-white border-b border-slate-200 shadow-2xl transition-all duration-300 ease-in-out opacity-0 pointer-events-none -translate-y-2" aria-hidden="true">
		<div class="px-6 py-6 space-y-6 max-h-[85vh] overflow-y-auto">
			<nav aria-label="<?php esc_attr_e( 'Mobile Navigation', 'agency-site' ); ?>">
				<?php
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_id'        => 'mobile-menu-list',
							'container'      => false,
							'menu_class'     => 'flex flex-col space-y-2 text-base font-medium text-slate-800',
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
					echo '<ul class="flex flex-col space-y-2 text-base font-medium text-slate-800">';
					foreach ( $items as $item ) {
						echo '<li><a href="' . esc_url( $item['url'] ) . '" class="block px-4 py-2.5 rounded-lg text-slate-800 hover:text-agency-600 hover:bg-slate-50 transition-colors font-semibold">' . esc_html( $item['title'] ) . '</a></li>';
					}
					echo '</ul>';
				}
				?>
			</nav>

			<div class="pt-4 border-t border-slate-100 flex flex-col gap-3">
				<a href="<?php echo esc_url( get_theme_mod( 'agency_header_cta_link', home_url( '/contact/' ) ) ); ?>" class="btn-primary w-full text-center !py-3">
					<?php echo esc_html( get_theme_mod( 'agency_header_cta_text', __( 'Discuss your project', 'agency-site' ) ) ); ?>
				</a>
				<div class="text-center text-xs text-slate-500 pt-1">
					<p>Project Inquiries: <a href="mailto:<?php echo esc_attr( get_theme_mod( 'agency_email', 'growth@apexagency.digital' ) ); ?>" class="text-agency-600 font-medium"><?php echo esc_html( get_theme_mod( 'agency_email', 'growth@apexagency.digital' ) ); ?></a></p>
				</div>
			</div>
		</div>
	</div>
</header>

<main id="main-content" class="flex-grow">

