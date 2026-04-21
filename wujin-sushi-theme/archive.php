<?php
/**
 * Template for displaying archives.
 *
 * @package Wujin_Sushi
 */

get_header();

$wujin_sushi_title       = post_type_archive_title('', false);
$wujin_sushi_description = get_the_archive_description();

if (is_tax()) {
    $wujin_sushi_title = single_term_title('', false);
}
?>

<main id="primary" class="site-main site-shell">
    <header class="page-header page-header-simple">
        <p class="eyebrow"><?php esc_html_e('Archive', 'wujin-sushi'); ?></p>
        <h1><?php echo esc_html($wujin_sushi_title ?: __('Contenu', 'wujin-sushi')); ?></h1>
        <?php if ($wujin_sushi_description) : ?>
            <div class="entry-content"><?php echo wp_kses_post(wpautop($wujin_sushi_description)); ?></div>
        <?php endif; ?>
    </header>

    <?php if (have_posts()) : ?>
        <div class="<?php echo esc_attr((is_post_type_archive('menu_item') || is_tax('menu_category')) ? 'menu-grid' : 'post-grid'); ?>">
            <?php
            while (have_posts()) :
                the_post();

                if (get_post_type() === 'menu_item') :
                    $wujin_sushi_terms = wujin_sushi_get_menu_terms();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('menu-card'); ?>>
                        <a class="menu-card-image" href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('wujin-sushi-menu-card'); ?>
                            <?php endif; ?>
                        </a>
                        <div class="menu-card-body">
                            <div class="menu-card-top">
                                <?php if (wujin_sushi_get_menu_item_badge()) : ?>
                                    <span class="menu-badge"><?php echo esc_html(wujin_sushi_get_menu_item_badge()); ?></span>
                                <?php endif; ?>
                                <?php if (wujin_sushi_get_menu_item_price()) : ?>
                                    <span class="menu-price"><?php echo esc_html(wujin_sushi_get_menu_item_price()); ?></span>
                                <?php endif; ?>
                            </div>
                            <h2 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <p><?php echo esc_html(get_the_excerpt() ?: wp_trim_words(wp_strip_all_tags(get_the_content()), 22)); ?></p>
                            <?php if (! empty($wujin_sushi_terms)) : ?>
                                <ul class="term-list">
                                    <?php foreach ($wujin_sushi_terms as $wujin_sushi_term) : ?>
                                        <li><a href="<?php echo esc_url(get_term_link($wujin_sushi_term)); ?>"><?php echo esc_html($wujin_sushi_term->name); ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php else : ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('card-post'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <a class="card-media" href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('large'); ?>
                            </a>
                        <?php endif; ?>

                        <div class="card-content">
                            <p class="card-meta"><?php echo esc_html(get_the_date()); ?></p>
                            <h2 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <p><?php echo esc_html(get_the_excerpt() ?: wp_trim_words(wp_strip_all_tags(get_the_content()), 24)); ?></p>
                        </div>
                    </article>
                <?php endif; ?>
            <?php endwhile; ?>
        </div>

        <?php the_posts_navigation(); ?>
    <?php else : ?>
        <section class="empty-state">
            <h2><?php esc_html_e('Nothing found.', 'wujin-sushi'); ?></h2>
            <p><?php esc_html_e('Add content from the WordPress dashboard and it will appear here automatically.', 'wujin-sushi'); ?></p>
        </section>
    <?php endif; ?>
</main>

<?php
get_footer();
