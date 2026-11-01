<?php
/**
 * Custom template tags and SVG icon helpers
 *
 * @package Agency_Site
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Estimated reading time in minutes
 */
function agency_site_reading_time( $content = null ) {
	if ( ! $content ) {
		$content = get_post_field( 'post_content', get_the_ID() );
	}
	$word_count   = str_word_count( wp_strip_all_tags( $content ) );
	$reading_time = ceil( $word_count / 200 );
	return max( 1, $reading_time );
}

/**
 * Post publication date with icon
 */
function agency_site_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	}

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() )
	);

	echo '<span class="posted-on inline-flex items-center gap-1.5 text-slate-500 text-xs font-medium">' .
		'<svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>' .
		wp_kses_post( $time_string ) . '</span>';
}

/**
 * SVG icons helper
 */
function agency_site_get_icon( $icon, $css_class = 'w-6 h-6' ) {
	switch ( $icon ) {
		case 'chart':
			return '<svg class="' . esc_attr( $css_class ) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>';
		case 'bullhorn':
			return '<svg class="' . esc_attr( $css_class ) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>';
		case 'cursor':
			return '<svg class="' . esc_attr( $css_class ) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>';
		case 'lightning':
			return '<svg class="' . esc_attr( $class ) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>';
		case 'content':
			return '<svg class="' . esc_attr( $class ) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>';
		case 'code':
			return '<svg class="' . esc_attr( $class ) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>';
		case 'check':
			return '<svg class="' . esc_attr( $class ) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
		case 'arrow-right':
			return '<svg class="' . esc_attr( $class ) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>';
		case 'star':
			return '<svg class="' . esc_attr( $class ) . '" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>';
		default:
			return '<svg class="' . esc_attr( $class ) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>';
	}
}

/**
 * Fallback services array when no CPT items exist yet
 */
function agency_site_get_default_services() {
	return array(
		array(
			'title'        => 'Search Engine Optimization (SEO)',
			'tagline'      => 'Technical SEO & Organic Visibility',
			'desc'         => 'We combine technical audits, site architecture improvements, and topical content mapping to help high-intent buyers discover your services in organic search.',
			'icon'         => 'chart',
			'price'        => 'Tailored Scope',
			'badge'        => 'Organic Search',
			'deliverables' => array(
				'Technical architecture & Core Web Vitals audit',
				'Topical cluster mapping & keyword intent research',
				'Internal linking & structured data schema',
				'Search Console monitoring & performance reporting',
			),
		),
		array(
			'title'        => 'Paid Media & Performance Ads',
			'tagline'      => 'Search & Social Campaign Management',
			'desc'         => 'Strategic ad campaign management across Google Search and paid social channels designed to generate qualified business enquiries with controlled acquisition costs.',
			'icon'         => 'bullhorn',
			'price'        => 'Tailored Scope',
			'badge'        => 'Targeted Media',
			'deliverables' => array(
				'Search intent keyword structuring & negative targeting',
				'Ad creative & conversion-focused copywriting',
				'Landing page message alignment & friction audit',
				'Weekly bid management & conversion tracking audit',
			),
		),
		array(
			'title'        => 'Conversion Rate Optimization (CRO)',
			'tagline'      => 'User Experience & Conversion Refinement',
			'desc'         => 'Identifying user experience friction and optimizing layout structure, enquiry forms, and key calls-to-action to convert existing website traffic into business enquiries.',
			'icon'         => 'cursor',
			'price'        => 'Tailored Scope',
			'badge'        => 'High Impact',
			'deliverables' => array(
				'Visitor journey evaluation & drop-off analysis',
				'Enquiry form usability & field reduction review',
				'Split testing of headlines and call-to-action placement',
				'Monthly user experience and conversion recommendations',
			),
		),
		array(
			'title'        => 'Content Marketing & Search Authority',
			'tagline'      => 'Educational Editorial & Topic Authority',
			'desc'         => 'Clear, educational content creation designed to explain complex services, answer prospective client questions, and build lasting organic credibility.',
			'icon'         => 'content',
			'price'        => 'Tailored Scope',
			'badge'        => 'Long-Term Asset',
			'deliverables' => array(
				'Topical content planning & audience intent mapping',
				'In-depth service guides & technical teardowns',
				'Editorial review & on-page SEO optimization',
				'Distribution & internal cross-linking workflows',
			),
		),
		array(
			'title'        => 'Website Performance & Development',
			'tagline'      => 'Fast, Accessible WordPress Web Engineering',
			'desc'         => 'Modern WordPress development with semantic HTML, clean responsive layouts, fast load times, and accessible interfaces that make enquiry submission seamless.',
			'icon'         => 'code',
			'price'        => 'Tailored Scope',
			'badge'        => 'Foundational',
			'deliverables' => array(
				'Custom theme development & clean PHP templates',
				'Mobile-first responsive layout & WCAG accessibility',
				'Core Web Vitals & asset optimization',
				'Secure enquiry workflows & dashboard administration',
			),
		),
	);
}

/**
 * Custom accessible pagination
 */
function agency_site_pagination() {
	the_posts_pagination(
		array(
			'mid_size'           => 2,
			'prev_text'          => '<span class="inline-flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg> Previous</span>',
			'next_text'          => '<span class="inline-flex items-center gap-1">Next <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></span>',
			'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'agency-site' ) . ' </span>',
		)
	);
}

/**
 * Render the bespoke Apex Digital brand logo mark.
 *
 * An architectural vector emblem featuring precision dual-plane summit facets
 * and structural golden-ratio crossbars in brand ink/ivory and signature cobalt.
 *
 * @param string $variant   'header' (Ink + Cobalt) or 'footer' (Ivory + Cobalt).
 * @param string $css_class Additional CSS classes for sizing and transitions.
 * @return void
 */
function agency_site_brand_mark( $variant = 'header', $css_class = 'w-8 h-8 sm:w-9 sm:h-9' ) {
	$is_footer = ( 'footer' === $variant );
	$primary   = $is_footer ? '#F3F0E8' : '#202720';
	$accent    = '#2649E7';

	echo '<svg class="' . esc_attr( $css_class ) . '" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img">';
	echo '<polygon points="17.2,3.5 4.5,31.5 11.8,31.5 17.2,18.5" fill="' . esc_attr( $primary ) . '"/>';
	echo '<polygon points="18.8,3.5 31.5,31.5 24.2,31.5 18.8,18.5" fill="' . esc_attr( $accent ) . '"/>';
	echo '<polygon points="9.5,21.2 17.2,21.2 17.2,24.2 8.2,24.2" fill="' . esc_attr( $primary ) . '"/>';
	echo '<polygon points="18.8,21.2 26.5,21.2 27.8,24.2 18.8,24.2" fill="' . esc_attr( $accent ) . '"/>';
	echo '</svg>';
}
