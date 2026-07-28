<?php
/**
 * PHPUnit Bootstrap for Agency Site Tests
 */

ini_set('mysqli.default_socket', '/Users/mac/Library/Application Support/Local/run/Rxl0HKEp-/mysql/mysqld.sock');

define('WP_USE_THEMES', false);
define('DOING_AJAX', true);

// Load WordPress
require_once '/Users/mac/Local Sites/wordpress-agency-site/app/public/wp-load.php';
