<?php
/**
 * The template for displaying archive pages
 *
 * @package Agency_Site
 */

get_header();
?>

<div class="py-16 md:py-20 bg-gradient-to-b from-white via-agency-50/40 to-slate-50 border-b border-slate-200/60">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="badge-tag mb-4">Archive View</span>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight font-heading mb-4">
            <?php the_archive_title(); ?>
        </h1>
        <?php if (get_the_archive_description()) : ?>
            <div class="text-slate-600 text-sm max-w-xl mx-auto">
                <?php the_archive_description(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <?php if (have_posts()) : ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php while (have_posts()) : the_post(); ?>
                <article class="bg-white rounded-3xl overflow-hidden border border-slate-200/80 shadow-soft card-hover flex flex-col justify-between">
                    <div>
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" class="block aspect-video overflow-hidden group">
                                <?php the_post_thumbnail('agency-card', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300']); ?>
                            </a>
                        <?php else : ?>
                            <a href="<?php the_permalink(); ?>" class="block aspect-video bg-gradient-to-tr from-agency-800 to-dark-900 p-6 flex items-end">
                                <span class="text-white/80 font-bold text-sm"><?php the_title(); ?></span>
                            </a>
                        <?php endif; ?>

                        <div class="p-6">
                            <div class="flex items-center gap-2 text-xs text-slate-500 mb-3">
                                <span><?php echo esc_html(get_the_date('M j, Y')); ?></span>
                                <span>•</span>
                                <span><?php echo esc_html(agency_site_reading_time()); ?> min read</span>
                            </div>

                            <h2 class="text-lg font-bold text-slate-900 mb-2 font-heading leading-snug">
                                <a href="<?php the_permalink(); ?>" class="hover:text-agency-600 transition-colors">
                                    <?php the_title(); ?>
                                </a>
                            </h2>

                            <div class="text-slate-600 text-xs sm:text-sm line-clamp-2 mb-4">
                                <?php the_excerpt(); ?>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 pb-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                        <span>By <?php the_author(); ?></span>
                        <a href="<?php the_permalink(); ?>" class="font-bold text-agency-600 hover:text-agency-700">Read Article →</a>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <div class="pt-12">
            <?php agency_site_pagination(); ?>
        </div>
    <?php else : ?>
        <div class="bg-white rounded-3xl p-12 text-center border border-slate-200">
            <h2 class="text-xl font-bold text-slate-900 font-heading mb-2">No Articles Found</h2>
            <p class="text-slate-600 text-sm mb-6">There are no articles listed under this archive yet.</p>
            <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="btn-primary">Browse All Articles</a>
        </div>
    <?php endif; ?>
</div>

<?php
get_footer();

