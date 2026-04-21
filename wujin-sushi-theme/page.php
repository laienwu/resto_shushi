<?php
/**
 * Template for displaying pages.
 *
 * @package Wujin_Sushi
 */

get_header();
?>

<main id="primary" class="site-main site-shell">
    <?php
    while (have_posts()) :
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('entry-card'); ?>>
            <header class="page-header">
                <p class="eyebrow"><?php esc_html_e('Page', 'wujin-sushi'); ?></p>
                <h1 class="entry-title"><?php the_title(); ?></h1>
                <?php if (has_excerpt()) : ?>
                    <p class="entry-summary"><?php echo esc_html(get_the_excerpt()); ?></p>
                <?php endif; ?>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <div class="entry-thumbnail">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>

            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<?php
get_footer();
