<?php
/**
 * Template for displaying single posts and menu items.
 *
 * @package Wujin_Sushi
 */

get_header();
?>

<main id="primary" class="site-main site-shell">
    <?php
    while (have_posts()) :
        the_post();

        $wujin_sushi_is_menu_item = get_post_type() === 'menu_item';
        $wujin_sushi_terms        = $wujin_sushi_is_menu_item ? wujin_sushi_get_menu_terms() : array();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('entry-card'); ?>>
            <header class="page-header">
                <p class="eyebrow">
                    <?php echo esc_html($wujin_sushi_is_menu_item ? __('Plat', 'wujin-sushi') : __('Article', 'wujin-sushi')); ?>
                </p>
                <h1 class="entry-title"><?php the_title(); ?></h1>

                <div class="entry-meta">
                    <?php if ($wujin_sushi_is_menu_item && wujin_sushi_get_menu_item_price()) : ?>
                        <span class="menu-price"><?php echo esc_html(wujin_sushi_get_menu_item_price()); ?></span>
                    <?php else : ?>
                        <span class="card-meta"><?php echo esc_html(get_the_date()); ?></span>
                    <?php endif; ?>

                    <?php if ($wujin_sushi_is_menu_item && wujin_sushi_get_menu_item_badge()) : ?>
                        <span class="menu-badge"><?php echo esc_html(wujin_sushi_get_menu_item_badge()); ?></span>
                    <?php endif; ?>
                </div>

                <?php if (! empty($wujin_sushi_terms)) : ?>
                    <ul class="term-list">
                        <?php foreach ($wujin_sushi_terms as $wujin_sushi_term) : ?>
                            <li><a href="<?php echo esc_url(get_term_link($wujin_sushi_term)); ?>"><?php echo esc_html($wujin_sushi_term->name); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

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

        <?php the_post_navigation(); ?>
    <?php endwhile; ?>
</main>

<?php
get_footer();
