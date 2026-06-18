<?php
/**
 * The template for displaying search results
 *
 * @package Agency_Site
 */

get_header();
?>

<div class="py-16 md:py-20 bg-gradient-to-b from-white via-agency-50/40 to-slate-50 border-b border-slate-200/60">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="badge-tag mb-4">Search Results</span>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight font-heading mb-4">
            Results for: "<?php echo esc_html(get_search_query()); ?>"
        </h1>
        <p class="text-sm text-slate-500">
            Found <?php echo esc_html((string)$wp_query->found_posts); ?> matching articles or resources
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <?php if (have_posts()) : ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php while (have_posts()) : the_post(); ?>
                <article class="bg-white rounded-3xl overflow-hidden border border-slate-200/80 shadow-soft card-hover flex flex-col justify-between">
                    <div class="p-6">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-agency-600 block mb-2">
                            <?php echo esc_html(get_post_type()); ?>
                        </span>
                        <h2 class="text-lg font-bold text-slate-900 mb-2 font-heading leading-snug">
                            <a href="<?php the_permalink(); ?>" class="hover:text-agency-600 transition-colors">
                                <?php the_title(); ?>
                            </a>
                        </h2>
                        <div class="text-slate-600 text-xs sm:text-sm line-clamp-3 mb-4">
                            <?php the_excerpt(); ?>
                        </div>
                    </div>
                    <div class="px-6 pb-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                        <span><?php echo esc_html(get_the_date('M j, Y')); ?></span>
                        <a href="<?php the_permalink(); ?>" class="font-bold text-agency-600 hover:text-agency-700">Read More →</a>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <div class="pt-12">
            <?php agency_site_pagination(); ?>
        </div>
    <?php else : ?>
        <div class="bg-white rounded-3xl p-12 text-center max-w-xl mx-auto border border-slate-200">
            <h2 class="text-xl font-bold text-slate-900 font-heading mb-2">No Matching Results</h2>
            <p class="text-slate-600 text-sm mb-6">We couldn’t find anything matching your search term. Try searching for "SEO", "Ads", "Content", or "Design".</p>
            <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="flex gap-2">
                <input 
                    type="search" 
                    name="s" 
                    placeholder="Try another keyword..." 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-agency-500"
                >
                <button type="submit" class="btn-primary !px-5 !py-2.5 text-xs">Search</button>
            </form>
        </div>
    <?php endif; ?>
</div>

<?php
get_footer();

