<?php
/**
 * PHPUnit Bootstrap for Agency Site Tests
 *
 * Dynamically boots WordPress test environment across local development
 * (macOS / Local by Flywheel) and GitHub Actions CI runner (/tmp/wordpress).
 *
 * @package Agency_Site_Tests
 */

// 1. Resolve local MySQL socket only if running on macOS under Local by Flywheel.
$local_socket_candidates = array(
	getenv( 'MYSQL_UNIX_PORT' ),
	ini_get( 'mysqli.default_socket' ),
	'/Users/mac/Library/Application Support/Local/run/Rxl0HKEp-/mysql/mysqld.sock',
);

foreach ( $local_socket_candidates as $candidate_socket ) {
	if ( $candidate_socket && file_exists( $candidate_socket ) ) {
		ini_set( 'mysqli.default_socket', $candidate_socket );
		break;
	}
}

// 2. WordPress execution constants for tests.
if ( ! defined( 'WP_USE_THEMES' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedConstantFound
	define( 'WP_USE_THEMES', false );
}

if ( ! defined( 'DOING_AJAX' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedConstantFound
	define( 'DOING_AJAX', true );
}

// 3. Resolve WordPress root path (supports CI WP_ROOT, Local, and relative paths).
$wp_load_candidates = array(
	getenv( 'WP_LOAD_PATH' ) ? getenv( 'WP_LOAD_PATH' ) : null,
	getenv( 'WP_ROOT' ) ? rtrim( getenv( 'WP_ROOT' ), '/' ) . '/wp-load.php' : null,
	dirname( __DIR__, 3 ) . '/wp-load.php',
	'/tmp/wordpress/wp-load.php',
	dirname( __DIR__, 4 ) . '/wp-load.php',
	'/Users/mac/Local Sites/wordpress-agency-site/app/public/wp-load.php',
);

$wp_loaded = false;
foreach ( $wp_load_candidates as $candidate_path ) {
	if ( $candidate_path && file_exists( $candidate_path ) ) {
		require_once $candidate_path;
		$wp_loaded = true;
		break;
	}
}

if ( ! $wp_loaded ) {
	fwrite(
		STDERR,
		"PHPUnit Bootstrap Error: Unable to locate wp-load.php. Please set WP_ROOT environment variable.\n"
	);
	exit( 1 );
}

// 4. Ensure companion plugin directory constant and classes are loaded.
if ( ! defined( 'AGENCY_CORE_DIR' ) ) {
	define( 'AGENCY_CORE_DIR', dirname( __DIR__, 2 ) . '/plugins/agency-site-core/' );
}

if ( ! class_exists( 'Agency_Site_Core' ) && ! function_exists( 'agency_site_core' ) ) {
	$plugin_entry = dirname( __DIR__, 2 ) . '/plugins/agency-site-core/agency-site-core.php';
	if ( file_exists( $plugin_entry ) ) {
		require_once $plugin_entry;
	}
}
