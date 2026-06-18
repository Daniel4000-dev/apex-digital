<?php
/**
 * Enquiry Submission Handler, HTML Email Sender & Admin CPT
 *
 * @package Agency_Site_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

class Agency_Core_Enquiry_Handler {

    public function __construct() {
        add_action('init', [$this, 'register_enquiry_cpt']);
        add_action('wp_ajax_agency_submit_contact', [$this, 'handle_submission']);
        add_action('wp_ajax_nopriv_agency_submit_contact', [$this, 'handle_submission']);
        add_filter('manage_agency_enquiry_posts_columns', [$this, 'set_custom_columns']);
        add_action('manage_agency_enquiry_posts_custom_column', [$this, 'render_custom_columns'], 10, 2);
    }

    public function register_enquiry_cpt() {
        $labels = [
            'name'               => _x('Enquiries', 'post type general name', 'agency-site-core'),
            'singular_name'      => _x('Enquiry', 'post type singular name', 'agency-site-core'),
            'menu_name'          => _x('Enquiries', 'admin menu', 'agency-site-core'),
            'name_admin_bar'     => _x('Enquiry', 'add new on admin bar', 'agency-site-core'),
            'all_items'          => __('All Enquiries', 'agency-site-core'),
            'search_items'       => __('Search Enquiries', 'agency-site-core'),
            'not_found'          => __('No enquiries received yet.', 'agency-site-core'),
            'not_found_in_trash' => __('No enquiries in Trash.', 'agency-site-core'),
        ];

        $args = [
            'labels'             => $labels,
            'description'        => __('Client inbound consultation enquiries.', 'agency-site-core'),
            'public'             => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'capability_type'    => 'post',
            'capabilities'       => ['create_posts' => false], // only created via form submission
            'map_meta_cap'       => true,
            'hierarchical'       => false,
            'menu_position'      => 6,
            'menu_icon'          => 'dashicons-email-alt',
            'supports'           => ['title', 'editor'],
        ];

        register_post_type('agency_enquiry', $args);
    }

    public function set_custom_columns($columns) {
        $new_columns = [
            'cb'             => $columns['cb'],
            'title'          => __('Lead Name', 'agency-site-core'),
            'enquiry_email'  => __('Email', 'agency-site-core'),
            'enquiry_phone'  => __('Phone', 'agency-site-core'),
            'enquiry_service'=> __('Service Requested', 'agency-site-core'),
            'enquiry_budget' => __('Budget', 'agency-site-core'),
            'webhook_status' => __('Webhook Delivery', 'agency-site-core'),
            'date'           => $columns['date'],
        ];
        return $new_columns;
    }

    public function render_custom_columns($column, $post_id) {
        switch ($column) {
            case 'enquiry_email':
                $email = get_post_meta($post_id, '_enquiry_email', true);
                echo $email ? '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>' : '—';
                break;
            case 'enquiry_phone':
                echo esc_html(get_post_meta($post_id, '_enquiry_phone', true) ?: '—');
                break;
            case 'enquiry_service':
                echo esc_html(get_post_meta($post_id, '_enquiry_service', true) ?: '—');
                break;
            case 'enquiry_budget':
                echo esc_html(get_post_meta($post_id, '_enquiry_budget', true) ?: '—');
                break;
            case 'webhook_status':
                $status = get_post_meta($post_id, '_webhook_status', true);
                if ($status === 'success') {
                    echo '<span style="color:#059669; font-weight:700;">✓ Delivered</span>';
                } elseif ($status === 'failed') {
                    echo '<span style="color:#dc2626; font-weight:700;">✗ Failed</span>';
                } else {
                    echo '<span style="color:#64748b;">— Skipped</span>';
                }
                break;
        }
    }

    public function handle_submission() {
        check_ajax_referer('agency_contact_action_nonce', 'security');

        $name    = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
        $email   = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
        $phone   = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
        $company = isset($_POST['company']) ? sanitize_text_field(wp_unslash($_POST['company'])) : '';
        $service = isset($_POST['service']) ? sanitize_text_field(wp_unslash($_POST['service'])) : '';
        $budget  = isset($_POST['budget']) ? sanitize_text_field(wp_unslash($_POST['budget'])) : '';
        $message = isset($_POST['message']) ? sanitize_textarea_field(wp_unslash($_POST['message'])) : '';

        if (empty($name) || empty($email) || !is_email($email) || empty($message)) {
            wp_send_json_error([
                'message' => esc_html__('Please fill in all required fields with a valid email address.', 'agency-site-core'),
            ]);
            wp_die();
        }

        // 1. Insert Enquiry into agency_enquiry CPT
        $enquiry_title = sprintf('%s — %s', $name, $service ?: 'General Inquiry');
        $enquiry_id = wp_insert_post([
            'post_type'    => 'agency_enquiry',
            'post_status'  => 'publish',
            'post_title'   => $enquiry_title,
            'post_content' => $message,
            'meta_input'   => [
                '_enquiry_name'    => $name,
                '_enquiry_email'   => $email,
                '_enquiry_phone'   => $phone,
                '_enquiry_company' => $company,
                '_enquiry_service' => $service,
                '_enquiry_budget'  => $budget,
            ],
        ]);

        $enquiry_data = [
            'name'         => $name,
            'email'        => $email,
            'phone'        => $phone,
            'company'      => $company,
            'service'      => $service,
            'budget'       => $budget,
            'message'      => $message,
            'submitted_at' => current_time('mysql'),
            'source_url'   => wp_get_referer() ?: home_url('/contact/'),
        ];

        // 2. Dispatch Webhook
        $webhook_result = Agency_Core_Webhook_Dispatcher::dispatch($enquiry_data, $enquiry_id);
        if ($enquiry_id) {
            update_post_meta($enquiry_id, '_webhook_status', $webhook_result['status']);
        }

        // 3. Send Admin Notification Email
        $admin_email  = get_option('admin_email');
        $site_name    = get_bloginfo('name');
        $admin_subject= sprintf('[%s Lead] Consultation Request: %s (%s)', $site_name, $name, $service);
        $admin_body   = "You received a new growth strategy consultation inquiry:\n\n";
        $admin_body  .= "Name: {$name}\n";
        $admin_body  .= "Email: {$email}\n";
        $admin_body  .= "Phone: {$phone}\n";
        $admin_body  .= "Company: {$company}\n";
        $admin_body  .= "Service Needed: {$service}\n";
        $admin_body  .= "Monthly Budget: {$budget}\n\n";
        $admin_body  .= "Message:\n{$message}\n\n";
        $admin_body  .= "Webhook Status: " . $webhook_result['status'] . "\n";
        $admin_body  .= "Date: " . current_time('mysql') . "\n";

        $admin_headers = [
            'Content-Type: text/plain; charset=UTF-8',
            'From: ' . $site_name . ' <' . $admin_email . '>',
            'Reply-To: ' . $name . ' <' . $email . '>',
        ];

        @wp_mail($admin_email, $admin_subject, $admin_body, $admin_headers);

        // 4. Send Matching HTML Confirmation Email to Customer
        $this->send_confirmation_email($email, $name, $service, $budget, $company, $phone, $message);

        wp_send_json_success([
            'message'        => esc_html__('Thank you! Your inquiry has been sent successfully. A senior strategist will review your submission and reply within 24 hours.', 'agency-site-core'),
            'webhook_status' => $webhook_result['status'],
        ]);
        wp_die();
    }

    /**
     * Send HTML confirmation email to the prospective client
     */
    public function send_confirmation_email($email, $name, $service, $budget, $company, $phone, $message) {
        $site_name    = get_bloginfo('name');
        $site_url     = home_url('/');
        $agency_phone = get_theme_mod('agency_phone', '+1 (800) 555-0199');
        $agency_email = get_theme_mod('agency_email', 'growth@apexagency.digital');

        $template_path = AGENCY_CORE_DIR . '/templates/email-confirmation.php';

        ob_start();
        if (file_exists($template_path)) {
            include $template_path;
        } else {
            echo '<p>Thank you for reaching out. We have received your inquiry.</p>';
        }
        $html_content = ob_get_clean();

        $subject = sprintf('Consultation Request Received — %s', $site_name);
        $headers = [
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . $site_name . ' <' . $agency_email . '>',
            'Reply-To: ' . $agency_email,
        ];

        return @wp_mail($email, $subject, $html_content, $headers);
    }
}
