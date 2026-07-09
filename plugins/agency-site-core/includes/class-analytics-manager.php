<?php
/**
 * GA4 & GTM Analytics Manager & Event Tracker
 *
 * @package Agency_Site_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

class Agency_Core_Analytics_Manager {

    public function __construct() {
        add_action('wp_head', [$this, 'inject_head_tags'], 0);
        add_action('wp_body_open', [$this, 'inject_body_tags'], 0);
        add_action('wp_footer', [$this, 'inject_event_tracking_script'], 99);
    }

    /**
     * Inject GA4 / GTM into <head>
     */
    public function inject_head_tags() {
        $gtm_id  = trim(get_option('agency_gtm_container_id', ''));
        $ga4_id  = trim(get_option('agency_ga4_measurement_id', ''));
        $debug   = (bool) get_option('agency_analytics_debug_mode', 1);

        echo "\n<!-- Agency Analytics & Tag Management -->\n";
        echo "<script>\n";
        echo "window.dataLayer = window.dataLayer || [];\n";
        echo "function gtag(){dataLayer.push(arguments);}\n";
        if ($debug) {
            echo "console.log('[Agency Analytics] dataLayer initialized. Debug Mode: ON');\n";
        }
        echo "</script>\n";

        // GTM Head Snippet
        if (!empty($gtm_id) && preg_match('/^GTM-[A-Z0-9]+$/', $gtm_id)) {
            echo "<!-- Google Tag Manager -->\n";
            echo "<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':\n";
            echo "new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],\n";
            echo "j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=\n";
            echo "'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);\n";
            echo "})(window,document,'script','dataLayer','" . esc_js($gtm_id) . "');</script>\n";
            echo "<!-- End Google Tag Manager -->\n";
        }

        // GA4 Direct Snippet (when GTM is not used)
        if (!empty($ga4_id) && empty($gtm_id) && preg_match('/^G-[A-Z0-9]+$/', $ga4_id)) {
            echo "<!-- Google Analytics 4 (gtag.js) -->\n";
            echo "<script async src=\"https://www.googletagmanager.com/gtag/js?id=" . esc_attr($ga4_id) . "\"></script>\n";
            echo "<script>\n";
            echo "gtag('js', new Date());\n";
            echo "gtag('config', '" . esc_js($ga4_id) . "', { send_page_view: true });\n";
            echo "</script>\n";
            echo "<!-- End Google Analytics 4 -->\n";
        }

        echo "<!-- /Agency Analytics -->\n\n";
    }

    /**
     * Inject GTM <noscript> iframe immediately after <body> opening
     */
    public function inject_body_tags() {
        $gtm_id = trim(get_option('agency_gtm_container_id', ''));
        if (!empty($gtm_id) && preg_match('/^GTM-[A-Z0-9]+$/', $gtm_id)) {
            echo "\n<!-- Google Tag Manager (noscript) -->\n";
            echo '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=' . esc_attr($gtm_id) . '" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>' . "\n";
            echo "<!-- End Google Tag Manager (noscript) -->\n\n";
        }
    }

    /**
     * Frontend Event Tracking for CTAs, Form Submissions & FAQs
     */
    public function inject_event_tracking_script() {
        $debug = (bool) get_option('agency_analytics_debug_mode', 1);
        ?>
        <script>
        (function() {
            var isDebug = <?php echo $debug ? 'true' : 'false'; ?>;

            function trackEvent(eventName, eventParams) {
                eventParams = eventParams || {};
                eventParams.event = eventName;
                window.dataLayer = window.dataLayer || [];
                window.dataLayer.push(eventParams);

                if (typeof gtag === 'function') {
                    gtag('event', eventName, eventParams);
                }

                if (isDebug) {
                    console.log('🎯 [Agency Event Tracked]:', eventName, eventParams);
                }
            }

            // Expose globally so enquiry handler can trigger it
            window.agencyTrackEvent = trackEvent;

            document.addEventListener('DOMContentLoaded', function() {
                // 1. CTA Button Click Tracking
                document.querySelectorAll('.btn-primary, .btn-secondary, .btn-accent, a[href*="contact"]').forEach(function(btn) {
                    btn.addEventListener('click', function(e) {
                        var text = (btn.innerText || '').trim();
                        var href = btn.getAttribute('href') || '';
                        var section = btn.closest('section') ? (btn.closest('section').id || btn.closest('section').className.split(' ')[0]) : 'header';

                        trackEvent('agency_cta_click', {
                            cta_text: text,
                            cta_url: href,
                            cta_section: section,
                            page_path: window.location.pathname
                        });
                    });
                });

                // 2. FAQ Accordion Toggle Tracking
                document.querySelectorAll('.faq-toggle').forEach(function(toggle) {
                    toggle.addEventListener('click', function() {
                        var question = (toggle.innerText || '').trim();
                        var isExpanded = toggle.getAttribute('aria-expanded') === 'true';
                        if (!isExpanded) {
                            trackEvent('agency_faq_opened', {
                                question: question,
                                page_path: window.location.pathname
                            });
                        }
                    });
                });

                // 3. Contact Form Submission Tracking Listener
                var form = document.getElementById('agency-contact-form');
                if (form) {
                    var originalFetch = window.fetch;
                    // Hook into successful submission
                    form.addEventListener('submit', function() {
                        var serviceField = form.querySelector('[name="service"]');
                        var budgetField = form.querySelector('[name="budget"]');

                        // Listen once for next success alert
                        var observer = new MutationObserver(function(mutations, obs) {
                            var alertBox = document.getElementById('contact-form-alert');
                            if (alertBox && !alertBox.classList.contains('hidden') && alertBox.classList.contains('bg-emerald-50')) {
                                trackEvent('generate_lead', {
                                    value: budgetField ? budgetField.value : 'unspecified',
                                    currency: 'USD',
                                    service_requested: serviceField ? serviceField.value : 'unspecified',
                                    page_path: window.location.pathname
                                });
                                trackEvent('agency_enquiry_submitted', {
                                    service_requested: serviceField ? serviceField.value : 'unspecified',
                                    budget_tier: budgetField ? budgetField.value : 'unspecified',
                                    page_path: window.location.pathname
                                });
                                obs.disconnect();
                            }
                        });

                        var alertBox = document.getElementById('contact-form-alert');
                        if (alertBox) {
                            observer.observe(alertBox, { attributes: true, attributeFilter: ['class'] });
                        }
                    });
                }
            });
        })();
        </script>
        <?php
    }
}

