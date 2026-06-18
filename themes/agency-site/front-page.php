<?php
/**
 * The template for displaying the Homepage
 *
 * @package Agency_Site
 */

get_header();

// Customizer values with fallbacks
$hero_badge    = get_theme_mod('agency_hero_badge', __('Top-Rated Digital Growth Agency', 'agency-site'));
$hero_headline = get_theme_mod('agency_hero_headline', __('We Scale High-Growth Brands With Data-Driven Marketing', 'agency-site'));
$hero_subhead  = get_theme_mod('agency_hero_subhead', __('From organic search dominance to multi-million dollar paid acquisition pipelines, we help modern companies achieve predictable, profitable revenue.', 'agency-site'));
$hero_cta_text = get_theme_mod('agency_hero_cta_text', __('Get Free Growth Audit', 'agency-site'));
$hero_cta_link = get_theme_mod('agency_hero_cta_link', home_url('/contact/'));
$hero_sec_text = get_theme_mod('agency_hero_sec_cta_text', __('Explore Services', 'agency-site'));
$hero_sec_link = get_theme_mod('agency_hero_sec_cta_link', home_url('/services/'));
?>

<!-- 1. Hero Section -->
<section class="relative pt-12 pb-20 md:pt-20 md:pb-28 overflow-hidden bg-gradient-to-b from-white via-agency-50/40 to-slate-50">
    <!-- Glow Orbs -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[350px] bg-gradient-to-tr from-agency-200/50 to-accent-200/40 rounded-full blur-3xl pointer-events-none -z-10"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto">
            
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-agency-50 border border-agency-200/80 text-agency-700 text-xs sm:text-sm font-semibold shadow-xs mb-6 animate-pulse">
                <span class="w-2 h-2 rounded-full bg-agency-500"></span>
                <span><?php echo esc_html($hero_badge); ?></span>
            </div>

            <!-- Headline -->
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-slate-900 tracking-tight leading-[1.12] mb-6 font-heading">
                <?php echo esc_html($hero_headline); ?>
            </h1>

            <!-- Subhead -->
            <p class="text-lg sm:text-xl text-slate-600 mb-10 leading-relaxed font-normal">
                <?php echo esc_html($hero_subhead); ?>
            </p>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="<?php echo esc_url($hero_cta_link); ?>" class="btn-primary !py-4 !px-8 text-base w-full sm:w-auto shadow-lg shadow-agency-600/20">
                    <span><?php echo esc_html($hero_cta_text); ?></span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
                <a href="<?php echo esc_url($hero_sec_link); ?>" class="btn-secondary !py-4 !px-8 text-base w-full sm:w-auto">
                    <span><?php echo esc_html($hero_sec_text); ?></span>
                </a>
            </div>

            <!-- Social proof micro-pill -->
            <div class="mt-8 flex items-center justify-center gap-3 text-xs text-slate-500 font-medium">
                <div class="flex -space-x-2 overflow-hidden">
                    <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&h=100&fit=crop&crop=faces" alt="Client 1">
                    <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=faces" alt="Client 2">
                    <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&h=100&fit=crop&crop=faces" alt="Client 3">
                    <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&h=100&fit=crop&crop=faces" alt="Client 4">
                </div>
                <span>Rated <strong class="text-slate-800 font-bold">4.9/5</strong> by 120+ Founders & CMOs</span>
            </div>

        </div>

        <!-- Hero Graphic Showcase Card -->
        <div class="mt-14 max-w-5xl mx-auto relative">
            <div class="rounded-2xl border border-slate-200/80 bg-white/80 p-2 shadow-2xl backdrop-blur-sm">
                <div class="rounded-xl bg-slate-900 overflow-hidden text-white p-6 sm:p-10 relative">
                    <div class="flex flex-wrap items-center justify-between gap-4 pb-6 border-b border-slate-800">
                        <div>
                            <div class="text-xs uppercase tracking-wider text-agency-400 font-bold">Growth Intelligence Dashboard</div>
                            <div class="text-xl sm:text-2xl font-bold font-heading text-white mt-1">Multi-Channel Acquisition Performance</div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                                ● Real-Time Attribution
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 pt-6">
                        <div class="bg-dark-800/80 p-4 rounded-xl border border-slate-700/50">
                            <span class="text-xs text-slate-400 block">Total Organic ARR</span>
                            <span class="text-2xl sm:text-3xl font-extrabold text-white block mt-1">$4,850,200</span>
                            <span class="text-xs text-emerald-400 font-medium inline-flex items-center gap-1 mt-1">
                                ↑ +142% vs baseline
                            </span>
                        </div>
                        <div class="bg-dark-800/80 p-4 rounded-xl border border-slate-700/50">
                            <span class="text-xs text-slate-400 block">Blended CAC</span>
                            <span class="text-2xl sm:text-3xl font-extrabold text-white block mt-1">$42.80</span>
                            <span class="text-xs text-emerald-400 font-medium inline-flex items-center gap-1 mt-1">
                                ↓ -38% acquisition cost
                            </span>
                        </div>
                        <div class="bg-dark-800/80 p-4 rounded-xl border border-slate-700/50">
                            <span class="text-xs text-slate-400 block">Average ROAS</span>
                            <span class="text-2xl sm:text-3xl font-extrabold text-agency-400 block mt-1">5.4x</span>
                            <span class="text-xs text-slate-300 font-medium inline-flex items-center gap-1 mt-1">
                                High-intent paid ads
                            </span>
                        </div>
                        <div class="bg-dark-800/80 p-4 rounded-xl border border-slate-700/50">
                            <span class="text-xs text-slate-400 block">Monthly MQLs</span>
                            <span class="text-2xl sm:text-3xl font-extrabold text-accent-400 block mt-1">1,480</span>
                            <span class="text-xs text-emerald-400 font-medium inline-flex items-center gap-1 mt-1">
                                ↑ +210% pipeline velocity
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Floating Proof Pills -->
            <div class="hidden md:flex absolute -left-6 -bottom-6 bg-white p-4 rounded-2xl shadow-xl border border-slate-100 items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold">
                    ✓
                </div>
                <div>
                    <div class="text-xs text-slate-400 font-medium">Rankings Updated</div>
                    <div class="text-sm font-bold text-slate-800">+240 First-Page Keywords</div>
                </div>
            </div>

            <div class="hidden md:flex absolute -right-6 -top-6 bg-white p-4 rounded-2xl shadow-xl border border-slate-100 items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-agency-100 text-agency-600 flex items-center justify-center font-bold">
                    ★
                </div>
                <div>
                    <div class="text-xs text-slate-400 font-medium">Google Premier Partner</div>
                    <div class="text-sm font-bold text-slate-800">Top 3% Global Tier</div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- 2. Brand Trust Strip -->
<div class="bg-white py-12 border-y border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-center text-xs font-semibold uppercase tracking-widest text-slate-400 mb-8">
            Trusted By High-Growth Tech Companies & Modern Market Leaders
        </p>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-8 items-center justify-center opacity-60 grayscale hover:grayscale-0 transition-all duration-300">
            <div class="text-center font-extrabold text-xl text-slate-800 tracking-wider">LUMEN</div>
            <div class="text-center font-extrabold text-xl text-slate-800 tracking-wider">STRATA</div>
            <div class="text-center font-extrabold text-xl text-slate-800 tracking-wider">NEXTWAVE</div>
            <div class="text-center font-extrabold text-xl text-slate-800 tracking-wider">ACRONYM</div>
            <div class="text-center font-extrabold text-xl text-slate-800 tracking-wider">SYNERGY</div>
            <div class="text-center font-extrabold text-xl text-slate-800 tracking-wider">PULSE</div>
        </div>
    </div>
</div>

<!-- 3. Key Impact Numbers (Customizer Editable) -->
<section class="py-16 bg-slate-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-y md:divide-y-0 md:divide-x divide-slate-800">
            <?php for ($i = 1; $i <= 4; $i++) : 
                $val = get_theme_mod("agency_stat_{$i}_val", ['1' => '$45M+', '2' => '340%', '3' => '98%', '4' => '150+'][$i]);
                $lbl = get_theme_mod("agency_stat_{$i}_lbl", ['1' => 'Client Revenue Driven', '2' => 'Average ROI Increase', '3' => 'Client Retention Rate', '4' => 'Successful Campaigns'][$i]);
            ?>
                <div class="pt-4 md:pt-0 px-4">
                    <div class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white font-heading tracking-tight mb-2">
                        <?php echo esc_html($val); ?>
                    </div>
                    <div class="text-slate-400 text-sm font-medium">
                        <?php echo esc_html($lbl); ?>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</section>

<!-- 4. Core Services Grid (CPT Query or Default Fallback) -->
<section id="services" class="py-20 lg:py-28 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-3xl mx-auto text-center mb-16">
            <span class="badge-tag mb-3">Our Core Capabilities</span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight font-heading mb-4">
                Full-Funnel Growth Services Engineered For Scale
            </h2>
            <p class="text-lg text-slate-600">
                We eliminate fragmented marketing by unifying acquisition, conversion rate optimization, and brand authority into one high-velocity team.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            $services_query = new WP_Query([
                'post_type'      => 'agency_service',
                'posts_per_page' => 6,
                'orderby'        => 'menu_order date',
                'order'          => 'ASC',
            ]);

            if ($services_query->have_posts()) :
                while ($services_query->have_posts()) : $services_query->the_post();
                    $tagline      = get_post_meta(get_the_ID(), '_agency_service_tagline', true);
                    $price        = get_post_meta(get_the_ID(), '_agency_service_price', true);
                    $deliverables = get_post_meta(get_the_ID(), '_agency_service_deliverables', true);
                    $icon_type    = get_post_meta(get_the_ID(), '_agency_service_icon', true) ?: 'chart';
                    $badge        = get_post_meta(get_the_ID(), '_agency_service_badge', true);
                    $items        = !empty($deliverables) ? array_filter(array_map('trim', explode("\n", $deliverables))) : [];
            ?>
                <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-soft card-hover flex flex-col justify-between relative group">
                    <?php if (!empty($badge)) : ?>
                        <div class="absolute top-6 right-6">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-agency-50 text-agency-700 border border-agency-200">
                                <?php echo esc_html($badge); ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-agency-50 text-agency-600 flex items-center justify-center mb-6 group-hover:bg-agency-600 group-hover:text-white transition-all duration-300 shadow-sm">
                            <?php echo agency_site_get_icon($icon_type, 'w-7 h-7'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        </div>

                        <h3 class="text-xl font-bold text-slate-900 mb-2 font-heading">
                            <a href="<?php the_permalink(); ?>" class="hover:text-agency-600 transition-colors">
                                <?php the_title(); ?>
                            </a>
                        </h3>

                        <?php if ($tagline) : ?>
                            <p class="text-xs font-semibold text-agency-600 mb-3"><?php echo esc_html($tagline); ?></p>
                        <?php endif; ?>

                        <div class="text-slate-600 text-sm leading-relaxed mb-6">
                            <?php the_excerpt(); ?>
                        </div>

                        <?php if (!empty($items)) : ?>
                            <div class="border-t border-slate-100 pt-5 mb-6 space-y-2.5">
                                <?php foreach (array_slice($items, 0, 3) as $deliverable) : ?>
                                    <div class="flex items-start gap-2.5 text-xs text-slate-600">
                                        <svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        <span><?php echo esc_html($deliverable); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-500"><?php echo esc_html($price ?: __('Custom Strategy', 'agency-site')); ?></span>
                        <a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-1.5 text-xs font-bold text-agency-600 hover:text-agency-700 transition-colors group-hover:translate-x-1 duration-200">
                            <span>Learn More</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
                // Render rich default services
                $default_services = agency_site_get_default_services();
                foreach ($default_services as $srv) :
            ?>
                <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-soft card-hover flex flex-col justify-between relative group">
                    <?php if (!empty($srv['badge'])) : ?>
                        <div class="absolute top-6 right-6">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-agency-50 text-agency-700 border border-agency-200">
                                <?php echo esc_html($srv['badge']); ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-agency-50 text-agency-600 flex items-center justify-center mb-6 group-hover:bg-agency-600 group-hover:text-white transition-all duration-300 shadow-sm">
                            <?php echo agency_site_get_icon($srv['icon'], 'w-7 h-7'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        </div>

                        <h3 class="text-xl font-bold text-slate-900 mb-2 font-heading">
                            <?php echo esc_html($srv['title']); ?>
                        </h3>

                        <p class="text-xs font-semibold text-agency-600 mb-3"><?php echo esc_html($srv['tagline']); ?></p>

                        <p class="text-slate-600 text-sm leading-relaxed mb-6">
                            <?php echo esc_html($srv['desc']); ?>
                        </p>

                        <div class="border-t border-slate-100 pt-5 mb-6 space-y-2.5">
                            <?php foreach ($srv['deliverables'] as $deliverable) : ?>
                                <div class="flex items-start gap-2.5 text-xs text-slate-600">
                                    <svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span><?php echo esc_html($deliverable); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-500"><?php echo esc_html($srv['price']); ?></span>
                        <a href="<?php echo esc_url(home_url('/services/')); ?>" class="inline-flex items-center gap-1.5 text-xs font-bold text-agency-600 hover:text-agency-700 transition-colors group-hover:translate-x-1 duration-200">
                            <span>Service Details</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            <?php
                endforeach;
            endif;
            ?>
        </div>

        <div class="mt-14 text-center">
            <a href="<?php echo esc_url(home_url('/services/')); ?>" class="btn-primary !py-3.5 !px-8">
                <span>View Full Service Scope & Process</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>

    </div>
</section>

<!-- 5. Agency Pillars / "Why Choose Us" -->
<section class="py-20 lg:py-28 bg-white border-y border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <div>
                <span class="badge-tag mb-3">The Agency Advantage</span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight font-heading mb-6">
                    Why Fast-Growing Companies Fire Their Big Agencies For Us
                </h2>
                <p class="text-slate-600 text-base sm:text-lg mb-8 leading-relaxed">
                    Most agencies assign your account to junior coordinators after the pitch. At <?php bloginfo('name'); ?>, you work directly with senior growth architects who have managed 8-figure budgets and driven true enterprise revenue.
                </p>

                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-agency-100 text-agency-600 flex items-center justify-center shrink-0 font-bold">
                            01
                        </div>
                        <div>
                            <h4 class="text-base font-bold text-slate-900 mb-1">Zero Vanity Metrics, 100% Revenue Focus</h4>
                            <p class="text-sm text-slate-600">We don’t celebrate impressions or clicks that don’t generate pipeline. Our compensation is aligned with your qualified revenue growth.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-agency-100 text-agency-600 flex items-center justify-center shrink-0 font-bold">
                            02
                        </div>
                        <div>
                            <h4 class="text-base font-bold text-slate-900 mb-1">Agile Weekly Sprints & Real-Time Dashboards</h4>
                            <p class="text-sm text-slate-600">Never wait for a monthly PDF report. Access live attribution dashboards 24/7 with transparent spend and performance analytics.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-agency-100 text-agency-600 flex items-center justify-center shrink-0 font-bold">
                            03
                        </div>
                        <div>
                            <h4 class="text-base font-bold text-slate-900 mb-1">Dedicated Cross-Functional Pod</h4>
                            <p class="text-sm text-slate-600">Every partner gets a dedicated strategist, copywriter, designer, and data analyst embedded as an extension of your in-house team.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Visual Comparison Matrix Card -->
            <div class="bg-slate-50 p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-soft">
                <h3 class="text-lg font-bold text-slate-900 mb-6 font-heading text-center">How We Compare</h3>
                <div class="space-y-4 text-sm">
                    <div class="bg-white p-4 rounded-xl border border-agency-200 shadow-xs flex items-center justify-between">
                        <span class="font-medium text-slate-700">Team Experience</span>
                        <span class="font-bold text-agency-600">Senior Strategists Only</span>
                    </div>
                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-xs flex items-center justify-between">
                        <span class="font-medium text-slate-700">Reporting Cadence</span>
                        <span class="font-bold text-slate-900">Live 24/7 Dashboards</span>
                    </div>
                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-xs flex items-center justify-between">
                        <span class="font-medium text-slate-700">Client Roster Per Lead</span>
                        <span class="font-bold text-agency-600">Max 4 Clients Per Lead</span>
                    </div>
                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-xs flex items-center justify-between">
                        <span class="font-medium text-slate-700">Creative Turnaround</span>
                        <span class="font-bold text-slate-900">48-Hour Rapid Iteration</span>
                    </div>
                    <div class="bg-white p-4 rounded-xl border border-agency-200 shadow-xs flex items-center justify-between">
                        <span class="font-medium text-slate-700">Contract Flexibility</span>
                        <span class="font-bold text-agency-600">Performance & Milestone Based</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 6. Client Testimonials -->
<section class="py-20 lg:py-28 bg-slate-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center mb-16">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-agency-500/20 text-agency-300 border border-agency-500/30 uppercase tracking-widest mb-3">
                Client Testimonials
            </span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight font-heading mb-4">
                What CMOs Say About Working With Us
            </h2>
            <p class="text-slate-400 text-base sm:text-lg">
                Real feedback from real growth leaders who scaled their business with our team.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-dark-800 p-8 rounded-3xl border border-slate-700/60 flex flex-col justify-between">
                <div>
                    <div class="flex text-amber-400 gap-1 mb-4">
                        <?php for ($s = 0; $s < 5; $s++) echo agency_site_get_icon('star', 'w-4 h-4'); // phpcs:ignore ?>
                    </div>
                    <p class="text-slate-300 text-sm leading-relaxed mb-6 italic">
                        "They completely overhauled our organic search architecture and paid acquisition funnel within 90 days. Our organic inbound pipeline grew by 280% year-over-year, and our cost per qualified acquisition dropped by 45%."
                    </p>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-slate-700/50">
                    <img class="w-11 h-11 rounded-full object-cover" src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=100&h=100&fit=crop&crop=faces" alt="Elena Rostova">
                    <div>
                        <h4 class="text-sm font-bold text-white">Elena Rostova</h4>
                        <p class="text-xs text-agency-400">VP of Marketing, CloudScale AI</p>
                    </div>
                </div>
            </div>

            <div class="bg-dark-800 p-8 rounded-3xl border border-slate-700/60 flex flex-col justify-between">
                <div>
                    <div class="flex text-amber-400 gap-1 mb-4">
                        <?php for ($s = 0; $s < 5; $s++) echo agency_site_get_icon('star', 'w-4 h-4'); // phpcs:ignore ?>
                    </div>
                    <p class="text-slate-300 text-sm leading-relaxed mb-6 italic">
                        "Most agencies promise the world and deliver vanity metrics. The team at <?php bloginfo('name'); ?> acts like true equity owners. They restructured our Google & Meta campaigns to generate over $3.2M in attributable ARR."
                    </p>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-slate-700/50">
                    <img class="w-11 h-11 rounded-full object-cover" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&h=100&fit=crop&crop=faces" alt="Marcus Vance">
                    <div>
                        <h4 class="text-sm font-bold text-white">Marcus Vance</h4>
                        <p class="text-xs text-agency-400">Chief Growth Officer, FinTech Nexus</p>
                    </div>
                </div>
            </div>

            <div class="bg-dark-800 p-8 rounded-3xl border border-slate-700/60 flex flex-col justify-between">
                <div>
                    <div class="flex text-amber-400 gap-1 mb-4">
                        <?php for ($s = 0; $s < 5; $s++) echo agency_site_get_icon('star', 'w-4 h-4'); // phpcs:ignore ?>
                    </div>
                    <p class="text-slate-300 text-sm leading-relaxed mb-6 italic">
                        "Their conversion rate optimization sprints alone doubled our landing page conversion rate from 2.1% to 4.6%. That single project paid for our entire annual retainer within the first six weeks."
                    </p>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-slate-700/50">
                    <img class="w-11 h-11 rounded-full object-cover" src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=100&h=100&fit=crop&crop=faces" alt="Sarah Jenkins">
                    <div>
                        <h4 class="text-sm font-bold text-white">Sarah Jenkins</h4>
                        <p class="text-xs text-agency-400">Founder & CEO, Lumina Health</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 7. Latest Articles / Blog Insights -->
<section class="py-20 lg:py-28 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-14 gap-4">
            <div>
                <span class="badge-tag mb-3">Insights & Strategy</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-heading">
                    Latest Thinking From The Growth Frontlines
                </h2>
            </div>
            <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts')) ?: home_url('/blog/')); ?>" class="inline-flex items-center gap-1.5 text-sm font-bold text-agency-600 hover:text-agency-700 transition-colors">
                <span>View All Articles</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php
            $recent_posts = new WP_Query([
                'posts_per_page'      => 3,
                'post_status'         => 'publish',
                'ignore_sticky_posts' => 1,
            ]);

            if ($recent_posts->have_posts()) :
                while ($recent_posts->have_posts()) : $recent_posts->the_post();
            ?>
                <article class="bg-white rounded-3xl overflow-hidden border border-slate-200/80 shadow-soft card-hover flex flex-col">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="block aspect-video overflow-hidden group">
                            <?php the_post_thumbnail('agency-card', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300']); ?>
                        </a>
                    <?php else : ?>
                        <a href="<?php the_permalink(); ?>" class="block aspect-video bg-gradient-to-tr from-agency-700 to-agency-900 p-6 flex items-end">
                            <span class="text-white/80 font-heading font-bold text-lg"><?php the_title(); ?></span>
                        </a>
                    <?php endif; ?>

                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-3 text-xs text-slate-500 mb-3">
                                <?php
                                $categories = get_the_category();
                                if (!empty($categories)) {
                                    echo '<span class="font-semibold text-agency-600 bg-agency-50 px-2.5 py-0.5 rounded-full">' . esc_html($categories[0]->name) . '</span>';
                                }
                                ?>
                                <span><?php echo esc_html(agency_site_reading_time()); ?> min read</span>
                            </div>

                            <h3 class="text-lg font-bold text-slate-900 mb-2 font-heading leading-snug">
                                <a href="<?php the_permalink(); ?>" class="hover:text-agency-600 transition-colors">
                                    <?php the_title(); ?>
                                </a>
                            </h3>

                            <div class="text-slate-600 text-xs sm:text-sm line-clamp-2 mb-4">
                                <?php the_excerpt(); ?>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                            <span><?php echo esc_html(get_the_date('M j, Y')); ?></span>
                            <a href="<?php the_permalink(); ?>" class="font-bold text-agency-600 hover:text-agency-700">Read Article →</a>
                        </div>
                    </div>
                </article>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
                // Fallback demo posts if no WP posts exist yet
                $fallback_posts = [
                    [
                        'title' => 'How to Build an Organic Search Moat in the Age of AI Overviews',
                        'cat'   => 'SEO Strategy',
                        'time'  => '6 min read',
                        'date'  => 'Oct 28, 2026',
                        'desc'  => 'A complete breakdown of our information-gain framework for outranking algorithmic AI answer boxes.',
                    ],
                    [
                        'title' => 'Scaling Meta Ads Past $100K/Month Without CAC Fatigue',
                        'cat'   => 'Paid Media',
                        'time'  => '8 min read',
                        'date'  => 'Oct 19, 2026',
                        'desc'  => 'The modular creative testing system we use to maintain a 3.8+ ROAS at high enterprise budget levels.',
                    ],
                    [
                        'title' => '10 Friction Points Killing Your B2B SaaS Demo Conversion Rate',
                        'cat'   => 'CRO & UX',
                        'time'  => '5 min read',
                        'date'  => 'Oct 12, 2026',
                        'desc'  => 'Real heatmap audits and before-and-after tests showing what actually moves the needle on lead capture.',
                    ],
                ];
                foreach ($fallback_posts as $fp) :
            ?>
                <article class="bg-white rounded-3xl overflow-hidden border border-slate-200/80 shadow-soft card-hover flex flex-col">
                    <div class="aspect-video bg-gradient-to-tr from-agency-800 to-agency-950 p-6 flex items-end">
                        <span class="text-white/80 font-heading font-bold text-sm tracking-wide"><?php echo esc_html($fp['cat']); ?></span>
                    </div>
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-3 text-xs text-slate-500 mb-3">
                                <span class="font-semibold text-agency-600 bg-agency-50 px-2.5 py-0.5 rounded-full"><?php echo esc_html($fp['cat']); ?></span>
                                <span><?php echo esc_html($fp['time']); ?></span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 mb-2 font-heading leading-snug">
                                <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="hover:text-agency-600 transition-colors">
                                    <?php echo esc_html($fp['title']); ?>
                                </a>
                            </h3>
                            <p class="text-slate-600 text-xs sm:text-sm line-clamp-2 mb-4">
                                <?php echo esc_html($fp['desc']); ?>
                            </p>
                        </div>
                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                            <span><?php echo esc_html($fp['date']); ?></span>
                            <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="font-bold text-agency-600 hover:text-agency-700">Read Article →</a>
                        </div>
                    </div>
                </article>
            <?php
                endforeach;
            endif;
            ?>
        </div>

    </div>
</section>

<?php
get_footer();

