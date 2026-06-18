<?php
/**
 * Technical SEO, JSON-LD Schema.org & 301 Redirect Handler
 *
 * @package Agency_Site_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

class Agency_Core_SEO_Manager {

    public function __construct() {
        add_action('wp_head', [$this, 'inject_meta_tags'], 1);
        add_action('wp_head', [$this, 'inject_json_ld_schema'], 2);
        add_action('template_redirect', [$this, 'handle_example_redirects']);
        add_filter('wp_sitemaps_post_types', [$this, 'ensure_services_in_sitemap']);
    }

    /**
     * Include agency_service in WordPress native core XML sitemaps
     */
    public function ensure_services_in_sitemap($post_types) {
        if (post_type_exists('agency_service') && !isset($post_types['agency_service'])) {
            $post_types['agency_service'] = get_post_type_object('agency_service');
        }
        return $post_types;
    }

    /**
     * Output technical SEO meta tags, canonical URL & Open Graph
     */
    public function inject_meta_tags() {
        $canonical = $this->get_canonical_url();
        $title     = wp_get_document_title();
        $desc      = $this->get_meta_description();
        $og_type   = is_single() ? 'article' : 'website';
        $site_name = get_bloginfo('name');

        echo "\n<!-- Technical SEO & Open Graph Meta Tags (Agency Site Core) -->\n";
        echo '<meta name="description" content="' . esc_attr($desc) . '">' . "\n";
        echo '<link rel="canonical" href="' . esc_url($canonical) . '">' . "\n";

        // Open Graph
        echo '<meta property="og:locale" content="' . esc_attr(get_locale()) . '">' . "\n";
        echo '<meta property="og:type" content="' . esc_attr($og_type) . '">' . "\n";
        echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($desc) . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url($canonical) . '">' . "\n";
        echo '<meta property="og:site_name" content="' . esc_attr($site_name) . '">' . "\n";

        // Twitter Card
        echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr($title) . '">' . "\n";
        echo '<meta name="twitter:description" content="' . esc_attr($desc) . '">' . "\n";
        echo "<!-- /Technical SEO Meta Tags -->\n\n";
    }

    private function get_canonical_url() {
        if (is_front_page()) {
            return home_url('/');
        }
        if (is_singular()) {
            return get_permalink();
        }
        if (is_category() || is_tag() || is_tax()) {
            return get_term_link(get_queried_object());
        }
        if (is_post_type_archive()) {
            return get_post_type_archive_link(get_query_var('post_type'));
        }
        global $wp;
        return home_url(add_query_arg([], $wp->request ?? ''));
    }

    private function get_meta_description() {
        if (is_front_page()) {
            return get_theme_mod('agency_hero_subhead', 'Full-funnel digital marketing agency specializing in technical SEO, performance advertising, and conversion rate optimization for fast-growing companies.');
        }
        if (is_singular('agency_service')) {
            $tagline = get_post_meta(get_the_ID(), '_agency_service_tagline', true);
            return $tagline ?: wp_strip_all_tags(get_the_excerpt());
        }
        if (is_singular('post')) {
            return wp_strip_all_tags(get_the_excerpt()) ?: 'In-depth growth teardown and digital marketing analysis from our agency frontlines.';
        }
        if (is_page_template('page-contact.php') || is_page('contact')) {
            return 'Book a growth strategy consultation with our senior architects. We audit your acquisition footprint and deliver actionable roadmaps.';
        }
        if (is_page_template('template-services.php') || is_page('services') || is_post_type_archive('agency_service')) {
            return 'Explore our comprehensive digital growth capabilities: technical SEO, paid performance media, CRO experimentation, and modern brand design.';
        }
        return get_bloginfo('description') ?: 'Data-driven digital marketing agency engineered for predictable, profitable growth.';
    }

    /**
     * Inject Schema.org JSON-LD structured data
     */
    public function inject_json_ld_schema() {
        $schemas = [];
        $site_url  = home_url('/');
        $site_name = get_bloginfo('name');
        $phone     = get_theme_mod('agency_phone', '+1 (800) 555-0199');
        $email     = get_theme_mod('agency_email', 'growth@apexagency.digital');

        // 1. Organization & ProfessionalService (Global)
        $schemas[] = [
            '@context'         => 'https://schema.org',
            '@type'            => 'ProfessionalService',
            '@id'              => $site_url . '#organization',
            'name'             => $site_name,
            'url'              => $site_url,
            'logo'             => $site_url . 'wp-content/themes/agency-site/screenshot.png',
            'email'            => $email,
            'telephone'        => $phone,
            'priceRange'       => '$$$$',
            'address'          => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => '100 Innovation Blvd, Suite 400',
                'addressLocality' => 'San Francisco',
                'addressRegion'   => 'CA',
                'postalCode'      => '94105',
                'addressCountry'  => 'US',
            ],
            'openingHours'     => 'Mo,Tu,We,Th,Fr 09:00-18:00',
            'sameAs'           => [
                get_theme_mod('agency_social_twitter', 'https://twitter.com'),
                get_theme_mod('agency_social_linkedin', 'https://linkedin.com'),
                get_theme_mod('agency_social_instagram', 'https://instagram.com'),
            ],
        ];

        // 2. Service Schema (on single service)
        if (is_singular('agency_service')) {
            $schemas[] = [
                '@context'    => 'https://schema.org',
                '@type'       => 'Service',
                'name'        => get_the_title(),
                'description' => wp_strip_all_tags(get_the_excerpt()),
                'provider'    => [
                    '@type' => 'ProfessionalService',
                    'name'  => $site_name,
                    'url'   => $site_url,
                ],
                'offers'      => [
                    '@type'         => 'Offer',
                    'price'         => '2500',
                    'priceCurrency' => 'USD',
                ],
            ];
        }

        // 3. Article Schema (on single blog post)
        if (is_singular('post')) {
            $author_name = get_the_author();
            $schemas[] = [
                '@context'         => 'https://schema.org',
                '@type'            => 'BlogPosting',
                'mainEntityOfPage' => [
                    '@type' => 'WebPage',
                    '@id'   => get_permalink(),
                ],
                'headline'         => get_the_title(),
                'description'      => wp_strip_all_tags(get_the_excerpt()),
                'datePublished'    => get_the_date('c'),
                'dateModified'     => get_the_modified_date('c'),
                'author'           => [
                    '@type' => 'Person',
                    'name'  => $author_name,
                ],
                'publisher'        => [
                    '@type' => 'Organization',
                    'name'  => $site_name,
                    'logo'  => [
                        '@type' => 'ImageObject',
                        'url'   => $site_url . 'wp-content/themes/agency-site/screenshot.png',
                    ],
                ],
            ];
        }

        // 4. FAQPage Schema (on services page or contact page)
        if (is_page_template('template-services.php') || is_page('services')) {
            $schemas[] = [
                '@context'   => 'https://schema.org',
                '@type'      => 'FAQPage',
                'mainEntity' => [
                    [
                        '@type'          => 'Question',
                        'name'           => 'How quickly can we expect to see measurable results?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text'  => 'Paid media improvements and conversion rate optimizations typically produce visible signal within the first 14 to 21 days. Organic search projects show compounding traffic gains around weeks 6 through 12.',
                        ],
                    ],
                    [
                        '@type'          => 'Question',
                        'name'           => 'Do you require long-term annual agency contracts?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text'  => 'No. We work on a 90-day initial acceleration period, followed by flexible monthly agreements based on milestone performance.',
                        ],
                    ],
                ],
            ];
        }

        echo "\n<!-- JSON-LD Structured Data (Agency Site Core) -->\n";
        foreach ($schemas as $schema) {
            echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";
        }
        echo "<!-- /JSON-LD Structured Data -->\n\n";
    }

    /**
     * Working 301 Redirect Examples
     * e.g. /audit -> /contact/
     *      /free-audit -> /contact/
     *      /case-studies -> /services/
     */
    public function handle_example_redirects() {
        if (is_admin() || wp_doing_ajax() || wp_doing_cron()) {
            return;
        }

        $request_uri = trim($_SERVER['REQUEST_URI'] ?? '', '/');
        // Strip query string if present
        $clean_uri = strtok($request_uri, '?');

        $redirects = [
            'audit'        => home_url('/contact/'),
            'free-audit'   => home_url('/contact/'),
            'get-audit'    => home_url('/contact/'),
            'case-studies' => home_url('/services/'),
        ];

        if (isset($redirects[$clean_uri])) {
            wp_safe_redirect($redirects[$clean_uri], 301);
            exit;
        }
    }
}
