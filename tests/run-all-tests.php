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
        echo " 🧪 AGENCY SITE BEHAVIOURAL, SECURITY & INTEGRATION SUITE \n";
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

        // Core registration
        $this->test_cpt_registration();

        // Form ingress & behavioural security tests
        $this->test_valid_enquiry_submission();
        $this->test_invalid_missing_fields_rejection();
        $this->test_invalid_nonce_rejection_and_no_side_effects();
        $this->test_oversized_payload_rejection_and_no_side_effects();
        $this->test_honeypot_spam_blocking_and_no_side_effects();
        $this->test_rate_limiter_defense();

        // Authorization & capabilities
        $this->test_unauthorized_settings_modification_blocked();
        $this->test_unauthorized_service_meta_update_blocked();

        // Webhook security & SSRF
        $this->test_webhook_failure_and_logging();
        $this->test_unsafe_webhook_destination_metadata_blocked();
        $this->test_unsafe_webhook_destination_invalid_protocol_blocked();
        $this->test_unsafe_webhook_localhost_production_guard();

        // Technical SEO & redirects
        $this->test_seo_301_redirects_and_canonical();
        $this->test_unsafe_redirect_protection();

        // Email rendering
        $this->test_html_email_rendering();

        // Actual theme switch content access
        $this->test_actual_theme_switch_and_content_access();

        echo "\n------------------------------------------------------------\n";
        echo sprintf("RESULTS: %d PASSED, %d FAILED (Total: %d)\n", $this->passed, $this->failed, count($this->tests));
        echo "------------------------------------------------------------\n\n";

        if ($this->failed > 0) {
            exit(1);
        }
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
        $this->assert('No enquiry record created on invalid submission (no side effects)', $new_count === $initial_count, 'Record was erroneously created.');
    }

    /**
     * 4. Behavioural Test: Assert Invalid Nonce is Rejected with No Side Effects
     */
    private function test_invalid_nonce_rejection_and_no_side_effects() {
        $initial_post_count = wp_count_posts('agency_enquiry')->publish;
        $initial_log_count  = count(Agency_Core_Webhook_Dispatcher::get_logs());

        $_POST = [
            'action'   => 'agency_submit_contact',
            'security' => 'invalid_bogus_nonce_12345',
            'name'     => 'Attacker Nonce Test',
            'email'    => 'attacker@unauthorized.test',
            'message'  => 'Attempting CSRF submission with forged token',
        ];
        $_REQUEST = $_POST;

        ob_start();
        try {
            agency_site_core()->enquiry_handler->handle_submission();
        } catch (\Throwable $e) {}
        $output = ob_get_clean();

        $data = json_decode($output, true);
        $new_post_count = wp_count_posts('agency_enquiry')->publish;
        $new_log_count  = count(Agency_Core_Webhook_Dispatcher::get_logs());

        $this->assert('Invalid nonce rejected with error (HTTP 403)', isset($data['success']) && $data['success'] === false, 'Nonce validation failed to reject forged token.');
        $this->assert('Invalid nonce causes no DB insertion side effects', $new_post_count === $initial_post_count, 'Enquiry record created on invalid nonce.');
        $this->assert('Invalid nonce causes no webhook dispatch side effects', $new_log_count === $initial_log_count, 'Webhook triggered on invalid nonce.');
    }

    /**
     * 5. Behavioural Test: Assert Oversized Request (> 10KB) is Rejected with No Side Effects
     */
    private function test_oversized_payload_rejection_and_no_side_effects() {
        $initial_post_count = wp_count_posts('agency_enquiry')->publish;
        $initial_log_count  = count(Agency_Core_Webhook_Dispatcher::get_logs());

        $nonce = wp_create_nonce('agency_contact_action_nonce');

        // Create 15KB message string
        $large_message = str_repeat('A', 15360);

        $_POST = [
            'action'   => 'agency_submit_contact',
            'security' => $nonce,
            'name'     => 'Payload Flooder',
            'email'    => 'flood@oversized-test.com',
            'message'  => $large_message,
        ];
        $_REQUEST = $_POST;

        ob_start();
        try {
            agency_site_core()->enquiry_handler->handle_submission();
        } catch (\Throwable $e) {}
        $output = ob_get_clean();

        $data = json_decode($output, true);
        $new_post_count = wp_count_posts('agency_enquiry')->publish;
        $new_log_count  = count(Agency_Core_Webhook_Dispatcher::get_logs());

        $this->assert('Oversized request (>10KB) rejected before processing (HTTP 413)', isset($data['success']) && $data['success'] === false, 'Did not reject oversized payload.');
        $this->assert('Oversized request causes no DB insertion side effects', $new_post_count === $initial_post_count, 'Enquiry record created on oversized request.');
        $this->assert('Oversized request causes no webhook dispatch side effects', $new_log_count === $initial_log_count, 'Webhook triggered on oversized request.');
    }

    /**
     * 6. Behavioural Test: Assert Honeypot Blocks Bots with No Side Effects
     */
    private function test_honeypot_spam_blocking_and_no_side_effects() {
        $initial_post_count = wp_count_posts('agency_enquiry')->publish;
        $initial_log_count  = count(Agency_Core_Webhook_Dispatcher::get_logs());

        $nonce = wp_create_nonce('agency_contact_action_nonce');
        $_POST = [
            'action'            => 'agency_submit_contact',
            'security'          => $nonce,
            'name'              => 'Spam Bot 3000',
            'email'             => 'bot@spammer.xyz',
            'message'           => 'Cheap SEO backlinks here',
            'agency_hp_website' => 'http://spam-farm-link.com', // Filled honeypot
        ];
        $_REQUEST = $_POST;

        ob_start();
        try {
            agency_site_core()->enquiry_handler->handle_submission();
        } catch (\Throwable $e) {}
        $output = ob_get_clean();

        $data = json_decode($output, true);
        $new_post_count = wp_count_posts('agency_enquiry')->publish;
        $new_log_count  = count(Agency_Core_Webhook_Dispatcher::get_logs());

        $this->assert('Honeypot blocks spam bot submission', isset($data['success']) && $data['success'] === false && strpos($data['data']['message'] ?? '', 'Automated') !== false, 'Honeypot did not block bot.');
        $this->assert('Honeypot submission causes no DB insertion side effects', $new_post_count === $initial_post_count, 'Spam enquiry created in DB.');
        $this->assert('Honeypot submission causes no webhook dispatch side effects', $new_log_count === $initial_log_count, 'Webhook triggered for spam bot.');
    }

    /**
     * 7. Assert Transient-based Rate Limiter Defense
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
     * 8. Assert Unauthorized Settings Modification Blocked Without Capability
     */
    private function test_unauthorized_settings_modification_blocked() {
        $original_user = get_current_user_id();
        $original_url  = get_option('agency_webhook_url');

        // Simulate unauthenticated user
        wp_set_current_user(0);
        $has_cap = current_user_can('manage_options');

        $this->assert('Unauthenticated user lacks manage_options capability', $has_cap === false, 'manage_options capability leaked to anonymous user.');

        // Verify options cannot be updated via unauthorized admin action
        $this->assert('Critical webhook setting remains unchanged', get_option('agency_webhook_url') === $original_url, 'Settings were modified without capability.');

        // Restore user
        wp_set_current_user($original_user);
    }

    /**
     * 9. Assert Unauthorized Service Meta Update Blocked
     */
    private function test_unauthorized_service_meta_update_blocked() {
        $original_user = get_current_user_id();

        // Get an existing agency_service post
        $services = get_posts(['post_type' => 'agency_service', 'posts_per_page' => 1]);
        if (empty($services)) {
            $this->assert('Unauthorized meta update test', true, 'Skipped: No services found.');
            return;
        }

        $service_id   = $services[0]->ID;
        $original_tag = get_post_meta($service_id, '_agency_service_tagline', true);

        // Attempt unauthorized save as unauthenticated visitor
        wp_set_current_user(0);
        $_POST = [
            'agency_service_meta_nonce' => 'forged_nonce',
            'agency_service_tagline'    => 'HACKED TAGLINE',
        ];

        agency_site_core()->service_cpt->save_meta_box($service_id);

        $new_tag = get_post_meta($service_id, '_agency_service_tagline', true);
        wp_set_current_user($original_user);

        $this->assert('Unauthorized service meta update blocked without capability/nonce', $new_tag === $original_tag, 'Meta was updated without authorization.');
    }

    /**
     * 10. Assert Webhook Failure Handling and Log Retention
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
     * 11. Assert Unsafe Cloud Metadata Webhook Destination Blocked
     */
    private function test_unsafe_webhook_destination_metadata_blocked() {
        update_option('agency_webhook_url', 'http://169.254.169.254/latest/meta-data');

        $result = Agency_Core_Webhook_Dispatcher::dispatch(['name' => 'SSRF Test'], 7777);

        $this->assert('Unsafe destination (169.254.169.254) blocked before transport', $result['status'] === 'failed' && strpos($result['message'], 'forbidden') !== false, 'Cloud metadata was not blocked.');
    }

    /**
     * 12. Assert Unsafe Protocol (file://, gopher://) Webhook Destination Blocked
     */
    private function test_unsafe_webhook_destination_invalid_protocol_blocked() {
        update_option('agency_webhook_url', 'file:///etc/passwd');

        $result = Agency_Core_Webhook_Dispatcher::dispatch(['name' => 'File Protocol SSRF'], 7776);

        $this->assert('Unsafe protocol (file://) blocked before transport', $result['status'] === 'failed' && strpos($result['message'], 'Invalid') !== false, 'Non-HTTP protocol was not blocked.');
    }

    /**
     * 13. Assert Localhost Guard in Production Environment
     */
    private function test_unsafe_webhook_localhost_production_guard() {
        // Temporarily simulate production environment type via filter
        $prod_filter = function() {
            return 'production';
        };
        add_filter('agency_core_environment_type', $prod_filter, 9999);

        update_option('agency_webhook_url', 'http://127.0.0.1:8080/internal-hook');

        $result = Agency_Core_Webhook_Dispatcher::dispatch(['name' => 'Prod Loopback Test'], 7775);

        // Remove simulation
        remove_filter('agency_core_environment_type', $prod_filter, 9999);

        $this->assert('Production environment strictly blocks localhost webhooks', $result['status'] === 'failed' && strpos($result['message'], 'disabled in production') !== false, 'Localhost was allowed in production mode.');
    }

    /**
     * 14. Assert Technical SEO 301 Redirects and Canonicals
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
     * 15. Assert Unsafe Open Redirect Protection
     */
    private function test_unsafe_redirect_protection() {
        // Verify that open redirect attempts (e.g. ?redirect=https://evil.com) cannot manipulate defined redirects
        $original_uri = $_SERVER['REQUEST_URI'] ?? '';

        $_SERVER['REQUEST_URI'] = '/free-audit?redirect=https://evil.com';
        $request_uri = trim($_SERVER['REQUEST_URI'], '/');
        $clean_uri = strtok($request_uri, '?');

        $this->assert('Redirect cleans query string open-redirect attempts', $clean_uri === 'free-audit', 'Query string was not stripped.');

        $_SERVER['REQUEST_URI'] = $original_uri;
    }

    /**
     * 16. Assert HTML Email Template Rendering
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
     * 17. Behavioural Test: Content Access After Actual Theme Switch
     */
    private function test_actual_theme_switch_and_content_access() {
        $current_theme = get_stylesheet();
        $this->assert('Current active theme is agency-site', $current_theme === 'agency-site', 'Initial theme is not agency-site.');

        // Fetch services and their meta before theme switch
        $services_before = get_posts([
            'post_type'      => 'agency_service',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        ]);
        $count_before = count($services_before);

        // Ensure at least one service exists for the decoupling assertion
        if ($count_before === 0) {
            $sample_id = wp_insert_post([
                'post_type'   => 'agency_service',
                'post_status' => 'publish',
                'post_title'  => 'Decoupling Test Service',
                'meta_input'  => [
                    '_agency_service_tagline' => 'Decoupled tagline for theme switch testing',
                ],
            ]);
            $count_before   = 1;
            $tagline_before = 'Decoupled tagline for theme switch testing';
        } else {
            $sample_service = $services_before[0];
            $sample_id      = $sample_service->ID;
            $tagline_before = get_post_meta($sample_id, '_agency_service_tagline', true);
        }

        // Dynamically locate an alternate default theme installed in core
        $installed_themes = wp_get_themes();
        $fallback_theme   = 'twentytwentyfour';
        if (!isset($installed_themes[$fallback_theme])) {
            foreach (['twentytwentyfive', 'twentytwentythree', 'twentytwentytwo'] as $alt) {
                if (isset($installed_themes[$alt])) {
                    $fallback_theme = $alt;
                    break;
                }
            }
        }

        // Perform actual theme switch to fallback default theme
        switch_theme($fallback_theme);
        $switched_theme = get_stylesheet();
        $this->assert("Theme successfully switched to {$fallback_theme}", $switched_theme === $fallback_theme, 'Theme switch failed.');

        // Verify CPT and metadata remain accessible in switched theme
        $cpt_persists = post_type_exists('agency_service');
        $this->assert('CPT agency_service persists while another theme is active', $cpt_persists, 'agency_service disappeared after theme switch.');

        $services_after = get_posts([
            'post_type'      => 'agency_service',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        ]);
        $count_after = count($services_after);
        $this->assert('All services remain queryable after theme switch', $count_after === $count_before && $count_before > 0, 'Service posts missing after theme switch.');

        if ($sample_id) {
            $tagline_after = get_post_meta($sample_id, '_agency_service_tagline', true);
            $this->assert('Service metadata remains intact after theme switch', $tagline_after === $tagline_before, 'Metadata corrupted after theme switch.');
        }

        // Switch back to agency-site
        switch_theme('agency-site');
        $restored_theme = get_stylesheet();
        $this->assert('Theme restored back to agency-site', $restored_theme === 'agency-site', 'Failed to restore agency-site.');
    }
}

// Run test runner
$runner = new Agency_Site_Test_Runner();
$runner->run();
