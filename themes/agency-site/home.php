<?php
/**
 * The Blog Listing Template
 *
 * @package Agency_Site
 */

get_header();
?>

<!-- Blog Hero -->
<section class="py-16 md:py-20 bg-gradient-to-b from-white via-agency-50/40 to-slate-50 border-b border-slate-200/60">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="badge-tag mb-4">Growth Intelligence</span>
        <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight font-heading mb-4">
            Insights, Playbooks & Acquisition Strategies
        </h1>
        <p class="text-lg text-slate-600 max-w-2xl mx-auto">
            Practical teardowns, SEO data experiments, and performance marketing lessons learned from managing 8-figure growth budgets.
        </p>

        <!-- Category Pills -->
        <?php
        $categories = get_categories(['hide_empty' => true]);
        if (!empty($categories)) :
        ?>
            <div class="mt-8 flex flex-wrap items-center justify-center gap-2">
                <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts')) ?: home_url('/blog/')); ?>" class="px-4 py-1.5 rounded-full text-xs font-bold transition-colors bg-agency-600 text-white shadow-xs">
                    All Articles
                </a>
                <?php foreach ($categories as $cat) : ?>
                    <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="px-4 py-1.5 rounded-full text-xs font-semibold text-slate-600 bg-white border border-slate-200 hover:border-agency-300 hover:text-agency-600 transition-colors shadow-xs">
                        <?php echo esc_html($cat->name); ?> (<?php echo esc_html($cat->count); ?>)
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Blog Content & Sidebar Grid -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        
        <!-- Main Articles Column (8 cols) -->
        <div class="lg:col-span-8 space-y-12">
            
            <?php
            if (have_posts()) :
                $post_count = 0;
                while (have_posts()) : the_post();
                    $post_count++;
                    
                    // Highlight first post on page 1 as featured article
                    if ($post_count === 1 && !is_paged()) :
            ?>
                <!-- Featured Article Highlight -->
                <article class="bg-white rounded-3xl overflow-hidden border border-slate-200/80 shadow-soft card-hover group">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="block aspect-[21/9] overflow-hidden">
                            <?php the_post_thumbnail('agency-hero', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300']); ?>
                        </a>
                    <?php else : ?>
                        <a href="<?php the_permalink(); ?>" class="block aspect-[21/9] bg-gradient-to-tr from-agency-800 to-dark-900 p-8 flex items-end">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-agency-500/30 text-white border border-white/20">Featured Deep Dive</span>
                        </a>
                    <?php endif; ?>

                    <div class="p-8 sm:p-10">
                        <div class="flex items-center gap-3 text-xs text-slate-500 mb-4">
                            <?php
                            $cats = get_the_category();
                            if (!empty($cats)) {
                                echo '<span class="font-bold text-agency-600 bg-agency-50 px-3 py-1 rounded-full">' . esc_html($cats[0]->name) . '</span>';
                            }
                            ?>
                            <span class="text-slate-300">•</span>
                            <span><?php echo esc_html(get_the_date('F j, Y')); ?></span>
                            <span class="text-slate-300">•</span>
                            <span><?php echo esc_html(agency_site_reading_time()); ?> min read</span>
                        </div>

                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading mb-4 leading-tight group-hover:text-agency-600 transition-colors">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h2>

                        <div class="text-slate-600 text-sm sm:text-base leading-relaxed mb-6">
                            <?php the_excerpt(); ?>
                        </div>

                        <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <?php echo get_avatar(get_the_author_meta('ID'), 40, '', '', ['class' => 'rounded-full border border-slate-200']); ?>
                                <div>
                                    <span class="block text-xs font-bold text-slate-900"><?php the_author(); ?></span>
                                    <span class="block text-[11px] text-slate-400">Growth Strategist</span>
                                </div>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="btn-primary !py-2.5 !px-5 text-xs">
                                <span>Read Full Breakdown</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </article>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 pt-6">
            <?php
                    continue;
                    endif;

                    // If we passed the featured post, open grid
                    if ($post_count === 2 && !is_paged()) {
                        // grid already opened above
                    } elseif ($post_count === 1 && is_paged()) {
                        echo '<div class="grid grid-cols-1 sm:grid-cols-2 gap-8">';
                    }
            ?>
                    <article class="bg-white rounded-3xl overflow-hidden border border-slate-200/80 shadow-soft card-hover flex flex-col justify-between">
                        <div>
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>" class="block aspect-video overflow-hidden group">
                                    <?php the_post_thumbnail('agency-card', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300']); ?>
                                </a>
                            <?php else : ?>
                                <a href="<?php the_permalink(); ?>" class="block aspect-video bg-gradient-to-tr from-agency-700 to-agency-950 p-6 flex items-end">
                                    <span class="text-white/80 font-bold text-sm"><?php the_title(); ?></span>
                                </a>
                            <?php endif; ?>

                            <div class="p-6">
                                <div class="flex items-center gap-2 text-xs text-slate-500 mb-3">
                                    <?php
                                    $cats = get_the_category();
                                    if (!empty($cats)) {
                                        echo '<span class="font-semibold text-agency-600 bg-agency-50 px-2.5 py-0.5 rounded-full">' . esc_html($cats[0]->name) . '</span>';
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
                        </div>

                        <div class="px-6 pb-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                            <span><?php echo esc_html(get_the_date('M j, Y')); ?></span>
                            <a href="<?php the_permalink(); ?>" class="font-bold text-agency-600 hover:text-agency-700">Read More →</a>
                        </div>
                    </article>
            <?php
                endwhile;

                // Close grid if opened
                if ($post_count > 1 || is_paged()) {
                    echo '</div>';
                }
            ?>

            <!-- Pagination -->
            <div class="pt-8">
                <?php agency_site_pagination(); ?>
            </div>

            <?php
            else :
            ?>
                <div class="bg-white rounded-3xl p-12 text-center border border-slate-200">
                    <h3 class="text-xl font-bold text-slate-900 font-heading mb-2">No Articles Published Yet</h3>
                    <p class="text-slate-600 text-sm mb-6">Our editors are working on new growth teardowns. Check back soon or visit our services page.</p>
                    <a href="<?php echo esc_url(home_url('/services/')); ?>" class="btn-primary">Explore Services</a>
                </div>
            <?php
            endif;
            ?>

        </div>

        <!-- Sidebar Column (4 cols) -->
        <aside class="lg:col-span-4 space-y-8">
            
            <!-- Custom Search Widget -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-soft">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">Search Knowledgebase</h3>
                <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="flex gap-2">
                    <input 
                        type="search" 
                        name="s" 
                        value="<?php echo esc_attr(get_search_query()); ?>" 
                        placeholder="Search growth topics..." 
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-agency-500"
                    >
                    <button type="submit" class="btn-primary !px-4 !py-2.5" aria-label="<?php esc_attr_e('Submit search', 'agency-site'); ?>">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </form>
            </div>

            <!-- Strategic Newsletter / Lead Magnet Card -->
            <div class="bg-gradient-to-br from-agency-900 to-dark-900 text-white p-8 rounded-3xl border border-slate-800 shadow-soft space-y-4">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-bold bg-agency-500 text-white uppercase tracking-wider">Growth Dispatch</span>
                <h3 class="text-xl font-bold font-heading text-white">Get Bi-Weekly Growth Teardowns</h3>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Join 14,000+ founders and digital marketers receiving our uncensored analysis on algorithmic shifts, ad frameworks, and CRO experiments.
                </p>
                <form onsubmit="event.preventDefault(); alert('Subscribed! Welcome to the Growth Dispatch.');" class="space-y-3 pt-2">
                    <input type="email" required placeholder="Enter work email..." class="w-full px-4 py-2.5 rounded-xl bg-dark-800 border border-slate-700 text-white placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-agency-400">
                    <button type="submit" class="btn-primary !bg-agency-500 hover:!bg-agency-400 w-full !py-2.5 text-xs font-bold">Subscribe Free</button>
                </form>
            </div>

            <!-- Standard WordPress Sidebar Dynamic Widgets -->
            <?php if (is_active_sidebar('sidebar-1')) : ?>
                <div class="sidebar-dynamic-widgets">
                    <?php dynamic_sidebar('sidebar-1'); ?>
                </div>
            <?php endif; ?>

        </aside>

    </div>
</div>

<?php
get_footer();

