<?php
/**
 * Enquiry Webhook Dispatcher & Delivery Logger
 *
 * @package Agency_Site_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

class Agency_Core_Webhook_Dispatcher {

    const LOGS_OPTION = 'agency_webhook_delivery_logs';
    const MAX_LOGS    = 100;

    /**
     * Dispatch an enquiry payload to the configured webhook endpoint
     *
     * @param array $enquiry_data
     * @param int   $enquiry_id
     * @return array Result of delivery
     */
    public static function dispatch($enquiry_data, $enquiry_id = 0) {
        $enabled = (bool) get_option('agency_webhook_enabled', 1);
        $url     = trim(get_option('agency_webhook_url', ''));
        $secret  = trim(get_option('agency_webhook_secret', ''));
        $timeout = absint(get_option('agency_webhook_timeout', 8)) ?: 8;

        if (!$enabled || empty($url)) {
            return [
                'status'  => 'skipped',
                'message' => __('Webhook is disabled or no URL is configured.', 'agency-site-core'),
            ];
        }

        // Validate URL
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $log = self::record_log([
                'enquiry_id'       => $enquiry_id,
                'url'              => $url,
                'status'           => 'failed',
                'http_code'        => 0,
                'error_message'    => __('Invalid webhook URL format.', 'agency-site-core'),
                'duration_ms'      => 0,
                'request_payload'  => $enquiry_data,
                'response_body'    => '',
            ]);
            return [
                'status'  => 'failed',
                'message' => __('Invalid webhook URL format.', 'agency-site-core'),
            ];
        }

        $timestamp = time();
        $payload = [
            'event'      => 'enquiry.created',
            'timestamp'  => $timestamp,
            'enquiry_id' => $enquiry_id,
            'data'       => $enquiry_data,
        ];

        $json_payload = wp_json_encode($payload);

        $headers = [
            'Content-Type'       => 'application/json; charset=utf-8',
            'User-Agent'         => 'AgencySite-Webhook/1.0',
            'X-Agency-Event'     => 'enquiry.created',
            'X-Agency-Timestamp' => (string) $timestamp,
        ];

        // HMAC-SHA256 signature
        if (!empty($secret)) {
            $signature = hash_hmac('sha256', $json_payload, $secret);
            $headers['X-Agency-Signature'] = 'sha256=' . $signature;
        }

        $start_time = microtime(true);

        $response = wp_remote_post($url, [
            'method'      => 'POST',
            'timeout'     => $timeout,
            'redirection' => 3,
            'httpversion' => '1.1',
            'blocking'    => true,
            'headers'     => $headers,
            'body'        => $json_payload,
            'sslverify'   => false, // allow local self-signed dev certificates
        ]);

        $duration_ms = round((microtime(true) - $start_time) * 1000);

        if (is_wp_error($response)) {
            $error_message = $response->get_error_message();
            self::record_log([
                'enquiry_id'      => $enquiry_id,
                'url'             => $url,
                'status'          => 'failed',
                'http_code'       => 0,
                'error_message'   => $error_message,
                'duration_ms'     => $duration_ms,
                'request_payload' => $payload,
                'response_body'   => '',
            ]);

            return [
                'status'      => 'failed',
                'http_code'   => 0,
                'duration_ms' => $duration_ms,
                'message'     => $error_message,
            ];
        }

        $http_code     = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);
        $is_success    = ($http_code >= 200 && $http_code < 300);

        $log_data = [
            'enquiry_id'      => $enquiry_id,
            'url'             => $url,
            'status'          => $is_success ? 'success' : 'failed',
            'http_code'       => $http_code,
            'error_message'   => $is_success ? '' : sprintf(__('HTTP %d Response', 'agency-site-core'), $http_code),
            'duration_ms'     => $duration_ms,
            'request_payload' => $payload,
            'response_body'   => mb_substr($response_body, 0, 1000),
        ];

        self::record_log($log_data);

        return [
            'status'      => $is_success ? 'success' : 'failed',
            'http_code'   => $http_code,
            'duration_ms' => $duration_ms,
            'body'        => $response_body,
        ];
    }

    /**
     * Record a delivery attempt log entry
     */
    public static function record_log($log) {
        $logs = get_option(self::LOGS_OPTION, []);
        if (!is_array($logs)) {
            $logs = [];
        }

        $entry = array_merge([
            'id'              => uniqid('wh_log_'),
            'timestamp'       => current_time('mysql'),
            'enquiry_id'      => 0,
            'url'             => '',
            'status'          => 'unknown',
            'http_code'       => 0,
            'duration_ms'     => 0,
            'error_message'   => '',
            'request_payload' => [],
            'response_body'   => '',
        ], $log);

        array_unshift($logs, $entry);

        // Limit log retention
        if (count($logs) > self::MAX_LOGS) {
            $logs = array_slice($logs, 0, self::MAX_LOGS);
        }

        update_option(self::LOGS_OPTION, $logs, false);
        return $entry;
    }

    /**
     * Get all delivery logs
     */
    public static function get_logs() {
        $logs = get_option(self::LOGS_OPTION, []);
        return is_array($logs) ? $logs : [];
    }

    /**
     * Clear all delivery logs
     */
    public static function clear_logs() {
        return update_option(self::LOGS_OPTION, [], false);
    }

    /**
     * Send test webhook with dummy payload
     */
    public static function send_test_webhook($url = null, $secret = null) {
        if ($url) {
            update_option('agency_webhook_url', esc_url_raw($url));
        }
        if ($secret !== null) {
            update_option('agency_webhook_secret', sanitize_text_field($secret));
        }

        $dummy_data = [
            'name'         => 'Elena Rostova (Demo Tester)',
            'email'        => 'elena.tester@cloudscale-demo.com',
            'phone'        => '+1 (415) 555-0144',
            'company'      => 'CloudScale AI Technologies',
            'service'      => 'Search Engine Optimization (SEO)',
            'budget'       => '$10,000 - $25,000 / month',
            'message'      => 'Automated webhook delivery verification test from Agency Site Core.',
            'submitted_at' => current_time('mysql'),
            'source_url'   => home_url('/contact/'),
            'is_test'      => true,
        ];

        return self::dispatch($dummy_data, 99999);
    }
}
