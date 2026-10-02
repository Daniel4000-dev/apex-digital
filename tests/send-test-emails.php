<?php
/**
 * Test Harness: Send Promotional Campaign & Transactional Emails to Local Mailpit
 *
 * Exercises wp_mail() with full HTML + plain text AltBody and verifies
 * actual delivery via Local Mailpit REST API (http://127.0.0.1:10000/api/v1/messages).
 *
 * @package Agency_Site
 */

if ( ! defined( 'ABSPATH' ) ) {
	require_once dirname( __DIR__ ) . '/app/public/wp-load.php';
}

echo "====================================================\n";
echo " 📧 APEX DIGITAL EMAIL DISPATCH & MAILPIT TESTER\n";
echo "====================================================\n\n";

$site_name    = 'Apex Digital';
$agency_email = 'growth@apexagency.digital';

// 1. Dispatch Transactional Confirmation Email
echo "[1/3] Dispatching Transactional Confirmation Email...\n";
$tx_to      = 'sarah.turner@enterprise-client.com';
$tx_name    = 'Sarah Turner';
$tx_service = 'Search Engine Optimization';
$tx_budget  = '$10,000 – $25,000 / mo';
$tx_company = 'Turner Logistics Group';
$tx_phone   = '+1 (555) 349-2041';
$tx_message = 'We are rebuilding our b2b logistics portal and require comprehensive keyword clustering and technical SEO architecture before Q1 relaunch.';

// Render transactional template
ob_start();
$name         = $tx_name;
$service      = $tx_service;
$budget       = $tx_budget;
$company      = $tx_company;
$phone        = $tx_phone;
$message      = $tx_message;
$site_url     = home_url( '/' );
$agency_phone = '+1 (800) 555-0199';
include dirname( __DIR__ ) . '/plugins/agency-site-core/templates/email-confirmation.php';
$tx_html = ob_get_clean();

$tx_subject = sprintf( 'Consultation Request Received — %s', $site_name );
$tx_headers = array(
	'Content-Type: text/html; charset=UTF-8',
	'From: ' . $site_name . ' <' . $agency_email . '>',
	'Reply-To: ' . $agency_email,
);

$tx_alt = sprintf(
	"Hello %s,\n\nThank you for reaching out to %s. We have received your consultation request.\n\nSummary:\n- Service: %s\n- Budget: %s\n- Company: %s\n\nOur team will follow up within 24 hours.",
	$tx_name,
	$site_name,
	$tx_service,
	$tx_budget,
	$tx_company
);

$set_tx_alt = function( $phpmailer ) use ( $tx_alt ) {
	$phpmailer->AltBody = $tx_alt;
};
add_action( 'phpmailer_init', $set_tx_alt );
$tx_sent = wp_mail( $tx_to, $tx_subject, $tx_html, $tx_headers );
remove_action( 'phpmailer_init', $set_tx_alt );

echo "  ✓ Transactional email sent: " . ( $tx_sent ? 'SUCCESS' : 'FAILED' ) . "\n\n";

// 2. Dispatch Promotional Campaign Email
echo "[2/3] Dispatching Promotional Campaign Marketing Email...\n";
$promo_to        = 'marcus.vance@growthbrand.co';
$recipient_name    = 'Marcus Vance';
$recipient_company = 'GrowthBrand Co.';
$audit_url         = 'http://wordpress-agency-site.local/contact/?utm_source=email&utm_campaign=q4_growth_audit';

ob_start();
include dirname( __DIR__ ) . '/plugins/agency-site-core/templates/email-promotional-audit.php';
$promo_html = ob_get_clean();

$promo_txt_template = file_get_contents( dirname( __DIR__ ) . '/plugins/agency-site-core/templates/email-promotional-audit.txt' );
$promo_alt = str_replace(
	array( '{{recipient_name}}', '{{audit_url}}', '{{site_url}}' ),
	array( $recipient_name, $audit_url, home_url( '/' ) ),
	$promo_txt_template
);

$promo_subject = sprintf( 'Turn More Visits Into Enquiries — Complimentary Q4 Growth Audit' );
$promo_headers = array(
	'Content-Type: text/html; charset=UTF-8',
	'From: ' . $site_name . ' Strategy <' . $agency_email . '>',
	'Reply-To: ' . $agency_email,
);

$set_promo_alt = function( $phpmailer ) use ( $promo_alt ) {
	$phpmailer->AltBody = $promo_alt;
};
add_action( 'phpmailer_init', $set_promo_alt );
$promo_sent = wp_mail( $promo_to, $promo_subject, $promo_html, $promo_headers );
remove_action( 'phpmailer_init', $set_promo_alt );

echo "  ✓ Promotional campaign email sent: " . ( $promo_sent ? 'SUCCESS' : 'FAILED' ) . "\n\n";

// 3. Inspect Local Mailpit API
echo "[3/3] Inspecting Local Mailpit API (127.0.0.1:10000)...\n";
$ch = curl_init( 'http://127.0.0.1:10000/api/v1/messages' );
curl_setopt_array( $ch, array(
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_TIMEOUT        => 5,
) );
$response = curl_exec( $ch );
$http_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
curl_close( $ch );

if ( $http_code === 200 && $response ) {
	$data = json_decode( $response, true );
	$messages = $data['messages'] ?? array();
	echo "  ✓ Mailpit API responded: HTTP 200\n";
	echo "  ✓ Total messages captured in Mailpit: " . count( $messages ) . "\n\n";

	foreach ( array_slice( $messages, 0, 3 ) as $idx => $msg ) {
		echo sprintf(
			"  [%d] ID: %s | Subject: %s\n      From: %s | To: %s\n",
			$idx + 1,
			$msg['ID'],
			$msg['Subject'],
			$msg['From']['Address'] ?? 'unknown',
			$msg['To'][0]['Address'] ?? 'unknown'
		);
	}
} else {
	echo "  ⚠ Mailpit API returned HTTP $http_code (ensure Mailpit is running on port 10000)\n";
}

echo "\n====================================================\n";
echo " 🎉 EMAIL DISPATCH VERIFICATION COMPLETE\n";
echo "====================================================\n";
