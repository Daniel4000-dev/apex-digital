<?php
/**
 * Gravity Forms Integration Handler
 *
 * Connects Gravity Forms submissions directly into the Agency Site
 * enquiry workflow (CPT storage, HMAC webhook dispatch, rate-limiting)
 * without generating duplicate notification emails or multiple webhook deliveries.
 *
 * @package Agency_Site_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Agency_Core_Gravity_Forms_Integration {

	public function __construct() {
		// Hook Gravity Forms post-submission action if GF is installed and active
		add_action( 'gform_after_submission', array( $this, 'handle_gf_submission' ), 10, 2 );
	}

	/**
	 * Process Gravity Form entry into agency_enquiry CPT & Webhook
	 *
	 * @param array $entry Form entry data.
	 * @param array $form  Form meta configuration.
	 */
	public function handle_gf_submission( $entry, $form ) {
		// Map form field inputs by admin label or field label
		$field_map = $this->extract_fields( $entry, $form );

		if ( empty( $field_map['email'] ) || ! is_email( $field_map['email'] ) ) {
			return; // Invalid entry, skip
		}

		$name    = sanitize_text_field( $field_map['name'] ?? 'Direct Lead' );
		$email   = sanitize_email( $field_map['email'] );
		$phone   = sanitize_text_field( $field_map['phone'] ?? '' );
		$company = sanitize_text_field( $field_map['company'] ?? '' );
		$service = sanitize_text_field( $field_map['service'] ?? 'General Consultation' );
		$budget  = sanitize_text_field( $field_map['budget'] ?? 'Not Specified' );
		$message = sanitize_textarea_field( $field_map['message'] ?? '' );

		// Check for duplicate processing (idempotency key via entry ID)
		$existing_id = get_transient( 'agency_gf_processed_' . $entry['id'] );
		if ( $existing_id ) {
			return; // Already processed
		}
		set_transient( 'agency_gf_processed_' . $entry['id'], 1, HOUR_IN_SECONDS );

		// Insert into agency_enquiry CPT
		$enquiry_id = wp_insert_post(
			array(
				'post_type'    => 'agency_enquiry',
				'post_status'  => 'publish',
				'post_title'   => sprintf( '%s — %s (GF #%d)', $name, $service, (int) $entry['id'] ),
				'post_content' => $message,
				'meta_input'   => array(
					'_enquiry_name'        => $name,
					'_enquiry_email'       => $email,
					'_enquiry_phone'       => $phone,
					'_enquiry_company'     => $company,
					'_enquiry_service'     => $service,
					'_enquiry_budget'      => $budget,
					'_enquiry_ip'          => sanitize_text_field( $entry['ip'] ?? '' ),
					'_enquiry_source'      => 'gravity_forms',
					'_enquiry_gf_entry_id' => (int) $entry['id'],
					'_enquiry_gf_form_id'  => (int) $form['id'],
				),
			)
		);

		if ( is_wp_error( $enquiry_id ) || empty( $enquiry_id ) ) {
			return; // Failed to persist
		}

		// Dispatch Webhook with source identifier
		$webhook_data = array(
			'name'         => $name,
			'email'        => $email,
			'phone'        => $phone,
			'company'      => $company,
			'service'      => $service,
			'budget'       => $budget,
			'message'      => $message,
			'source'       => 'gravity_forms',
			'gf_form_id'   => (int) $form['id'],
			'gf_entry_id'  => (int) $entry['id'],
			'submitted_at' => current_time( 'mysql' ),
		);

		$webhook_result = Agency_Core_Webhook_Dispatcher::dispatch( $webhook_data, $enquiry_id );
		update_post_meta( $enquiry_id, '_webhook_status', $webhook_result['status'] );
	}

	/**
	 * Map Gravity Form inputs based on field labels
	 *
	 * @param array $entry
	 * @param array $form
	 * @return array
	 */
	private function extract_fields( $entry, $form ) {
		$data = array();
		if ( empty( $form['fields'] ) || ! is_array( $form['fields'] ) ) {
			return $data;
		}

		foreach ( $form['fields'] as $field ) {
			$label = strtolower( trim( $field->label ?? '' ) );
			$id    = (string) $field->id;
			$val   = $entry[ $id ] ?? '';

			if ( strpos( $label, 'name' ) !== false && ! isset( $data['name'] ) ) {
				$data['name'] = $val;
			} elseif ( ( strpos( $label, 'email' ) !== false || $field->type === 'email' ) && ! isset( $data['email'] ) ) {
				$data['email'] = $val;
			} elseif ( ( strpos( $label, 'phone' ) !== false || $field->type === 'phone' ) && ! isset( $data['phone'] ) ) {
				$data['phone'] = $val;
			} elseif ( strpos( $label, 'company' ) !== false && ! isset( $data['company'] ) ) {
				$data['company'] = $val;
			} elseif ( strpos( $label, 'service' ) !== false && ! isset( $data['service'] ) ) {
				$data['service'] = $val;
			} elseif ( strpos( $label, 'budget' ) !== false && ! isset( $data['budget'] ) ) {
				$data['budget'] = $val;
			} elseif ( ( strpos( $label, 'message' ) !== false || $field->type === 'textarea' ) && ! isset( $data['message'] ) ) {
				$data['message'] = $val;
			}
		}

		return $data;
	}
}
