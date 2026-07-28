<?php
/**
 * Enquiry Webhook Dispatcher & Delivery Logger
 *
 * Implements:
 * - wp_safe_remote_post() for SSRF protection
 * - Destination URL validation (HTTP/HTTPS only, rejects metadata services)
 * - HMAC-SHA256 signature calculation (X-Agency-Signature)
 * - Strict timeout bounding and failure logging
 * - Safe delivery logs without credentials or sensitive PII
 *
 * @package Agency_Site_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
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
	public static function dispatch( $enquiry_data, $enquiry_id = 0 ) {
		$enabled = (bool) get_option( 'agency_webhook_enabled', 1 );
		$url     = trim( get_option( 'agency_webhook_url', '' ) );
		$secret  = trim( get_option( 'agency_webhook_secret', '' ) );
		$timeout = absint( get_option( 'agency_webhook_timeout', 8 ) ) ?: 8;

		if ( ! $enabled || empty( $url ) ) {
			return array(
				'status'  => 'skipped',
				'message' => __( 'Webhook is disabled or no URL is configured.', 'agency-site-core' ),
			);
		}

		// Validate URL format and protocol
		if ( ! filter_var( $url, FILTER_VALIDATE_URL ) || ! preg_match( '/^https?:\/\//i', $url ) ) {
			self::record_log(
				array(
					'enquiry_id'      => $enquiry_id,
					'url'             => $url,
					'status'          => 'failed',
					'http_code'       => 0,
					'error_message'   => __( 'Invalid webhook URL format. Only HTTP/HTTPS protocols are permitted.', 'agency-site-core' ),
					'duration_ms'     => 0,
					'request_payload' => array( 'enquiry_id' => $enquiry_id ),
					'response_body'   => '',
				)
			);
			return array(
				'status'  => 'failed',
				'message' => __( 'Invalid webhook URL format.', 'agency-site-core' ),
			);
		}

		$parsed_host   = wp_parse_url( $url, PHP_URL_HOST );
		$is_local_host = in_array( $parsed_host, array( '127.0.0.1', 'localhost', '::1' ), true );

		// Environment check: determine if running in production
		$default_env   = function_exists( 'wp_get_environment_type' ) ? wp_get_environment_type() : 'production';
		$env_type      = apply_filters( 'agency_core_environment_type', $default_env );
		$is_production = ( $env_type === 'production' );

		// SSRF Guard 1: Reject cloud metadata service (169.254.169.254, AWS/GCP/Azure)
		if ( $parsed_host === '169.254.169.254' || strpos( (string) $parsed_host, 'metadata.google.internal' ) !== false ) {
			self::record_log(
				array(
					'enquiry_id'      => $enquiry_id,
					'url'             => $url,
					'status'          => 'failed',
					'http_code'       => 0,
					'error_message'   => __( 'Unsafe webhook destination: Cloud metadata endpoint blocked.', 'agency-site-core' ),
					'duration_ms'     => 0,
					'request_payload' => array( 'enquiry_id' => $enquiry_id ),
					'response_body'   => '',
				)
			);
			return array(
				'status'  => 'failed',
				'message' => __( 'Unsafe webhook destination blocked: Cloud metadata services are forbidden.', 'agency-site-core' ),
			);
		}

		// SSRF Guard 2: In production, reject loopback (127.0.0.1, localhost) and private addresses
		if ( $is_production && $is_local_host ) {
			self::record_log(
				array(
					'enquiry_id'      => $enquiry_id,
					'url'             => $url,
					'status'          => 'failed',
					'http_code'       => 0,
					'error_message'   => __( 'Unsafe webhook destination: Localhost is not allowed in production.', 'agency-site-core' ),
					'duration_ms'     => 0,
					'request_payload' => array( 'enquiry_id' => $enquiry_id ),
					'response_body'   => '',
				)
			);
			return array(
				'status'  => 'failed',
				'message' => __( 'Unsafe webhook destination blocked: Localhost endpoints are disabled in production.', 'agency-site-core' ),
			);
		}

		$timestamp = time();
		$payload   = array(
			'event'      => 'enquiry.created',
			'timestamp'  => $timestamp,
			'enquiry_id' => $enquiry_id,
			'data'       => $enquiry_data,
		);

		$json_payload = wp_json_encode( $payload );

		$headers = array(
			'Content-Type'       => 'application/json; charset=utf-8',
			'User-Agent'         => 'AgencySite-Webhook/1.0',
			'X-Agency-Event'     => 'enquiry.created',
			'X-Agency-Timestamp' => (string) $timestamp,
		);

		// HMAC-SHA256 signature
		if ( ! empty( $secret ) ) {
			$signature                     = hash_hmac( 'sha256', $json_payload, $secret );
			$headers['X-Agency-Signature'] = 'sha256=' . $signature;
		}

		// Allow localhost strictly for local/development test environments using a narrowly scoped filter
		$external_filter_callback = null;
		if ( $is_local_host && ! $is_production ) {
			$external_filter_callback = function ( $is_external, $host ) use ( $parsed_host ) {
				if ( $host === $parsed_host && in_array( $host, array( '127.0.0.1', 'localhost', '::1' ), true ) ) {
					return true;
				}
				return $is_external;
			};
			add_filter( 'http_request_host_is_external', $external_filter_callback, 10, 2 );
		}

		$start_time = microtime( true );

		try {
			// Safe remote post
			$response = wp_safe_remote_post(
				$url,
				array(
					'method'      => 'POST',
					'timeout'     => $timeout,
					'redirection' => 2,
					'httpversion' => '1.1',
					'blocking'    => true,
					'headers'     => $headers,
					'body'        => $json_payload,
					'sslverify'   => ! $is_local_host, // Enforce strict TLS in production, permit self-signed in local dev
				)
			);
		} finally {
			if ( $external_filter_callback !== null ) {
				remove_filter( 'http_request_host_is_external', $external_filter_callback, 10 );
			}
		}

		$duration_ms = round( ( microtime( true ) - $start_time ) * 1000 );

		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			self::record_log(
				array(
					'enquiry_id'      => $enquiry_id,
					'url'             => $url,
					'status'          => 'failed',
					'http_code'       => 0,
					'error_message'   => $error_message,
					'duration_ms'     => $duration_ms,
					'request_payload' => array(
						'event'      => 'enquiry.created',
						'enquiry_id' => $enquiry_id,
						'service'    => $enquiry_data['service'] ?? '',
					),
					'response_body'   => '',
				)
			);

			return array(
				'status'      => 'failed',
				'http_code'   => 0,
				'duration_ms' => $duration_ms,
				'message'     => $error_message,
			);
		}

		$http_code     = wp_remote_retrieve_response_code( $response );
		$response_body = wp_remote_retrieve_body( $response );
		$is_success    = ( $http_code >= 200 && $http_code < 300 );

		$log_data = array(
			'enquiry_id'      => $enquiry_id,
			'url'             => $url,
			'status'          => $is_success ? 'success' : 'failed',
			'http_code'       => $http_code,
			'error_message'   => $is_success ? '' : sprintf(
				/* translators: %d: HTTP response status code */
				__( 'HTTP %d Response', 'agency-site-core' ),
				$http_code
			),
			'duration_ms'     => $duration_ms,
			'request_payload' => array(
				'event'      => 'enquiry.created',
				'enquiry_id' => $enquiry_id,
				'service'    => $enquiry_data['service'] ?? '',
			),
			'response_body'   => mb_substr( wp_strip_all_tags( $response_body ), 0, 500 ),
		);

		self::record_log( $log_data );

		return array(
			'status'      => $is_success ? 'success' : 'failed',
			'http_code'   => $http_code,
			'duration_ms' => $duration_ms,
			'body'        => $response_body,
		);
	}

	/**
	 * Record a delivery attempt log entry
	 */
	public static function record_log( $log ) {
		$logs = get_option( self::LOGS_OPTION, array() );
		if ( ! is_array( $logs ) ) {
			$logs = array();
		}

		$entry = array_merge(
			array(
				'id'              => uniqid( 'wh_log_' ),
				'timestamp'       => current_time( 'mysql' ),
				'enquiry_id'      => 0,
				'url'             => '',
				'status'          => 'unknown',
				'http_code'       => 0,
				'duration_ms'     => 0,
				'error_message'   => '',
				'request_payload' => array(),
				'response_body'   => '',
			),
			$log
		);

		array_unshift( $logs, $entry );

		// Limit log retention
		if ( count( $logs ) > self::MAX_LOGS ) {
			$logs = array_slice( $logs, 0, self::MAX_LOGS );
		}

		update_option( self::LOGS_OPTION, $logs, false );
		return $entry;
	}

	public static function get_logs() {
		$logs = get_option( self::LOGS_OPTION, array() );
		return is_array( $logs ) ? $logs : array();
	}

	public static function clear_logs() {
		return update_option( self::LOGS_OPTION, array(), false );
	}

	public static function send_test_webhook( $url = null, $secret = null ) {
		if ( $url ) {
			update_option( 'agency_webhook_url', esc_url_raw( $url ) );
		}
		if ( $secret !== null ) {
			update_option( 'agency_webhook_secret', sanitize_text_field( $secret ) );
		}

		$dummy_data = array(
			'name'         => 'Elena Rostova (Demo Tester)',
			'email'        => 'elena.tester@cloudscale-demo.com',
			'phone'        => '+1 (415) 555-0144',
			'company'      => 'CloudScale AI Technologies',
			'service'      => 'Search Engine Optimization (SEO)',
			'budget'       => '$10,000 - $25,000 / month',
			'message'      => 'Automated webhook delivery verification test from Agency Site Core.',
			'submitted_at' => current_time( 'mysql' ),
			'source_url'   => home_url( '/contact/' ),
			'is_test'      => true,
		);

		return self::dispatch( $dummy_data, 99999 );
	}
}
