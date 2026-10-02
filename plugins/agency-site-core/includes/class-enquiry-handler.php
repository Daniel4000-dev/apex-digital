<?php
/**
 * Enquiry Submission Handler, HTML Email Sender & Admin CPT
 *
 * Includes:
 * - Anti-spam honeypot verification
 * - Request payload size bounding (10KB limit)
 * - Transient-based IP rate limiter (5 per 10 mins)
 * - CRLF header injection mitigation
 * - Branded HTML confirmation & internal notification emails
 * - Custom Post Type 'agency_enquiry' with custom columns
 *
 * @package Agency_Site_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Agency_Core_Enquiry_Handler {

	const MAX_PAYLOAD_BYTES = 10240; // 10KB
	const RATE_LIMIT_MAX    = 5;
	const RATE_LIMIT_WINDOW = 600;   // 10 minutes (seconds)

	public function __construct() {
		add_action( 'init', array( $this, 'register_enquiry_cpt' ) );
		add_action( 'wp_ajax_agency_submit_contact', array( $this, 'handle_submission' ) );
		add_action( 'wp_ajax_nopriv_agency_submit_contact', array( $this, 'handle_submission' ) );
		add_filter( 'manage_agency_enquiry_posts_columns', array( $this, 'set_custom_columns' ) );
		add_action( 'manage_agency_enquiry_posts_custom_column', array( $this, 'render_custom_columns' ), 10, 2 );
	}

	public function register_enquiry_cpt() {
		$labels = array(
			'name'               => _x( 'Enquiries', 'post type general name', 'agency-site-core' ),
			'singular_name'      => _x( 'Enquiry', 'post type singular name', 'agency-site-core' ),
			'menu_name'          => _x( 'Enquiries', 'admin menu', 'agency-site-core' ),
			'name_admin_bar'     => _x( 'Enquiry', 'add new on admin bar', 'agency-site-core' ),
			'all_items'          => __( 'All Enquiries', 'agency-site-core' ),
			'search_items'       => __( 'Search Enquiries', 'agency-site-core' ),
			'not_found'          => __( 'No enquiries received yet.', 'agency-site-core' ),
			'not_found_in_trash' => __( 'No enquiries in Trash.', 'agency-site-core' ),
		);

		$args = array(
			'labels'          => $labels,
			'description'     => __( 'Client inbound consultation enquiries.', 'agency-site-core' ),
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => true,
			'capability_type' => 'post',
			'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
			'map_meta_cap'    => true,
			'hierarchical'    => false,
			'menu_position'   => 6,
			'menu_icon'       => 'dashicons-email-alt',
			'supports'        => array( 'title', 'editor' ),
		);

		register_post_type( 'agency_enquiry', $args );
	}

	public function set_custom_columns( $columns ) {
		return array(
			'cb'              => $columns['cb'],
			'title'           => __( 'Lead Name', 'agency-site-core' ),
			'enquiry_email'   => __( 'Email', 'agency-site-core' ),
			'enquiry_phone'   => __( 'Phone', 'agency-site-core' ),
			'enquiry_service' => __( 'Service Requested', 'agency-site-core' ),
			'enquiry_budget'  => __( 'Budget', 'agency-site-core' ),
			'webhook_status'  => __( 'Webhook Delivery', 'agency-site-core' ),
			'date'            => $columns['date'],
		);
	}

	public function render_custom_columns( $column, $post_id ) {
		switch ( $column ) {
			case 'enquiry_email':
				$email = get_post_meta( $post_id, '_enquiry_email', true );
				echo $email ? '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>' : '—';
				break;
			case 'enquiry_phone':
				echo esc_html( get_post_meta( $post_id, '_enquiry_phone', true ) ?: '—' );
				break;
			case 'enquiry_service':
				echo esc_html( get_post_meta( $post_id, '_enquiry_service', true ) ?: '—' );
				break;
			case 'enquiry_budget':
				echo esc_html( get_post_meta( $post_id, '_enquiry_budget', true ) ?: '—' );
				break;
			case 'webhook_status':
				$status = get_post_meta( $post_id, '_webhook_status', true );
				if ( $status === 'success' ) {
					echo '<span style="color:#059669; font-weight:700;">✓ Delivered</span>';
				} elseif ( $status === 'failed' ) {
					echo '<span style="color:#dc2626; font-weight:700;">✗ Failed</span>';
				} else {
					echo '<span style="color:#64748b;">— Skipped</span>';
				}
				break;
		}
	}

	/**
	 * Handle public and logged-in AJAX inquiry submission
	 */
	public function handle_submission() {
		// 1. Payload Size Limitation (Reject > 10KB before processing)
		$raw_body       = file_get_contents( 'php://input' );
		$post_length    = ! empty( $_POST ) ? strlen( http_build_query( $_POST ) ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Missing
		$payload_length = max( strlen( (string) $raw_body ), $post_length );
		if ( $payload_length > self::MAX_PAYLOAD_BYTES ) {
			wp_send_json_error(
				array(
					'message' => esc_html__( 'Request payload exceeds maximum allowed size (10KB).', 'agency-site-core' ),
				),
				413
			);
			wp_die();
		}

		// 2. Nonce Security Check (Reject missing or invalid token with HTTP 403)
		if ( ! check_ajax_referer( 'agency_contact_action_nonce', 'security', false ) ) {
			wp_send_json_error(
				array(
					'message' => esc_html__( 'Invalid security token or session expired. Please refresh the page.', 'agency-site-core' ),
				),
				403
			);
			wp_die();
		}

		// 3. Anti-Spam Honeypot Verification
		if ( ! empty( $_POST['agency_hp_website'] ) ) {
			wp_send_json_error(
				array(
					'message' => esc_html__( 'Automated submission detected.', 'agency-site-core' ),
				),
				400
			);
			wp_die();
		}

		// 4. Rate Limiting (5 requests per 10 minutes per IP)
		$client_ip = $this->get_client_ip();
		$rate_key  = 'agency_rate_' . md5( $client_ip );
		$attempts  = (int) get_transient( $rate_key );

		if ( $attempts >= self::RATE_LIMIT_MAX ) {
			wp_send_json_error(
				array(
					'message' => esc_html__( 'Too many requests. Please wait a few minutes before submitting another inquiry.', 'agency-site-core' ),
				),
				429
			);
			wp_die();
		}
		set_transient( $rate_key, $attempts + 1, self::RATE_LIMIT_WINDOW );

		// 5. Field Shape & Type Validation (Reject arrays)
		foreach ( array( 'name', 'email', 'phone', 'company', 'service', 'budget', 'message' ) as $field ) {
			if ( isset( $_POST[ $field ] ) && ! is_string( $_POST[ $field ] ) ) {
				wp_send_json_error(
					array(
						/* translators: %s: form field name */
						'message' => sprintf( esc_html__( 'Invalid data format for field %s.', 'agency-site-core' ), $field ),
					),
					400
				);
				wp_die();
			}
		}

		// 6. Sanitization & CRLF Injection Mitigation
		$name    = $this->strip_crlf( sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) ) );
		$email   = $this->strip_crlf( sanitize_email( wp_unslash( $_POST['email'] ?? '' ) ) );
		$phone   = $this->strip_crlf( sanitize_text_field( wp_unslash( $_POST['phone'] ?? '' ) ) );
		$company = $this->strip_crlf( sanitize_text_field( wp_unslash( $_POST['company'] ?? '' ) ) );
		$service = $this->strip_crlf( sanitize_text_field( wp_unslash( $_POST['service'] ?? '' ) ) );
		$budget  = $this->strip_crlf( sanitize_text_field( wp_unslash( $_POST['budget'] ?? '' ) ) );
		$message = sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) );

		// Validate required fields
		if ( empty( $name ) || empty( $email ) || ! is_email( $email ) || empty( $message ) ) {
			wp_send_json_error(
				array(
					'message' => esc_html__( 'Please fill in all required fields with a valid email address.', 'agency-site-core' ),
				),
				400
			);
			wp_die();
		}

		// Validate field length bounds (prevent DB exhaustion and buffer abuse)
		if ( mb_strlen( $name ) > 100 ) {
			wp_send_json_error(
				array(
					'message' => esc_html__( 'Name exceeds maximum allowed length (100 characters).', 'agency-site-core' ),
				),
				400
			);
			wp_die();
		}

		if ( mb_strlen( $email ) > 100 ) {
			wp_send_json_error(
				array(
					'message' => esc_html__( 'Email address exceeds maximum allowed length (100 characters).', 'agency-site-core' ),
				),
				400
			);
			wp_die();
		}

		if ( mb_strlen( $phone ) > 50 ) {
			wp_send_json_error(
				array(
					'message' => esc_html__( 'Phone number exceeds maximum allowed length (50 characters).', 'agency-site-core' ),
				),
				400
			);
			wp_die();
		}

		if ( mb_strlen( $company ) > 100 ) {
			wp_send_json_error(
				array(
					'message' => esc_html__( 'Company name exceeds maximum allowed length (100 characters).', 'agency-site-core' ),
				),
				400
			);
			wp_die();
		}

		if ( mb_strlen( $service ) > 100 ) {
			wp_send_json_error(
				array(
					'message' => esc_html__( 'Service name exceeds maximum allowed length (100 characters).', 'agency-site-core' ),
				),
				400
			);
			wp_die();
		}

		if ( mb_strlen( $budget ) > 50 ) {
			wp_send_json_error(
				array(
					'message' => esc_html__( 'Budget tier exceeds maximum allowed length (50 characters).', 'agency-site-core' ),
				),
				400
			);
			wp_die();
		}

		if ( mb_strlen( $message ) > 3000 ) {
			wp_send_json_error(
				array(
					'message' => esc_html__( 'Message exceeds maximum allowed length (3000 characters).', 'agency-site-core' ),
				),
				400
			);
			wp_die();
		}

		if ( mb_strlen( $message ) < 10 ) {
			wp_send_json_error(
				array(
					'message' => esc_html__( 'Message is too short (minimum 10 characters required).', 'agency-site-core' ),
				),
				400
			);
			wp_die();
		}

		// 7. Insert Enquiry into agency_enquiry CPT
		$enquiry_title = sprintf( '%s — %s', $name, $service ?: 'General Inquiry' );
		$insert_args   = array(
			'post_type'    => 'agency_enquiry',
			'post_status'  => 'publish',
			'post_title'   => $enquiry_title,
			'post_content' => $message,
			'meta_input'   => array(
				'_enquiry_name'    => $name,
				'_enquiry_email'   => $email,
				'_enquiry_phone'   => $phone,
				'_enquiry_company' => $company,
				'_enquiry_service' => $service,
				'_enquiry_budget'  => $budget,
				'_enquiry_ip'      => $client_ip,
			),
		);

		// Allow test harness to simulate database persistence failure
		$insert_args = apply_filters( 'agency_core_insert_enquiry_args', $insert_args );
		$enquiry_id  = wp_insert_post( $insert_args, true );

		// Strict persistence check: If save fails, halt immediately without webhook or email dispatch
		if ( is_wp_error( $enquiry_id ) || empty( $enquiry_id ) ) {
			wp_send_json_error(
				array(
					'message' => esc_html__( 'Unable to process and store your enquiry at this time. Please try again later.', 'agency-site-core' ),
				),
				500
			);
			wp_die();
		}

		$enquiry_data = array(
			'name'         => $name,
			'email'        => $email,
			'phone'        => $phone,
			'company'      => $company,
			'service'      => $service,
			'budget'       => $budget,
			'message'      => $message,
			'submitted_at' => current_time( 'mysql' ),
			'source_url'   => wp_get_referer() ?: home_url( '/contact/' ),
		);

		// 8. Dispatch Webhook
		$webhook_result = Agency_Core_Webhook_Dispatcher::dispatch( $enquiry_data, $enquiry_id );
		if ( $enquiry_id ) {
			update_post_meta( $enquiry_id, '_webhook_status', $webhook_result['status'] );
		}

		// 9. Send Admin Notification Email (HTML & Plain Text)
		$this->send_admin_notification( $name, $email, $phone, $company, $service, $budget, $message, $webhook_result['status'] );

		// 10. Send Branded HTML Confirmation Email to Customer
		$this->send_confirmation_email( $email, $name, $service, $budget, $company, $phone, $message );

		wp_send_json_success(
			array(
				'message'        => esc_html__( 'Thank you! Your inquiry has been sent successfully. A senior strategist will review your submission and reply within 24 hours.', 'agency-site-core' ),
				'webhook_status' => $webhook_result['status'],
			)
		);
		wp_die();
	}

	/**
	 * Send HTML Confirmation Email to Client
	 *
	 * Parameters are made available in scope for email-confirmation.php template.
	 */
	// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
	public function send_confirmation_email( $email, $name, $service, $budget, $company, $phone, $message ) {
		$site_name    = get_bloginfo( 'name' );
		$site_url     = home_url( '/' );
		$agency_phone = get_theme_mod( 'agency_phone', '+1 (800) 555-0199' );
		$agency_email = get_theme_mod( 'agency_email', 'growth@apexagency.digital' );

		$template_path = AGENCY_CORE_DIR . 'templates/email-confirmation.php';

		ob_start();
		if ( file_exists( $template_path ) ) {
			include $template_path;
		} else {
			echo '<p>Thank you for reaching out. We have received your inquiry.</p>';
		}
		$html_content = ob_get_clean();

		$subject = sprintf( 'Consultation Request Received — %s', $site_name );
		$headers = array(
			'Content-Type: text/html; charset=UTF-8',
			'From: ' . $site_name . ' <' . $agency_email . '>',
			'Reply-To: ' . $agency_email,
		);

		$alt_body = sprintf(
			"Hello %1\$s,\n\nThank you for reaching out to %2\$s. We have received your consultation request.\n\nSummary of your request:\n- Service: %3\$s\n- Budget: %4\$s\n- Company: %5\$s\n- Phone: %6\$s\n\nOur team will review your project details and follow up within 24 hours.\n\nBest regards,\n%2\$s Team\n%7\$s",
			$name,
			$site_name,
			$service ?: 'General Growth Consultation',
			$budget ?: 'Not specified',
			$company ?: 'Not provided',
			$phone ?: 'Not provided',
			$agency_email
		);

		$set_alt_body = function ( $phpmailer ) use ( $alt_body ) {
			// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			$phpmailer->AltBody = $alt_body;
		};
		add_action( 'phpmailer_init', $set_alt_body );
		$sent = wp_mail( $email, $subject, $html_content, $headers );
		remove_action( 'phpmailer_init', $set_alt_body );

		return $sent;
	}

	/**
	 * Send Internal Admin Notification Email
	 *
	 * Parameters are made available in scope for email-internal-notification.php template.
	 */
	// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
	public function send_admin_notification( $name, $email, $phone, $company, $service, $budget, $message, $webhook_status ) {
		$admin_email   = get_option( 'admin_email' );
		$site_name     = get_bloginfo( 'name' );
		$template_path = AGENCY_CORE_DIR . 'templates/email-internal-notification.php';

		ob_start();
		if ( file_exists( $template_path ) ) {
			include $template_path;
		} else {
			echo '<p>' . esc_html( sprintf( 'New lead received from %1$s (%2$s)', $name, $email ) ) . '</p>';
		}
		$html_content = ob_get_clean();

		$subject = sprintf( '[%s Lead] Consultation: %s (%s)', $site_name, $name, $service );
		$headers = array(
			'Content-Type: text/html; charset=UTF-8',
			'From: ' . $site_name . ' <' . $admin_email . '>',
			'Reply-To: ' . $name . ' <' . $email . '>',
		);

		$alt_body = sprintf(
			"New Lead Consultation Request:\n\n- Name: %1\$s\n- Email: %2\$s\n- Phone: %3\$s\n- Company: %4\$s\n- Service: %5\$s\n- Budget: %6\$s\n- Webhook Delivery: %7\$s\n\nMessage:\n%8\$s",
			$name,
			$email,
			$phone ?: 'Not provided',
			$company ?: 'Not provided',
			$service,
			$budget ?: 'Not specified',
			$webhook_status,
			$message
		);

		$set_alt_body = function ( $phpmailer ) use ( $alt_body ) {
			// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			$phpmailer->AltBody = $alt_body;
		};
		add_action( 'phpmailer_init', $set_alt_body );
		$sent = wp_mail( $admin_email, $subject, $html_content, $headers );
		remove_action( 'phpmailer_init', $set_alt_body );

		return $sent;
	}

	/**
	 * Prevent CRLF injection attacks
	 */
	private function strip_crlf( $str ) {
		return str_replace( array( "\r", "\n", '%0a', '%0d' ), '', $str );
	}

	/**
	 * Get safe client IP
	 */
	private function get_client_ip() {
		if ( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
			return sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) );
		}
		return '127.0.0.1';
	}
}
