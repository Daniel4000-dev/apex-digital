<?php
/**
 * Service Custom Post Type & Meta Box Handler
 *
 * @package Agency_Site_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

class Agency_Core_CPT_Service {

    public function __construct() {
        add_action('init', [$this, 'register_post_type']);
        add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
        add_action('save_post_agency_service', [$this, 'save_meta_box']);
    }

    public function register_post_type() {
        if (post_type_exists('agency_service')) {
            return;
        }

        $labels = [
            'name'               => _x('Services', 'post type general name', 'agency-site-core'),
            'singular_name'      => _x('Service', 'post type singular name', 'agency-site-core'),
            'menu_name'          => _x('Services', 'admin menu', 'agency-site-core'),
            'name_admin_bar'     => _x('Service', 'add new on admin bar', 'agency-site-core'),
            'add_new'            => _x('Add New', 'service', 'agency-site-core'),
            'add_new_item'       => __('Add New Service', 'agency-site-core'),
            'new_item'           => __('New Service', 'agency-site-core'),
            'edit_item'          => __('Edit Service', 'agency-site-core'),
            'view_item'          => __('View Service', 'agency-site-core'),
            'all_items'          => __('All Services', 'agency-site-core'),
            'search_items'       => __('Search Services', 'agency-site-core'),
            'not_found'          => __('No services found.', 'agency-site-core'),
            'not_found_in_trash' => __('No services found in Trash.', 'agency-site-core'),
        ];

        $args = [
            'labels'             => $labels,
            'description'        => __('Agency marketing services and capabilities.', 'agency-site-core'),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => ['slug' => 'services', 'with_front' => false],
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 5,
            'menu_icon'          => 'dashicons-chart-line',
            'supports'           => ['title', 'editor', 'thumbnail', 'excerpt'],
            'show_in_rest'       => true,
        ];

        register_post_type('agency_service', $args);
    }

    public function add_meta_boxes() {
        add_meta_box(
            'agency_service_details',
            __('Service Details & Specifications', 'agency-site-core'),
            [$this, 'render_meta_box'],
            'agency_service',
            'normal',
            'high'
        );
    }

    public function render_meta_box($post) {
        wp_nonce_field('agency_service_meta_save', 'agency_service_meta_nonce');

        $tagline      = get_post_meta($post->ID, '_agency_service_tagline', true);
        $price        = get_post_meta($post->ID, '_agency_service_price', true);
        $deliverables = get_post_meta($post->ID, '_agency_service_deliverables', true);
        $icon         = get_post_meta($post->ID, '_agency_service_icon', true) ?: 'chart';
        $badge        = get_post_meta($post->ID, '_agency_service_badge', true);
        ?>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 8px;">
            <div>
                <label for="agency_service_tagline"><strong><?php esc_html_e('Subtitle / Tagline', 'agency-site-core'); ?>:</strong></label>
                <input type="text" id="agency_service_tagline" name="agency_service_tagline" value="<?php echo esc_attr($tagline); ?>" class="widefat" placeholder="e.g. Dominate high-intent organic search queries">
            </div>
            <div>
                <label for="agency_service_price"><strong><?php esc_html_e('Pricing Indicator', 'agency-site-core'); ?>:</strong></label>
                <input type="text" id="agency_service_price" name="agency_service_price" value="<?php echo esc_attr($price); ?>" class="widefat" placeholder="e.g. From $3,500 / month">
            </div>
            <div>
                <label for="agency_service_badge"><strong><?php esc_html_e('Highlight Badge (Optional)', 'agency-site-core'); ?>:</strong></label>
                <input type="text" id="agency_service_badge" name="agency_service_badge" value="<?php echo esc_attr($badge); ?>" class="widefat" placeholder="e.g. Most Popular or High ROI">
            </div>
            <div>
                <label for="agency_service_icon"><strong><?php esc_html_e('Icon Style', 'agency-site-core'); ?>:</strong></label>
                <select id="agency_service_icon" name="agency_service_icon" class="widefat">
                    <option value="chart" <?php selected($icon, 'chart'); ?>><?php esc_html_e('Chart / Analytics (SEO/Data)', 'agency-site-core'); ?></option>
                    <option value="bullhorn" <?php selected($icon, 'bullhorn'); ?>><?php esc_html_e('Megaphone / Ads (Paid Media)', 'agency-site-core'); ?></option>
                    <option value="cursor" <?php selected($icon, 'cursor'); ?>><?php esc_html_e('Target / Click (CRO & UX)', 'agency-site-core'); ?></option>
                    <option value="lightning" <?php selected($icon, 'lightning'); ?>><?php esc_html_e('Lightning / Strategy (Growth)', 'agency-site-core'); ?></option>
                    <option value="content" <?php selected($icon, 'content'); ?>><?php esc_html_e('Document / Pen (Content & Copy)', 'agency-site-core'); ?></option>
                    <option value="code" <?php selected($icon, 'code'); ?>><?php esc_html_e('Code / Screen (Web Design & Dev)', 'agency-site-core'); ?></option>
                </select>
            </div>
        </div>
        <div style="margin-top: 16px;">
            <label for="agency_service_deliverables"><strong><?php esc_html_e('Key Deliverables (one per line)', 'agency-site-core'); ?>:</strong></label>
            <textarea id="agency_service_deliverables" name="agency_service_deliverables" rows="5" class="widefat" placeholder="Technical SEO audit & crawl fixing&#10;Comprehensive keyword gap analysis&#10;Content roadmap & on-page optimization&#10;Monthly ranking & revenue attribution report"><?php echo esc_textarea($deliverables); ?></textarea>
        </div>
        <?php
    }

    public function save_meta_box($post_id) {
        if (!isset($_POST['agency_service_meta_nonce']) || !wp_verify_nonce($_POST['agency_service_meta_nonce'], 'agency_service_meta_save')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        if (isset($_POST['agency_service_tagline'])) {
            update_post_meta($post_id, '_agency_service_tagline', sanitize_text_field($_POST['agency_service_tagline']));
        }
        if (isset($_POST['agency_service_price'])) {
            update_post_meta($post_id, '_agency_service_price', sanitize_text_field($_POST['agency_service_price']));
        }
        if (isset($_POST['agency_service_badge'])) {
            update_post_meta($post_id, '_agency_service_badge', sanitize_text_field($_POST['agency_service_badge']));
        }
        if (isset($_POST['agency_service_icon'])) {
            update_post_meta($post_id, '_agency_service_icon', sanitize_text_field($_POST['agency_service_icon']));
        }
        if (isset($_POST['agency_service_deliverables'])) {
            update_post_meta($post_id, '_agency_service_deliverables', sanitize_textarea_field($_POST['agency_service_deliverables']));
        }
    }
}

