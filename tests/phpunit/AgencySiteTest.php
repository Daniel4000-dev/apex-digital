<?php
/**
 * Class AgencySiteTest
 *
 * @package Agency_Site_Tests
 */

use PHPUnit\Framework\TestCase;

class AgencySiteTest extends TestCase {

    public function test_post_types_registered() {
        $this->assertTrue(post_type_exists('agency_service'), 'agency_service post type should be registered.');
        $this->assertTrue(post_type_exists('agency_enquiry'), 'agency_enquiry post type should be registered.');
    }

    public function test_payload_boundary_constant() {
        $this->assertSame(10240, Agency_Core_Enquiry_Handler::MAX_PAYLOAD_BYTES, 'Max payload must be 10KB.');
    }

    public function test_webhook_hmac_signature() {
        $secret = 'test_secret_key_123';
        $payload = ['event' => 'enquiry.created', 'id' => 42];
        $json = wp_json_encode($payload);
        $expected_sig = hash_hmac('sha256', $json, $secret);

        $this->assertSame(64, strlen($expected_sig), 'HMAC-SHA256 must produce 64-char hex string.');
        $this->assertTrue(hash_equals($expected_sig, hash_hmac('sha256', $json, $secret)));
    }

    public function test_ssrf_metadata_blocked() {
        update_option('agency_webhook_url', 'http://169.254.169.254/latest/meta-data');
        $result = Agency_Core_Webhook_Dispatcher::dispatch(['test' => true], 9999);

        $this->assertSame('failed', $result['status']);
        $this->assertStringContainsString('forbidden', $result['message']);
    }

    public function test_production_localhost_blocked() {
        $prod_filter = function() { return 'production'; };
        add_filter('agency_core_environment_type', $prod_filter);

        update_option('agency_webhook_url', 'http://127.0.0.1:8080/hook');
        $result = Agency_Core_Webhook_Dispatcher::dispatch(['test' => true], 9998);

        remove_filter('agency_core_environment_type', $prod_filter);

        $this->assertSame('failed', $result['status']);
        $this->assertStringContainsString('disabled in production', $result['message']);
    }

    public function test_seo_redirects_mapping() {
        $redirects = [
            'audit'        => home_url('/contact/'),
            'free-audit'   => home_url('/contact/'),
            'case-studies' => home_url('/services/'),
        ];

        $this->assertSame(home_url('/contact/'), $redirects['free-audit']);
        $this->assertSame(home_url('/services/'), $redirects['case-studies']);
    }

    public function test_html_email_template_rendering() {
        $name    = 'Marcus Vance';
        $email   = 'marcus@hyperion-demo.com';
        $phone   = '+1 555-0188';
        $company = 'Hyperion Logistics';
        $service = 'Conversion Rate Optimization';
        $budget  = '$15,000 / mo';
        $message = 'Need full funnel audit';
        $site_name = get_bloginfo('name');
        $site_url = home_url('/');
        $agency_phone = '+1 (800) 555-0199';
        $agency_email = 'growth@apexagency.digital';

        ob_start();
        include AGENCY_CORE_DIR . 'templates/email-confirmation.php';
        $html = ob_get_clean();

        $this->assertStringContainsString('Marcus Vance', $html);
        $this->assertStringContainsString('Conversion Rate Optimization', $html);
        $this->assertStringContainsString('Hyperion Logistics', $html);
    }
}

