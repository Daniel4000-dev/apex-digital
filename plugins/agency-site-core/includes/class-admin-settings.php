<?php
/**
 * Admin Settings & Webhook Delivery Logs UI
 *
 * @package Agency_Site_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

class Agency_Core_Admin_Settings {

    public function __construct() {
        add_action('admin_menu', [$this, 'register_admin_menus']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('admin_post_agency_send_test_webhook', [$this, 'handle_test_webhook']);
        add_action('admin_post_agency_clear_webhook_logs', [$this, 'handle_clear_logs']);
    }

    public function register_admin_menus() {
        add_submenu_page(
            'edit.php?post_type=agency_enquiry',
            __('Webhook & Tracking Settings', 'agency-site-core'),
            __('Settings & Webhooks', 'agency-site-core'),
            'manage_options',
            'agency-core-settings',
            [$this, 'render_settings_page']
        );

        add_submenu_page(
            'edit.php?post_type=agency_enquiry',
            __('Webhook Delivery Logs', 'agency-site-core'),
            __('Delivery Logs', 'agency-site-core'),
            'manage_options',
            'agency-core-webhook-logs',
            [$this, 'render_logs_page']
        );
    }

    public function register_settings() {
        register_setting('agency_core_settings_group', 'agency_webhook_url', [
            'type'              => 'string',
            'sanitize_callback' => 'esc_url_raw',
        ]);
        register_setting('agency_core_settings_group', 'agency_webhook_secret', [
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        register_setting('agency_core_settings_group', 'agency_webhook_enabled', [
            'type'              => 'boolean',
            'sanitize_callback' => 'rest_sanitize_boolean',
            'default'           => 1,
        ]);
        register_setting('agency_core_settings_group', 'agency_webhook_timeout', [
            'type'              => 'integer',
            'sanitize_callback' => 'absint',
            'default'           => 8,
        ]);

        register_setting('agency_core_settings_group', 'agency_ga4_measurement_id', [
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        register_setting('agency_core_settings_group', 'agency_gtm_container_id', [
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        register_setting('agency_core_settings_group', 'agency_analytics_debug_mode', [
            'type'              => 'boolean',
            'sanitize_callback' => 'rest_sanitize_boolean',
            'default'           => 1,
        ]);
    }

    public function handle_test_webhook() {
        check_admin_referer('agency_test_webhook_action', 'agency_test_nonce');

        if (!current_user_can('manage_options')) {
            wp_die(__('Unauthorized user', 'agency-site-core'));
        }

        $url    = isset($_POST['test_url']) ? esc_url_raw(wp_unslash($_POST['test_url'])) : null;
        $secret = isset($_POST['test_secret']) ? sanitize_text_field(wp_unslash($_POST['test_secret'])) : null;

        $result = Agency_Core_Webhook_Dispatcher::send_test_webhook($url, $secret);

        $status_param = ($result['status'] === 'success') ? 'test_success' : 'test_failed';
        $code         = $result['http_code'] ?? 0;
        $duration     = $result['duration_ms'] ?? 0;

        wp_safe_redirect(add_query_arg([
            'page'        => 'agency-core-settings',
            'post_type'   => 'agency_enquiry',
            'test_status' => $status_param,
            'test_code'   => $code,
            'test_time'   => $duration,
        ], admin_url('edit.php')));
        exit;
    }

    public function handle_clear_logs() {
        check_admin_referer('agency_clear_logs_action', 'agency_clear_nonce');

        if (!current_user_can('manage_options')) {
            wp_die(__('Unauthorized user', 'agency-site-core'));
        }

        Agency_Core_Webhook_Dispatcher::clear_logs();

        wp_safe_redirect(add_query_arg([
            'page'         => 'agency-core-webhook-logs',
            'post_type'    => 'agency_enquiry',
            'logs_cleared' => 1,
        ], admin_url('edit.php')));
        exit;
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Agency Core — Webhooks & Tracking Settings', 'agency-site-core'); ?></h1>

            <?php if (isset($_GET['test_status'])) : ?>
                <?php if ($_GET['test_status'] === 'test_success') : ?>
                    <div class="notice notice-success is-dismissible">
                        <p><strong><?php esc_html_e('Test Webhook Delivered Successfully!', 'agency-site-core'); ?></strong> HTTP <?php echo esc_html($_GET['test_code']); ?> in <?php echo esc_html($_GET['test_time']); ?>ms. Check the <a href="<?php echo esc_url(admin_url('edit.php?post_type=agency_enquiry&page=agency-core-webhook-logs')); ?>">Delivery Logs</a> for full payload breakdown.</p>
                    </div>
                <?php else : ?>
                    <div class="notice notice-error is-dismissible">
                        <p><strong><?php esc_html_e('Test Webhook Delivery Failed.', 'agency-site-core'); ?></strong> HTTP <?php echo esc_html($_GET['test_code']); ?>. Check that the endpoint is reachable or view details in the <a href="<?php echo esc_url(admin_url('edit.php?post_type=agency_enquiry&page=agency-core-webhook-logs')); ?>">Delivery Logs</a>.</p>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <form method="post" action="options.php" style="background:#fff; padding:24px 30px; border-radius:12px; border:1px solid #ccd0d4; max-width:900px; margin-top:20px;">
                <?php
                settings_fields('agency_core_settings_group');
                do_settings_sections('agency_core_settings_group');
                ?>

                <h2 style="border-bottom:1px solid #e2e8f0; padding-bottom:8px; margin-top:0; color:#0f172a;">
                    🔗 <?php esc_html_e('Enquiry Webhook Integration', 'agency-site-core'); ?>
                </h2>
                <p class="description">
                    <?php esc_html_e('Whenever a prospective client submits an inquiry through the website, the payload is securely dispatched in real-time to this endpoint (CRM, Zapier, Make, Slack webhook, or internal API).', 'agency-site-core'); ?>
                </p>

                <table class="form-table" role="presentation">
                    <tr>
                        <th scope="row"><label for="agency_webhook_enabled"><?php esc_html_e('Enable Webhooks', 'agency-site-core'); ?></label></th>
                        <td>
                            <input type="checkbox" id="agency_webhook_enabled" name="agency_webhook_enabled" value="1" <?php checked(1, get_option('agency_webhook_enabled', 1)); ?>>
                            <label for="agency_webhook_enabled"><?php esc_html_e('Dispatch JSON webhooks on new enquiry submissions', 'agency-site-core'); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="agency_webhook_url"><?php esc_html_e('Webhook Destination URL', 'agency-site-core'); ?></label></th>
                        <td>
                            <input type="url" id="agency_webhook_url" name="agency_webhook_url" value="<?php echo esc_attr(get_option('agency_webhook_url', '')); ?>" class="regular-text code" style="width:100%; max-width:600px;" placeholder="https://api.yourcrm.com/v1/inbound-leads">
                            <p class="description"><?php esc_html_e('Supports any HTTPS/HTTP REST endpoint. Accepts POST with application/json payload.', 'agency-site-core'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="agency_webhook_secret"><?php esc_html_e('Secret Signature Key (HMAC)', 'agency-site-core'); ?></label></th>
                        <td>
                            <input type="text" id="agency_webhook_secret" name="agency_webhook_secret" value="<?php echo esc_attr(get_option('agency_webhook_secret', '')); ?>" class="regular-text code" style="width:100%; max-width:400px;" placeholder="whsec_xxxxxxxxxxxxxxxxxxxx">
                            <p class="description"><?php esc_html_e('When set, payloads will be signed using HMAC-SHA256 and transmitted in the X-Agency-Signature header for receiver verification.', 'agency-site-core'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="agency_webhook_timeout"><?php esc_html_e('Request Timeout (seconds)', 'agency-site-core'); ?></label></th>
                        <td>
                            <input type="number" id="agency_webhook_timeout" name="agency_webhook_timeout" min="2" max="30" value="<?php echo esc_attr(get_option('agency_webhook_timeout', 8)); ?>" class="small-text">
                            <p class="description"><?php esc_html_e('Maximum wait time before marking delivery as timed out (default: 8s).', 'agency-site-core'); ?></p>
                        </td>
                    </tr>
                </table>

                <h2 style="border-bottom:1px solid #e2e8f0; padding-bottom:8px; margin-top:32px; color:#0f172a;">
                    📊 <?php esc_html_e('Analytics & Tag Management (GA4 / GTM)', 'agency-site-core'); ?>
                </h2>
                <p class="description">
                    <?php esc_html_e('Connect Google Analytics 4 or Google Tag Manager to measure conversions, CTA clicks, and inquiry funnel performance.', 'agency-site-core'); ?>
                </p>

                <table class="form-table" role="presentation">
                    <tr>
                        <th scope="row"><label for="agency_ga4_measurement_id"><?php esc_html_e('GA4 Measurement ID', 'agency-site-core'); ?></label></th>
                        <td>
                            <input type="text" id="agency_ga4_measurement_id" name="agency_ga4_measurement_id" value="<?php echo esc_attr(get_option('agency_ga4_measurement_id', '')); ?>" class="regular-text" placeholder="G-XXXXXXXXXX">
                            <p class="description"><?php esc_html_e('Enter your Google Analytics 4 Measurement ID (Format: G-XXXXXXXXXX). Note: Requires a real Google Analytics account for live traffic collection.', 'agency-site-core'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="agency_gtm_container_id"><?php esc_html_e('GTM Container ID', 'agency-site-core'); ?></label></th>
                        <td>
                            <input type="text" id="agency_gtm_container_id" name="agency_gtm_container_id" value="<?php echo esc_attr(get_option('agency_gtm_container_id', '')); ?>" class="regular-text" placeholder="GTM-XXXXXXX">
                            <p class="description"><?php esc_html_e('Enter your Google Tag Manager Container ID. If both are set, GTM will manage GA4 deployment.', 'agency-site-core'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="agency_analytics_debug_mode"><?php esc_html_e('Console Debug Mode', 'agency-site-core'); ?></label></th>
                        <td>
                            <input type="checkbox" id="agency_analytics_debug_mode" name="agency_analytics_debug_mode" value="1" <?php checked(1, get_option('agency_analytics_debug_mode', 1)); ?>>
                            <label for="agency_analytics_debug_mode"><?php esc_html_e('Log dataLayer and custom CTA events to the browser developer console (useful for verification without real GA4 IDs)', 'agency-site-core'); ?></label>
                        </td>
                    </tr>
                </table>

                <?php submit_button(__('Save Configuration', 'agency-site-core')); ?>
            </form>

            <!-- Test Webhook Dispatch Box -->
            <div style="background:#fff; padding:24px 30px; border-radius:12px; border:1px solid #ccd0d4; max-width:900px; margin-top:24px;">
                <h3 style="margin-top:0; color:#0f172a;">🧪 <?php esc_html_e('Verify Webhook With Test Payload', 'agency-site-core'); ?></h3>
                <p><?php esc_html_e('Send an immediate sample enquiry payload with dummy data to test endpoint connectivity and HMAC signature calculation.', 'agency-site-core'); ?></p>
                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <input type="hidden" name="action" value="agency_send_test_webhook">
                    <?php wp_nonce_field('agency_test_webhook_action', 'agency_test_nonce'); ?>
                    <button type="submit" class="button button-secondary">
                        <?php esc_html_e('Send Test Webhook Now', 'agency-site-core'); ?>
                    </button>
                    <a href="<?php echo esc_url(admin_url('edit.php?post_type=agency_enquiry&page=agency-core-webhook-logs')); ?>" class="button button-link" style="margin-left:12px;">
                        <?php esc_html_e('View Webhook Delivery Logs →', 'agency-site-core'); ?>
                    </a>
                </form>
            </div>
        </div>
        <?php
    }

    public function render_logs_page() {
        $logs = Agency_Core_Webhook_Dispatcher::get_logs();
        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline"><?php esc_html_e('Webhook Delivery Logs', 'agency-site-core'); ?></h1>
            
            <?php if (!empty($logs)) : ?>
                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" style="display:inline-block; margin-left:16px;">
                    <input type="hidden" name="action" value="agency_clear_webhook_logs">
                    <?php wp_nonce_field('agency_clear_logs_action', 'agency_clear_nonce'); ?>
                    <button type="submit" class="button" onclick="return confirm('Clear all delivery logs?');">
                        <?php esc_html_e('Clear Logs', 'agency-site-core'); ?>
                    </button>
                </form>
            <?php endif; ?>

            <p><?php esc_html_e('Logs of all outbound webhook dispatches, response times, HTTP statuses, and error messages.', 'agency-site-core'); ?></p>

            <table class="wp-list-table widefat fixed striped posts" style="margin-top:16px;">
                <thead>
                    <tr>
                        <th style="width:160px;"><?php esc_html_e('Timestamp', 'agency-site-core'); ?></th>
                        <th style="width:90px;"><?php esc_html_e('Status', 'agency-site-core'); ?></th>
                        <th style="width:80px;"><?php esc_html_e('HTTP Code', 'agency-site-core'); ?></th>
                        <th style="width:90px;"><?php esc_html_e('Latency', 'agency-site-core'); ?></th>
                        <th><?php esc_html_e('Destination URL', 'agency-site-core'); ?></th>
                        <th><?php esc_html_e('Details / Error Message', 'agency-site-core'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($logs)) : ?>
                        <tr>
                            <td colspan="6" style="text-align:center; padding:24px; color:#64748b;">
                                <?php esc_html_e('No webhook dispatches logged yet. Try sending a test webhook or submit a contact inquiry.', 'agency-site-core'); ?>
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($logs as $log) : ?>
                            <tr>
                                <td><?php echo esc_html($log['timestamp']); ?></td>
                                <td>
                                    <?php if ($log['status'] === 'success') : ?>
                                        <span style="display:inline-block; padding:2px 8px; border-radius:9999px; background:#dcfce7; color:#15803d; font-weight:700; font-size:11px;">SUCCESS</span>
                                    <?php else : ?>
                                        <span style="display:inline-block; padding:2px 8px; border-radius:9999px; background:#fee2e2; color:#b91c1c; font-weight:700; font-size:11px;">FAILED</span>
                                    <?php endif; ?>
                                </td>
                                <td><strong><?php echo esc_html((string)$log['http_code'] ?: '—'); ?></strong></td>
                                <td><?php echo esc_html($log['duration_ms']); ?> ms</td>
                                <td><code style="word-break:break-all;"><?php echo esc_html($log['url']); ?></code></td>
                                <td>
                                    <?php if (!empty($log['error_message'])) : ?>
                                        <span style="color:#b91c1c; font-weight:600;"><?php echo esc_html($log['error_message']); ?></span>
                                    <?php elseif (!empty($log['response_body'])) : ?>
                                        <code style="font-size:11px;"><?php echo esc_html(mb_substr($log['response_body'], 0, 80)); ?></code>
                                    <?php else : ?>
                                        <span style="color:#64748b;">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}
