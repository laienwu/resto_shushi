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
        $wujin_sushi_reference_upc  = $wujin_sushi_is_menu_item ? trim((string) get_post_meta(get_the_ID(), '_wujin_sushi_reference_upc', true)) : '';
        $wujin_sushi_reference_name = $wujin_sushi_is_menu_item ? trim((string) get_post_meta(get_the_ID(), '_wujin_sushi_reference_name', true)) : '';
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class($wujin_sushi_is_menu_item ? 'entry-card menu-single-card' : 'entry-card'); ?>>
            <?php if ($wujin_sushi_is_menu_item) : ?>
                <a class="menu-single-return" href="<?php echo esc_url(home_url('/#menu')); ?>"><?php esc_html_e('Retourner', 'wujin-sushi'); ?></a>

                <div class="menu-single-layout">
                    <div class="menu-single-media">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="entry-thumbnail">
                                <?php the_post_thumbnail('large'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (wujin_sushi_is_menu_item_featured()) : ?>
                            <div class="meilleur_vente menu-single-popular"><?php esc_html_e('Populaire', 'wujin-sushi'); ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="menu-single-summary">
                        <?php if ($wujin_sushi_reference_upc) : ?>
                            <p class="menu-single-upc"><?php echo esc_html($wujin_sushi_reference_upc); ?></p>
                        <?php endif; ?>

                        <header class="page-header menu-single-header">
                            <h1 class="entry-title"><?php echo esc_html($wujin_sushi_reference_name ?: get_the_title()); ?></h1>

                            <div class="entry-meta">
                                <?php if (wujin_sushi_get_menu_item_price()) : ?>
                                    <span class="menu-price"><?php echo esc_html(wujin_sushi_get_menu_item_price()); ?></span>
                                <?php endif; ?>

                                <?php if (wujin_sushi_get_menu_item_badge()) : ?>
                                    <span class="menu-badge"><?php echo esc_html(wujin_sushi_get_menu_item_badge()); ?></span>
                                <?php endif; ?>
                            </div>

                            <?php if (has_excerpt()) : ?>
                                <p class="entry-summary"><?php echo esc_html(get_the_excerpt()); ?></p>
                            <?php endif; ?>

                            <?php if (! empty($wujin_sushi_terms)) : ?>
                                <ul class="term-list">
                                    <?php foreach ($wujin_sushi_terms as $wujin_sushi_term) : ?>
                                        <li><a href="<?php echo esc_url(get_term_link($wujin_sushi_term)); ?>"><?php echo esc_html($wujin_sushi_term->name); ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </header>
                    </div>
                </div>

                <div class="entry-content menu-single-content">
                    <?php the_content(); ?>
                </div>
            <?php else : ?>
                <header class="page-header">
                    <p class="eyebrow">
                        <?php esc_html_e('Article', 'wujin-sushi'); ?>
                    </p>
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-meta">
                        <span class="card-meta"><?php echo esc_html(get_the_date()); ?></span>
                    </div>

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
            <?php endif; ?>
        </article>

        <?php the_post_navigation(); ?>
    <?php endwhile; ?>
</main>

<?php
get_footer();
