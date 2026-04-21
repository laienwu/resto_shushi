<?php
/**
 * Main template file.
 *
 * @package Wujin_Sushi
 */

get_header();
?>

<main id="primary" class="site-main site-shell page-layout">
    <div class="content-area">
        <header class="page-header page-header-simple">
            <p class="eyebrow"><?php esc_html_e('Blog', 'wujin-sushi'); ?></p>
            <h1><?php echo esc_html(get_bloginfo('name')); ?></h1>
            <p><?php esc_html_e('News, updates, and stories from the restaurant.', 'wujin-sushi'); ?></p>
        </header>

        <?php if (have_posts()) : ?>
            <div class="post-grid">
                <?php
                while (have_posts()) :
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('card-post'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <a class="card-media" href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('large'); ?>
                            </a>
                        <?php endif; ?>

                        <div class="card-content">
                            <p class="card-meta"><?php echo esc_html(get_the_date()); ?></p>
                            <h2 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <p><?php echo esc_html(get_the_excerpt() ?: wp_trim_words(wp_strip_all_tags(get_the_content()), 28)); ?></p>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php the_posts_navigation(); ?>
        <?php else : ?>
            <section class="empty-state">
                <h2><?php esc_html_e('No posts yet.', 'wujin-sushi'); ?></h2>
                <p><?php esc_html_e('Publish your first post from the WordPress dashboard to populate this page.', 'wujin-sushi'); ?></p>
            </section>
        <?php endif; ?>
    </div>

    <?php get_sidebar(); ?>
</main>

<?php
get_footer();
