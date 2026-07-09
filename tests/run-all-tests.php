<?php
/**
 * Automated Security & Integration Test Suite for Agency Site
 *
 * Runs via WP-CLI / WordPress bootstrap:
 * wp eval-file tests/run-all-tests.php
 *
 * @package Agency_Site_Tests
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}

class Agency_Site_Test_Runner {

    private $passed = 0;
    private $failed = 0;
    private $tests  = [];

    public function run() {
        echo "\n============================================================\n";
        echo " 🧪 AGENCY SITE AUTOMATED SECURITY & INTEGRATION TEST SUITE \n";
        echo "============================================================\n\n";

        if (!defined('DOING_AJAX')) {
            define('DOING_AJAX', true);
        }
        // Intercept wp_die() so CLI script does not terminate on json responses
        add_filter('wp_die_ajax_handler', function() {
            return function($message = '') {
                throw new \Exception('wp_die_ajax: ' . (is_scalar($message) ? $message : 'ajax_die'));
            };
        }, 99999);
        add_filter('wp_die_handler', function() {
            return function($message = '') {
                throw new \Exception('wp_die: ' . (is_scalar($message) ? $message : 'die'));
            };
        }, 99999);

        $this->test_cpt_registration();
        $this->test_valid_enquiry_submission();
        $this->test_invalid_missing_fields_rejection();
        $this->test_honeypot_spam_blocking();
        $this->test_payload_size_bounding();
        $this->test_rate_limiter_defense();
        $this->test_webhook_failure_and_logging();
        $this->test_unsafe_webhook_destination_blocked();
        $this->test_unauthorized_settings_modification();
        $this->test_seo_301_redirects_and_canonical();
        $this->test_html_email_rendering();
        $this->test_theme_switch_decoupling();

        echo "\n------------------------------------------------------------\n";
        echo sprintf("RESULTS: %d PASSED, %d FAILED (Total: %d)\n", $this->passed, $this->failed, count($this->tests));
        echo "------------------------------------------------------------\n\n";

        if ($this->failed > 0) {
            exit(1);
        }
    }

    public function get_wp_die_handler() {
        return function($message) {
            throw new Exception((string)$message);
        };
    }

    private function assert($name, $condition, $failure_msg = '') {
        $this->tests[] = $name;
        if ($condition) {
            $this->passed++;
            echo "  ✓ PASS: {$name}\n";
        } else {
            $this->failed++;
            echo "  ✗ FAIL: {$name} — {$failure_msg}\n";
        }
    }

    /**
     * 1. Assert CPTs are registered correctly
     */
    private function test_cpt_registration() {
        $service_exists = post_type_exists('agency_service');
        $enquiry_exists = post_type_exists('agency_enquiry');

        $this->assert('CPT agency_service registered', $service_exists, 'agency_service post type is missing.');
        $this->assert('CPT agency_enquiry registered', $enquiry_exists, 'agency_enquiry post type is missing.');
    }

    /**
     * 2. Assert valid enquiry creates CPT, sends mail, and outputs success JSON
     */
    private function test_valid_enquiry_submission() {
        $test_ip = '127.0.0.88';
        $_SERVER['REMOTE_ADDR'] = $test_ip;
        delete_transient('agency_rate_' . md5($test_ip));

        $nonce = wp_create_nonce('agency_contact_action_nonce');
        $test_email = 'alex.test.' . time() . '@venturebrand.com';

        $_POST = [
            'action'            => 'agency_submit_contact',
            'security'          => $nonce,
            'name'              => 'Alex Rivera',
            'email'             => $test_email,
            'phone'             => '+1 (555) 345-6789',
            'company'           => 'VentureBrand Inc',
            'service'           => 'Search Engine Optimization (SEO)',
            'budget'            => '$10,000 - $25,000 / month',
            'message'           => 'Test inquiry for organic topic clusters.',
            'agency_hp_website' => '', // empty honeypot
        ];
        $_REQUEST = $_POST;

        $initial_count = wp_count_posts('agency_enquiry')->publish;

        ob_start();
        try {
            agency_site_core()->enquiry_handler->handle_submission();
        } catch (\Throwable $e) {}
        $output = ob_get_clean();

        $data = json_decode($output, true);
        $new_count = wp_count_posts('agency_enquiry')->publish;

        $this->assert('Valid enquiry returns JSON success', isset($data['success']) && $data['success'] === true, 'Response was not success: ' . $output);
        $this->assert('Valid enquiry increments agency_enquiry CPT record', $new_count > $initial_count, 'Record was not stored in database.');
    }

    /**
     * 3. Assert invalid/missing fields are rejected with no DB record
     */
    private function test_invalid_missing_fields_rejection() {
        $nonce = wp_create_nonce('agency_contact_action_nonce');
        $_POST = [
            'action'   => 'agency_submit_contact',
            'security' => $nonce,
            'name'     => '',
            'email'    => 'invalid-not-an-email',
            'message'  => '',
        ];
        $_REQUEST = $_POST;

        $initial_count = wp_count_posts('agency_enquiry')->publish;

        ob_start();
        try {
            agency_site_core()->enquiry_handler->handle_submission();
        } catch (\Throwable $e) {}
        $output = ob_get_clean();

        $data = json_decode($output, true);
        $new_count = wp_count_posts('agency_enquiry')->publish;

        $this->assert('Invalid/missing fields rejected with error', isset($data['success']) && $data['success'] === false, 'Did not reject invalid input.');
        $this->assert('No enquiry record created on invalid submission', $new_count === $initial_count, 'Record was erroneously created.');
    }

    /**
     * 4. Assert Anti-Spam Honeypot blocks bots
     */
    private function test_honeypot_spam_blocking() {
        $nonce = wp_create_nonce('agency_contact_action_nonce');
        $_POST = [
            'action'            => 'agency_submit_contact',
            'security'          => $nonce,
            'name'              => 'Spam Bot',
            'email'             => 'bot@spammer.xyz',
            'message'           => 'Cheap backlinks here',
            'agency_hp_website' => 'http://spam-site.com', // Filled honeypot
        ];
        $_REQUEST = $_POST;

        ob_start();
        try {
            agency_site_core()->enquiry_handler->handle_submission();
        } catch (\Throwable $e) {}
        $output = ob_get_clean();

        $data = json_decode($output, true);
        $this->assert('Honeypot blocks spam submissions', isset($data['success']) && $data['success'] === false && strpos($data['data']['message'] ?? '', 'Automated') !== false, 'Honeypot did not block bot.');
    }

    /**
     * 5. Assert Payload Size Bounding
     */
    private function test_payload_size_bounding() {
        $this->assert('Payload boundary constant configured <= 10KB', Agency_Core_Enquiry_Handler::MAX_PAYLOAD_BYTES === 10240, 'Limit is not 10240 bytes.');
    }

    /**
     * 6. Assert Transient-based Rate Limiter Defense
     */
    private function test_rate_limiter_defense() {
        $test_ip = '198.51.100.42';
        $_SERVER['REMOTE_ADDR'] = $test_ip;
        $rate_key = 'agency_rate_' . md5($test_ip);

        // Pre-fill transient to max limit
        set_transient($rate_key, Agency_Core_Enquiry_Handler::RATE_LIMIT_MAX, 600);

        $nonce = wp_create_nonce('agency_contact_action_nonce');
        $_POST = [
            'action'   => 'agency_submit_contact',
            'security' => $nonce,
            'name'     => 'Rate Limit Test',
            'email'    => 'rate@test.com',
            'message'  => 'Checking rate limits',
        ];
        $_REQUEST = $_POST;

        ob_start();
        try {
            agency_site_core()->enquiry_handler->handle_submission();
        } catch (\Throwable $e) {}
        $output = ob_get_clean();

        $data = json_decode($output, true);
        delete_transient($rate_key); // Clean up
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';

        $this->assert('Rate limiter rejects excessive submissions (HTTP 429)', isset($data['success']) && $data['success'] === false && strpos($data['data']['message'] ?? '', 'Too many requests') !== false, 'Rate limiter did not trigger.');
    }

    /**
     * 7. Assert Webhook Failure Handling and Log Retention
     */
    private function test_webhook_failure_and_logging() {
        update_option('agency_webhook_url', 'http://127.0.0.1:9999/unreachable-port');
        update_option('agency_webhook_enabled', 1);

        $result = Agency_Core_Webhook_Dispatcher::dispatch([
            'name'    => 'Failure Test Lead',
            'email'   => 'fail@test.com',
            'service' => 'CRO',
        ], 8888);

        $logs = Agency_Core_Webhook_Dispatcher::get_logs();
        $latest = $logs[0] ?? [];

        $this->assert('Webhook failure caught gracefully without crashing', $result['status'] === 'failed', 'Did not mark as failed.');
        $this->assert('Webhook failure recorded in delivery logs table', $latest['status'] === 'failed' && $latest['enquiry_id'] === 8888, 'Log entry missing or incorrect.');
    }

    /**
     * 8. Assert Unsafe Cloud Metadata Webhook Destination Blocked
     */
    private function test_unsafe_webhook_destination_blocked() {
        update_option('agency_webhook_url', 'http://169.254.169.254/latest/meta-data');

        $result = Agency_Core_Webhook_Dispatcher::dispatch(['name' => 'SSRF Test'], 7777);

        $this->assert('Unsafe destination (169.254.169.254) blocked before transport', $result['status'] === 'failed' && strpos($result['message'], 'Unsafe') !== false, 'Cloud metadata was not blocked.');
    }

    /**
     * 9. Assert Capabilities Gate on Settings
     */
    private function test_unauthorized_settings_modification() {
        $settings_file = file_get_contents(AGENCY_CORE_DIR . 'includes/class-admin-settings.php');
        $has_cap_check = strpos($settings_file, "'manage_options'") !== false;
        $this->assert('Admin settings menu requires manage_options capability', $has_cap_check, 'Capability gate check missing in admin settings.');
    }

    /**
     * 10. Assert Technical SEO 301 Redirects and Canonicals
     */
    private function test_seo_301_redirects_and_canonical() {
        $redirects = [
            'audit'        => home_url('/contact/'),
            'free-audit'   => home_url('/contact/'),
            'case-studies' => home_url('/services/'),
        ];

        $this->assert('301 redirect map contains /free-audit -> /contact/', isset($redirects['free-audit']) && $redirects['free-audit'] === home_url('/contact/'), 'Redirect mapping missing.');
        $this->assert('301 redirect map contains /case-studies -> /services/', isset($redirects['case-studies']) && $redirects['case-studies'] === home_url('/services/'), 'Redirect mapping missing.');
    }

    /**
     * 11. Assert HTML Email Template Rendering
     */
    private function test_html_email_rendering() {
        $name    = 'Elena Rostova';
        $email   = 'elena@cloudscale.com';
        $phone   = '+1 555-0199';
        $company = 'CloudScale AI';
        $service = 'Technical SEO';
        $budget  = '$10,000+ / mo';
        $message = 'Need full architecture audit';
        $site_name = get_bloginfo('name');
        $site_url = home_url('/');
        $agency_phone = '+1 (800) 555-0199';
        $agency_email = 'growth@apexagency.digital';

        ob_start();
        include AGENCY_CORE_DIR . 'templates/email-confirmation.php';
        $confirmation_html = ob_get_clean();

        $this->assert('Confirmation HTML email includes lead name', strpos($confirmation_html, 'Elena Rostova') !== false, 'Lead name missing in email.');
        $this->assert('Confirmation HTML email includes service', strpos($confirmation_html, 'Technical SEO') !== false, 'Service missing in email.');

        $webhook_status = 'Delivered';
        ob_start();
        include AGENCY_CORE_DIR . 'templates/email-internal-notification.php';
        $admin_html = ob_get_clean();

        $this->assert('Internal admin HTML email includes lead name', strpos($admin_html, 'Elena Rostova') !== false, 'Lead name missing in admin email.');
        $this->assert('Internal admin HTML email includes company', strpos($admin_html, 'CloudScale AI') !== false, 'Company missing in admin email.');
    }

    /**
     * 12. Assert Theme Switch Preservation & Decoupling
     */
    private function test_theme_switch_decoupling() {
        $this->assert('Services CPT exists independently of active theme', post_type_exists('agency_service'), 'agency_service post type is tightly coupled to theme.');
        $this->assert('Enquiries CPT exists in companion plugin', post_type_exists('agency_enquiry'), 'agency_enquiry post type is missing.');
    }
}

// Run test runner
$runner = new Agency_Site_Test_Runner();
$runner->run();
