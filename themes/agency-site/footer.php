<?php
/**
 * Theme Footer
 *
 * @package Agency_Site
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
</main><!-- #main-content -->

<!-- Pre-Footer Conversion Banner -->
<?php get_template_part('template-parts/cta-banner'); ?>

<!-- Main Footer -->
<footer id="colophon" class="bg-dark-900 text-slate-400 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 lg:gap-8">
            
            <!-- Column 1: Brand & Bio (2 cols wide on desktop) -->
            <div class="lg:col-span-2 space-y-6">
                <div class="flex items-center gap-2.5">
                    <span class="w-9 h-9 rounded-xl bg-gradient-to-tr from-agency-600 to-accent-600 flex items-center justify-center text-white font-bold text-lg shadow-md">
                        A
                    </span>
                    <span class="font-heading font-extrabold text-xl text-white tracking-tight">
                        <?php bloginfo('name'); ?>
                    </span>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed max-w-sm">
                    We are a full-funnel digital marketing agency engineered for high-growth tech companies, modern DTC brands, and ambitious enterprises seeking measurable ROI.
                </p>
                <!-- Social Profiles -->
                <div class="flex items-center gap-3 pt-2">
                    <?php
                    $socials = [
                        'twitter'   => ['name' => 'Twitter/X', 'icon' => '<path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>'],
                        'linkedin'  => ['name' => 'LinkedIn', 'icon' => '<path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>'],
                        'instagram' => ['name' => 'Instagram', 'icon' => '<path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>'],
                        'github'    => ['name' => 'GitHub', 'icon' => '<path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>'],
                    ];
                    foreach ($socials as $slug => $data) :
                        $url = get_theme_mod("agency_social_{$slug}", "https://{$slug}.com");
                        if ($url) :
                    ?>
                        <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-lg bg-dark-800 border border-slate-700/60 flex items-center justify-center text-slate-400 hover:text-white hover:bg-agency-600 hover:border-agency-500 transition-all duration-200" aria-label="<?php echo esc_attr($data['name']); ?>">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                <?php echo $data['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            </svg>
                        </a>
                    <?php
                        endif;
                    endforeach;
                    ?>
                </div>
            </div>

            <!-- Column 2: Core Solutions -->
            <div>
                <h4 class="text-white font-semibold text-sm tracking-wide uppercase mb-4">Solutions</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="<?php echo esc_url(home_url('/services/')); ?>#seo" class="hover:text-agency-400 transition-colors">Search Engine Optimization</a></li>
                    <li><a href="<?php echo esc_url(home_url('/services/')); ?>#ppc" class="hover:text-agency-400 transition-colors">Paid Ads & Performance</a></li>
                    <li><a href="<?php echo esc_url(home_url('/services/')); ?>#cro" class="hover:text-agency-400 transition-colors">Conversion Rate Optimization</a></li>
                    <li><a href="<?php echo esc_url(home_url('/services/')); ?>#content" class="hover:text-agency-400 transition-colors">Content & Brand PR</a></li>
                    <li><a href="<?php echo esc_url(home_url('/services/')); ?>#web" class="hover:text-agency-400 transition-colors">Growth Web Development</a></li>
                </ul>
            </div>

            <!-- Column 3: Navigation -->
            <div>
                <h4 class="text-white font-semibold text-sm tracking-wide uppercase mb-4">Company</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-agency-400 transition-colors">Home</a></li>
                    <li><a href="<?php echo esc_url(home_url('/services/')); ?>" class="hover:text-agency-400 transition-colors">Services & Pricing</a></li>
                    <li><a href="<?php echo esc_url(home_url('/blog/')); ?>" class="hover:text-agency-400 transition-colors">Blog & Case Studies</a></li>
                    <li><a href="<?php echo esc_url(home_url('/contact/')); ?>" class="hover:text-agency-400 transition-colors">Contact & Consultation</a></li>
                    <li><a href="<?php echo esc_url(admin_url()); ?>" class="hover:text-agency-400 transition-colors text-slate-500">WP Dashboard</a></li>
                </ul>
            </div>

            <!-- Column 4: Contact & Location -->
            <div>
                <h4 class="text-white font-semibold text-sm tracking-wide uppercase mb-4">Headquarters</h4>
                <div class="space-y-3 text-sm text-slate-400">
                    <p class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-agency-400 mt-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span><?php echo nl2br(esc_html(get_theme_mod('agency_address', "100 Innovation Blvd, Suite 400\nSan Francisco, CA 94105"))); ?></span>
                    </p>
                    <p class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-agency-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <a href="tel:<?php echo esc_attr(get_theme_mod('agency_phone', '+1 (800) 555-0199')); ?>" class="hover:text-white transition-colors">
                            <?php echo esc_html(get_theme_mod('agency_phone', '+1 (800) 555-0199')); ?>
                        </a>
                    </p>
                    <p class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-agency-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="text-xs"><?php echo esc_html(get_theme_mod('agency_hours', 'Mon – Fri: 9:00 AM – 6:00 PM PST')); ?></span>
                    </p>
                </div>
            </div>

        </div>

        <!-- Bottom Bar -->
        <div class="mt-16 pt-8 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <p>© <?php echo esc_html(gmdate('Y')); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('All rights reserved. Built with WordPress & Tailwind CSS.', 'agency-site'); ?></p>
            <div class="flex items-center gap-6">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-slate-400 transition-colors">Privacy Policy</a>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-slate-400 transition-colors">Terms of Service</a>
                <button id="back-to-top" type="button" class="inline-flex items-center gap-1 hover:text-white transition-colors cursor-pointer" aria-label="<?php esc_attr_e('Back to top of page', 'agency-site'); ?>">
                    <span>Top</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                </button>
            </div>
        </div>

    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

