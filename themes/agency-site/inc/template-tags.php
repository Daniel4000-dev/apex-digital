<?php
/**
 * Custom template tags and SVG icon helpers
 *
 * @package Agency_Site
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Estimated reading time in minutes
 */
function agency_site_reading_time($content = null) {
    if (!$content) {
        $content = get_post_field('post_content', get_the_ID());
    }
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200);
    return max(1, $reading_time);
}

/**
 * Post publication date with icon
 */
function agency_site_posted_on() {
    $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
    if (get_the_time('U') !== get_the_modified_time('U')) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
    }

    $time_string = sprintf(
        $time_string,
        esc_attr(get_the_date(DATE_W3C)),
        esc_html(get_the_date())
    );

    echo '<span class="posted-on inline-flex items-center gap-1.5 text-slate-500 text-xs font-medium">' .
         '<svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>' .
         $time_string . '</span>';
}

/**
 * SVG icons helper
 */
function agency_site_get_icon($icon, $class = 'w-6 h-6') {
    switch ($icon) {
        case 'chart':
            return '<svg class="' . esc_attr($class) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>';
        case 'bullhorn':
            return '<svg class="' . esc_attr($class) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>';
        case 'cursor':
            return '<svg class="' . esc_attr($class) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>';
        case 'lightning':
            return '<svg class="' . esc_attr($class) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>';
        case 'content':
            return '<svg class="' . esc_attr($class) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>';
        case 'code':
            return '<svg class="' . esc_attr($class) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>';
        case 'check':
            return '<svg class="' . esc_attr($class) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
        case 'arrow-right':
            return '<svg class="' . esc_attr($class) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>';
        case 'star':
            return '<svg class="' . esc_attr($class) . '" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>';
        default:
            return '<svg class="' . esc_attr($class) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>';
    }
}

/**
 * Fallback services array when no CPT items exist yet
 */
function agency_site_get_default_services() {
    return [
        [
            'title'        => 'Search Engine Optimization (SEO)',
            'tagline'      => 'Rank #1 for high-value buyer search queries',
            'desc'         => 'We combine deep technical audits, semantic keyword mapping, and white-hat digital PR to capture authoritative search real estate that converts into revenue.',
            'icon'         => 'chart',
            'price'        => 'From $2,800 / mo',
            'badge'        => 'High ROI',
            'deliverables' => [
                'Full Technical Architecture & Core Web Vitals Audit',
                'Competitor Keyword Gap Analysis & Topical Clusters',
                'High-Authority Backlink Acquisition & Digital PR',
                'Real-Time Rank Tracking & Revenue Attribution Dashboards',
            ],
        ],
        [
            'title'        => 'Paid Media & Performance Ads',
            'tagline'      => 'Predictable, profitable customer acquisition',
            'desc'         => 'Data-backed campaign scaling across Google Ads, Meta, LinkedIn, and TikTok. We engineer custom ad creative, landing pages, and funnel logic that maximizes ROAS.',
            'icon'         => 'bullhorn',
            'price'        => 'From $3,500 / mo',
            'badge'        => 'Most Popular',
            'deliverables' => [
                'Multi-Channel Media Strategy (Google, Meta, LinkedIn)',
                'High-Converting Ad Creative & Copy Variations',
                'Advanced Retargeting & First-Party Audience Segmentation',
                'Weekly Bid Optimization & Conversion Tracking Hardening',
            ],
        ],
        [
            'title'        => 'Conversion Rate Optimization (CRO)',
            'tagline'      => 'Turn existing traffic into paying clients',
            'desc'         => 'Stop leaking qualified visitors. Using heatmap analytics, session replay insights, and rigorous multivariate A/B testing, we remove friction and double conversion efficiency.',
            'icon'         => 'cursor',
            'price'        => 'From $2,200 / mo',
            'badge'        => 'Fast Impact',
            'deliverables' => [
                'Heuristic UX & Funnel Drop-off Evaluation',
                'User Session Recording & Heatmap Behavior Analysis',
                'Continuous Multivariate & Split A/B Experimentation',
                'Tailored Form & Checkout Friction Elimination',
            ],
        ],
        [
            'title'        => 'Content Marketing & Authority PR',
            'tagline'      => 'Build brand loyalty with compelling storytelling',
            'desc'         => 'Editorial excellence designed for lead generation. We craft thought leadership articles, case studies, downloadable assets, and email sequences that nurture prospects.',
            'icon'         => 'content',
            'price'        => 'From $2,400 / mo',
            'badge'        => 'Long-Term Asset',
            'deliverables' => [
                'Executive Thought Leadership & Ghostwriting',
                'Data-Driven Case Studies & Whitepapers',
                'High-Impact Email Nurture & Newsletter Workflows',
                'Syndication Across Tier-1 Industry Publications',
            ],
        ],
        [
            'title'        => 'Growth Web Development & Speed',
            'tagline'      => 'Blazing-fast, conversion-focused websites',
            'desc'         => 'Modern web engineering engineered for performance. We build custom WordPress and modern digital platforms with sub-second load times and flawless mobile experiences.',
            'icon'         => 'code',
            'price'        => 'From $4,500 project',
            'badge'        => 'Foundational',
            'deliverables' => [
                'Custom Tailwind CSS & Headless / Classic Architecture',
                'Sub-second Server Response & Core Web Vitals 95+',
                'Seamless CRM, Analytics, & MarTech Integrations',
                'Enterprise-grade Security & WCAG Accessibility Compliance',
            ],
        ],
        [
            'title'        => 'Brand Strategy & Visual Identity',
            'tagline'      => 'Stand out in crowded competitive markets',
            'desc'         => 'Transform your brand into an unmistakable market leader with cohesive visual design systems, brand guidelines, messaging frameworks, and distinctive design assets.',
            'icon'         => 'lightning',
            'price'        => 'From $3,800 project',
            'badge'        => 'Creative',
            'deliverables' => [
                'Comprehensive Brand Architecture & Positioning Guide',
                'Logo Suite, Color Palettes, & Modern Typography Systems',
                'Multi-Format Social Media & Digital Collateral Kits',
                'Tone of Voice & Messaging Strategy Playbook',
            ],
        ],
    ];
}

/**
 * Custom accessible pagination
 */
function agency_site_pagination() {
    the_posts_pagination([
        'mid_size'           => 2,
        'prev_text'          => '<span class="inline-flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg> Previous</span>',
        'next_text'          => '<span class="inline-flex items-center gap-1">Next <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></span>',
        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'agency-site') . ' </span>',
    ]);
}

