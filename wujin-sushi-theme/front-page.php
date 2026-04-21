<?php
/**
 * Front page template.
 *
 * @package Wujin_Sushi
 */

get_header();

$wujin_sushi_hero_heading      = wujin_sushi_get_theme_option('hero_heading', get_bloginfo('name'));
$wujin_sushi_hero_subheading   = wujin_sushi_get_theme_option('hero_subheading', get_bloginfo('description'));
$wujin_sushi_hero_description  = wujin_sushi_get_theme_option('hero_description');
$wujin_sushi_announcement      = wujin_sushi_get_theme_option('announcement_text');
$wujin_sushi_about_title       = wujin_sushi_get_theme_option('about_title');
$wujin_sushi_about_text        = wujin_sushi_get_theme_option('about_text');
$wujin_sushi_address           = wujin_sushi_get_theme_option('address', '15 Bd du Temple, 75003 Paris');
$wujin_sushi_phone             = wujin_sushi_get_theme_option('phone', '09 54 97 63 96');
$wujin_sushi_email             = wujin_sushi_get_theme_option('email', 'bonjour@wujinsushi.fr');
$wujin_sushi_order_url         = wujin_sushi_get_theme_option('order_url', home_url('/#menu'));
$wujin_sushi_reservation_url   = wujin_sushi_get_theme_option('reservation_url', home_url('/#contact'));
$wujin_sushi_front_page_id     = get_queried_object_id();
$wujin_sushi_front_page_markup = '';
$wujin_sushi_menu_terms        = get_terms(
    array(
        'taxonomy'   => 'menu_category',
        'hide_empty' => false,
        'number'     => 8,
    )
);

if ($wujin_sushi_front_page_id) {
    $wujin_sushi_front_page_markup = trim((string) apply_filters('the_content', get_post_field('post_content', $wujin_sushi_front_page_id)));
}

$wujin_sushi_featured_menu_items = new WP_Query(
    array(
        'post_type'      => 'menu_item',
        'posts_per_page' => 6,
        'post_status'    => 'publish',
        'meta_key'       => '_wujin_sushi_featured',
        'meta_value'     => '1',
        'orderby'        => array(
            'menu_order' => 'ASC',
            'date'       => 'DESC',
        ),
    )
);

if (! $wujin_sushi_featured_menu_items->have_posts()) {
    $wujin_sushi_featured_menu_items = new WP_Query(
        array(
            'post_type'      => 'menu_item',
            'posts_per_page' => 6,
            'post_status'    => 'publish',
            'orderby'        => array(
                'menu_order' => 'ASC',
                'date'       => 'DESC',
            ),
        )
    );
}

$wujin_sushi_latest_posts = new WP_Query(
    array(
        'post_type'      => 'post',
        'posts_per_page' => 3,
        'post_status'    => 'publish',
    )
);
?>

<main id="primary" class="site-main">
    <div class="site-shell">
        <section class="hero">
            <div class="hero-content">
                <p class="eyebrow"><?php esc_html_e('Restaurant japonais et tibetain', 'wujin-sushi'); ?></p>
                <h1 class="hero-title"><?php echo esc_html($wujin_sushi_hero_heading); ?></h1>

                <?php if ($wujin_sushi_hero_subheading) : ?>
                    <p class="hero-subtitle"><?php echo esc_html($wujin_sushi_hero_subheading); ?></p>
                <?php endif; ?>

                <?php if ($wujin_sushi_hero_description) : ?>
                    <p class="hero-text"><?php echo esc_html($wujin_sushi_hero_description); ?></p>
                <?php endif; ?>

                <div class="hero-actions">
                    <a class="button button-primary" href="<?php echo esc_url($wujin_sushi_order_url); ?>"><?php esc_html_e('Voir la carte', 'wujin-sushi'); ?></a>
                    <a class="button button-secondary" href="<?php echo esc_url($wujin_sushi_reservation_url); ?>"><?php esc_html_e('Reserver une table', 'wujin-sushi'); ?></a>
                </div>

                <?php if ($wujin_sushi_announcement) : ?>
                    <p class="hero-note"><?php echo esc_html($wujin_sushi_announcement); ?></p>
                <?php endif; ?>
            </div>

            <aside class="hero-panel" aria-label="<?php esc_attr_e('Restaurant information', 'wujin-sushi'); ?>">
                <div class="hero-panel-card">
                    <h2><?php esc_html_e('Adresse', 'wujin-sushi'); ?></h2>
                    <p><?php echo esc_html($wujin_sushi_address); ?></p>
                </div>

                <div class="hero-panel-card">
                    <h2><?php esc_html_e('Telephone', 'wujin-sushi'); ?></h2>
                    <p><a href="<?php echo esc_url('tel:' . wujin_sushi_get_phone_uri($wujin_sushi_phone)); ?>"><?php echo esc_html($wujin_sushi_phone); ?></a></p>
                </div>

                <div class="hero-panel-card">
                    <h3><?php esc_html_e('Horaires', 'wujin-sushi'); ?></h3>
                    <ul class="hero-panel-list">
                        <?php foreach (wujin_sushi_get_opening_hours_lines() as $wujin_sushi_line) : ?>
                            <li><?php echo esc_html($wujin_sushi_line); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </aside>
        </section>

        <section class="section">
            <div class="section-card">
                <div class="info-grid">
                    <div class="info-card">
                        <h3><?php esc_html_e('Commande', 'wujin-sushi'); ?></h3>
                        <p><?php esc_html_e('Redirigez ce bouton vers WooCommerce, Uber Eats, ou votre module de commande existant.', 'wujin-sushi'); ?></p>
                    </div>

                    <div class="info-card">
                        <h3><?php esc_html_e('Reservations', 'wujin-sushi'); ?></h3>
                        <p><?php esc_html_e('Branchez le lien de reservation vers un plugin WordPress ou une solution externe.', 'wujin-sushi'); ?></p>
                    </div>

                    <div class="info-card">
                        <h3><?php esc_html_e('Administration', 'wujin-sushi'); ?></h3>
                        <p><?php esc_html_e('Le menu, les textes d accueil, les coordonnees, et les liens sont maintenant gerables depuis WordPress.', 'wujin-sushi'); ?></p>
                    </div>
                </div>
            </div>
        </section>

        <section class="section" id="menu">
            <div class="section-card">
                <div class="section-head">
                    <div>
                        <p class="eyebrow"><?php esc_html_e('La carte', 'wujin-sushi'); ?></p>
                        <h2><?php esc_html_e('Categories de menu', 'wujin-sushi'); ?></h2>
                        <p><?php esc_html_e('Ces categories sont modifiables depuis l administration WordPress via Menu Items > Menu Categories.', 'wujin-sushi'); ?></p>
                    </div>
                </div>

                <div class="category-grid">
                    <?php if (! is_wp_error($wujin_sushi_menu_terms) && ! empty($wujin_sushi_menu_terms)) : ?>
                        <?php foreach ($wujin_sushi_menu_terms as $wujin_sushi_term) : ?>
                            <a class="category-card" href="<?php echo esc_url(get_term_link($wujin_sushi_term)); ?>">
                                <h3><?php echo esc_html($wujin_sushi_term->name); ?></h3>
                                <span><?php echo esc_html(sprintf(_n('%s plat', '%s plats', (int) $wujin_sushi_term->count, 'wujin-sushi'), number_format_i18n((int) $wujin_sushi_term->count))); ?></span>
                            </a>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <?php foreach (array_slice(wujin_sushi_default_menu_category_names(), 0, 8) as $wujin_sushi_category_name) : ?>
                            <div class="category-card">
                                <h3><?php echo esc_html($wujin_sushi_category_name); ?></h3>
                                <span><?php esc_html_e('Ajoutez des plats pour remplir cette categorie.', 'wujin-sushi'); ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="section-card">
                <div class="section-head">
                    <div>
                        <p class="eyebrow"><?php esc_html_e('Selection', 'wujin-sushi'); ?></p>
                        <h2><?php esc_html_e('Plats en avant', 'wujin-sushi'); ?></h2>
                        <p><?php esc_html_e('Ajoutez des Menu Items et cochez "Show this dish on the homepage" pour controler cette selection.', 'wujin-sushi'); ?></p>
                    </div>
                    <a class="button button-secondary" href="<?php echo esc_url(get_post_type_archive_link('menu_item') ?: home_url('/#menu')); ?>"><?php esc_html_e('Voir toute la carte', 'wujin-sushi'); ?></a>
                </div>

                <?php if ($wujin_sushi_featured_menu_items->have_posts()) : ?>
                    <div class="menu-grid">
                        <?php
                        while ($wujin_sushi_featured_menu_items->have_posts()) :
                            $wujin_sushi_featured_menu_items->the_post();
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

                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <p><?php echo esc_html(get_the_excerpt() ?: wp_trim_words(wp_strip_all_tags(get_the_content()), 24)); ?></p>

                                    <?php if (! empty($wujin_sushi_terms)) : ?>
                                        <ul class="term-list">
                                            <?php foreach ($wujin_sushi_terms as $wujin_sushi_term) : ?>
                                                <li><a href="<?php echo esc_url(get_term_link($wujin_sushi_term)); ?>"><?php echo esc_html($wujin_sushi_term->name); ?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>
                    <?php wp_reset_postdata(); ?>
                <?php else : ?>
                    <div class="empty-state">
                        <h3><?php esc_html_e('Your homepage menu is ready for real content.', 'wujin-sushi'); ?></h3>
                        <p><?php esc_html_e('Add dishes in Menu Items, assign categories, prices, and featured dishes, and this section will update automatically.', 'wujin-sushi'); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <section class="section" id="about">
            <div class="section-card">
                <div class="section-head">
                    <div>
                        <p class="eyebrow"><?php esc_html_e('A propos', 'wujin-sushi'); ?></p>
                        <h2><?php echo esc_html($wujin_sushi_about_title); ?></h2>
                    </div>
                </div>

                <div class="about-grid">
                    <div class="content-area">
                        <p><?php echo esc_html($wujin_sushi_about_text); ?></p>

                        <?php if ($wujin_sushi_front_page_markup) : ?>
                            <div class="entry-content">
                                <?php echo wp_kses_post($wujin_sushi_front_page_markup); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <aside class="sidebar">
                        <div class="widget">
                            <h3 class="widget-title"><?php esc_html_e('Coordonnees', 'wujin-sushi'); ?></h3>
                            <ul class="footer-list">
                                <li><?php echo esc_html($wujin_sushi_address); ?></li>
                                <li><a href="<?php echo esc_url('tel:' . wujin_sushi_get_phone_uri($wujin_sushi_phone)); ?>"><?php echo esc_html($wujin_sushi_phone); ?></a></li>
                                <li><a href="<?php echo esc_url('mailto:' . antispambot($wujin_sushi_email)); ?>"><?php echo esc_html(antispambot($wujin_sushi_email)); ?></a></li>
                            </ul>
                        </div>
                    </aside>
                </div>
            </div>
        </section>

        <?php if ($wujin_sushi_latest_posts->have_posts()) : ?>
            <section class="section" id="news">
                <div class="section-card">
                    <div class="section-head">
                        <div>
                            <p class="eyebrow"><?php esc_html_e('Actualites', 'wujin-sushi'); ?></p>
                            <h2><?php esc_html_e('Dernieres nouvelles', 'wujin-sushi'); ?></h2>
                        </div>
                    </div>

                    <div class="post-grid">
                        <?php
                        while ($wujin_sushi_latest_posts->have_posts()) :
                            $wujin_sushi_latest_posts->the_post();
                            ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class('card-post'); ?>>
                                <?php if (has_post_thumbnail()) : ?>
                                    <a class="card-media" href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('large'); ?>
                                    </a>
                                <?php endif; ?>

                                <div class="card-content">
                                    <p class="card-meta"><?php echo esc_html(get_the_date()); ?></p>
                                    <h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <p><?php echo esc_html(get_the_excerpt() ?: wp_trim_words(wp_strip_all_tags(get_the_content()), 22)); ?></p>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>
                    <?php wp_reset_postdata(); ?>
                </div>
            </section>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
