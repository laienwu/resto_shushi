<?php
/**
 * Front page template.
 *
 * @package Wujin_Sushi
 */

get_header();

$wujin_sushi_hero_heading     = wujin_sushi_get_theme_option('hero_heading', get_bloginfo('name'));
$wujin_sushi_hero_subheading  = wujin_sushi_get_theme_option('hero_subheading', get_bloginfo('description'));
$wujin_sushi_hero_description = wujin_sushi_get_theme_option('hero_description');
$wujin_sushi_about_title      = wujin_sushi_get_theme_option('about_title');
$wujin_sushi_about_text       = wujin_sushi_get_theme_option('about_text');
$wujin_sushi_address          = wujin_sushi_get_theme_option('address', '15 Bd du Temple, 75003 Paris');
$wujin_sushi_phone            = wujin_sushi_get_theme_option('phone', '09 54 97 63 96');
$wujin_sushi_email            = wujin_sushi_get_theme_option('email', 'bonjour@wujinsushi.fr');
$wujin_sushi_order_url        = wujin_sushi_get_theme_option('order_url', home_url('/#menu'));
$wujin_sushi_reservation_url  = wujin_sushi_get_theme_option('reservation_url', home_url('/#contact'));
$wujin_sushi_instagram_url    = wujin_sushi_get_theme_option('instagram_url');
$wujin_sushi_social_links     = wujin_sushi_get_social_links();
$wujin_sushi_hero_image_id    = wujin_sushi_get_theme_image_id('hero_image');
$wujin_sushi_about_image_id   = wujin_sushi_get_theme_image_id('about_image');
$wujin_sushi_gallery_image_ids = wujin_sushi_get_gallery_image_ids();
$wujin_sushi_front_page_id    = get_queried_object_id();
$wujin_sushi_front_page_markup = '';

if ($wujin_sushi_front_page_id) {
    $wujin_sushi_front_page_markup = trim((string) apply_filters('the_content', get_post_field('post_content', $wujin_sushi_front_page_id)));
}

$wujin_sushi_menu_terms = get_terms(
    array(
        'taxonomy'   => 'menu_category',
        'hide_empty' => false,
        'orderby'    => 'term_id',
        'order'      => 'ASC',
    )
);

$wujin_sushi_featured_posts = get_posts(
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

if (empty($wujin_sushi_featured_posts)) {
    $wujin_sushi_featured_posts = get_posts(
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

$wujin_sushi_all_menu_posts = get_posts(
    array(
        'post_type'      => 'menu_item',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => array(
            'menu_order' => 'ASC',
            'date'       => 'DESC',
        ),
    )
);

$wujin_sushi_menu_items_by_term = array();
$wujin_sushi_menu_term_thumbs   = array();
$wujin_sushi_featured_thumb     = '';
$wujin_sushi_promo_image_id     = 0;
$wujin_sushi_nav_sections       = array();

if ($wujin_sushi_hero_image_id) {
    $wujin_sushi_promo_image_id = $wujin_sushi_hero_image_id;
} elseif ($wujin_sushi_about_image_id) {
    $wujin_sushi_promo_image_id = $wujin_sushi_about_image_id;
} elseif (! empty($wujin_sushi_gallery_image_ids)) {
    $wujin_sushi_promo_image_id = (int) $wujin_sushi_gallery_image_ids[0];
}

foreach ($wujin_sushi_featured_posts as $wujin_sushi_featured_post) {
    $wujin_sushi_featured_thumb = get_the_post_thumbnail_url($wujin_sushi_featured_post, 'thumbnail');

    if ($wujin_sushi_featured_thumb) {
        break;
    }
}

if (! is_wp_error($wujin_sushi_menu_terms) && ! empty($wujin_sushi_menu_terms)) {
    foreach ($wujin_sushi_menu_terms as $wujin_sushi_term) {
        $wujin_sushi_menu_items_by_term[$wujin_sushi_term->term_id] = array();
    }
}

foreach ($wujin_sushi_all_menu_posts as $wujin_sushi_menu_post) {
    $wujin_sushi_terms_for_post = get_the_terms($wujin_sushi_menu_post, 'menu_category');

    if (is_wp_error($wujin_sushi_terms_for_post) || empty($wujin_sushi_terms_for_post)) {
        continue;
    }

    foreach ($wujin_sushi_terms_for_post as $wujin_sushi_term) {
        if (! isset($wujin_sushi_menu_items_by_term[$wujin_sushi_term->term_id])) {
            $wujin_sushi_menu_items_by_term[$wujin_sushi_term->term_id] = array();
        }

        $wujin_sushi_menu_items_by_term[$wujin_sushi_term->term_id][] = $wujin_sushi_menu_post;

        if (empty($wujin_sushi_menu_term_thumbs[$wujin_sushi_term->term_id])) {
            $wujin_sushi_thumb = get_the_post_thumbnail_url($wujin_sushi_menu_post, 'thumbnail');

            if ($wujin_sushi_thumb) {
                $wujin_sushi_menu_term_thumbs[$wujin_sushi_term->term_id] = $wujin_sushi_thumb;
            }
        }
    }
}

$wujin_sushi_nav_sections[] = array(
    'id'    => 'category-featured',
    'label' => esc_html__('Consultes par nos chefs', 'wujin-sushi'),
    'thumb' => $wujin_sushi_featured_thumb,
);

if (! is_wp_error($wujin_sushi_menu_terms) && ! empty($wujin_sushi_menu_terms)) {
    foreach ($wujin_sushi_menu_terms as $wujin_sushi_term) {
        if (sanitize_title($wujin_sushi_term->name) === 'consultes-par-nos-chefs') {
            continue;
        }

        $wujin_sushi_nav_sections[] = array(
            'id'    => 'category-' . $wujin_sushi_term->slug,
            'label' => $wujin_sushi_term->name,
            'thumb' => isset($wujin_sushi_menu_term_thumbs[$wujin_sushi_term->term_id]) ? $wujin_sushi_menu_term_thumbs[$wujin_sushi_term->term_id] : '',
            'term'  => $wujin_sushi_term,
        );
    }
}

$wujin_sushi_render_product_card = static function ($wujin_sushi_menu_post) {
    $wujin_sushi_post_id  = $wujin_sushi_menu_post instanceof WP_Post ? $wujin_sushi_menu_post->ID : (int) $wujin_sushi_menu_post;
    $wujin_sushi_title    = get_the_title($wujin_sushi_post_id);
    $wujin_sushi_url      = get_permalink($wujin_sushi_post_id);
    $wujin_sushi_price    = wujin_sushi_get_menu_item_price($wujin_sushi_post_id);
    $wujin_sushi_badge    = wujin_sushi_get_menu_item_badge($wujin_sushi_post_id);
    $wujin_sushi_featured = wujin_sushi_is_menu_item_featured($wujin_sushi_post_id);
    $wujin_sushi_excerpt  = (string) get_the_excerpt($wujin_sushi_post_id);

    if ($wujin_sushi_excerpt === '') {
        $wujin_sushi_excerpt = wp_strip_all_tags((string) get_post_field('post_content', $wujin_sushi_post_id));
    }

    $wujin_sushi_summary   = trim(wp_trim_words(wp_strip_all_tags($wujin_sushi_excerpt), 18));
    $wujin_sushi_thumbnail = get_the_post_thumbnail($wujin_sushi_post_id, 'wujin-sushi-menu-card', array('class' => 'w-100'));
    ?>
    <div class="product_item_container">
        <article class="product_item">
            <a class="product_image image-anchor" href="<?php echo esc_url($wujin_sushi_url); ?>">
                <?php if ($wujin_sushi_thumbnail) : ?>
                    <?php echo $wujin_sushi_thumbnail; ?>
                <?php else : ?>
                    <span class="product_image_placeholder font-title"><?php echo esc_html($wujin_sushi_title); ?></span>
                <?php endif; ?>

                <?php if ($wujin_sushi_featured) : ?>
                    <div class="meilleur_vente"><?php esc_html_e('Populaire', 'wujin-sushi'); ?></div>
                <?php endif; ?>

                <?php if ($wujin_sushi_badge) : ?>
                    <div class="top_text">
                        <span><?php echo esc_html($wujin_sushi_badge); ?></span>
                    </div>
                <?php endif; ?>
            </a>

            <div class="product_info">
                <div class="product_name"><?php echo esc_html($wujin_sushi_title); ?></div>

                <?php if ($wujin_sushi_price) : ?>
                    <div class="product_price">
                        <div class="price"><?php echo esc_html($wujin_sushi_price); ?></div>
                    </div>
                <?php endif; ?>

                <?php if ($wujin_sushi_summary) : ?>
                    <p class="product_summary"><?php echo esc_html($wujin_sushi_summary); ?></p>
                <?php endif; ?>

                <a class="product_more" href="<?php echo esc_url($wujin_sushi_url); ?>"><?php esc_html_e('Apercu rapide', 'wujin-sushi'); ?></a>

                <div class="product_btn">
                    <a class="button icon-button productAddBtn" href="<?php echo esc_url($wujin_sushi_url); ?>" aria-label="<?php echo esc_attr(sprintf(__('Voir %s', 'wujin-sushi'), $wujin_sushi_title)); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none" aria-hidden="true">
                            <path d="M27.0537 16.1064H1.92672C1.13321 16.1064 0.490234 15.4634 0.490234 14.6699C0.490234 13.8764 1.13321 13.2334 1.92672 13.2334H27.0537C27.8473 13.2334 28.4902 13.8764 28.4902 14.6699C28.4902 15.4634 27.8473 16.1064 27.0537 16.1064ZM14.4902 28.6699C13.6967 28.6699 13.0537 28.0269 13.0537 27.2334V2.10641C13.0537 1.3129 13.6967 0.669922 14.4902 0.669922C15.2837 0.669922 15.9267 1.3129 15.9267 2.10641V27.2334C15.9267 28.0269 15.2837 28.6699 14.4902 28.6699Z" />
                        </svg>
                    </a>
                </div>
            </div>
        </article>
    </div>
    <?php
};

$wujin_sushi_render_promo_card = static function () use ($wujin_sushi_promo_image_id, $wujin_sushi_instagram_url, $wujin_sushi_order_url) {
    if (! $wujin_sushi_promo_image_id && ! $wujin_sushi_instagram_url) {
        return;
    }

    $wujin_sushi_promo_href   = $wujin_sushi_instagram_url ?: $wujin_sushi_order_url;
    $wujin_sushi_promo_target = $wujin_sushi_instagram_url ? ' target="_blank" rel="noopener noreferrer"' : '';
    $wujin_sushi_promo_title  = $wujin_sushi_instagram_url ? __('Suivez nous', 'wujin-sushi') : __('Photos du restaurant', 'wujin-sushi');
    $wujin_sushi_promo_copy   = $wujin_sushi_instagram_url ? __('Ajoutez votre compte Instagram dans le Customizer.', 'wujin-sushi') : __('Ajoutez vos propres photos depuis le Customizer.', 'wujin-sushi');
    ?>
    <div class="instagram_container">
        <div class="instagram_inner">
            <a id="header_instagram_button" href="<?php echo esc_url($wujin_sushi_promo_href); ?>"<?php echo $wujin_sushi_promo_target; ?>>
                <?php if ($wujin_sushi_promo_image_id) : ?>
                    <?php echo wp_get_attachment_image($wujin_sushi_promo_image_id, 'large', false, array('class' => 'promo-image')); ?>
                <?php else : ?>
                    <div class="promo-image promo-placeholder font-title"><?php esc_html_e('Wujin Sushi', 'wujin-sushi'); ?></div>
                <?php endif; ?>

                <div id="instagram_id">
                    <div class="instagram_icon_container">
                        <span class="font-title">IG</span>
                    </div>

                    <div class="instagram_text_container">
                        <strong><?php echo esc_html($wujin_sushi_promo_title); ?></strong>
                        <span><?php echo esc_html($wujin_sushi_promo_copy); ?></span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <?php
};
?>

<main id="primary" class="site-main">
    <div class="site-shell home_container">
        <section class="home_top">
            <div class="home_top_info">
                <h1 class="font-title"><?php echo esc_html($wujin_sushi_hero_heading); ?></h1>

                <?php if ($wujin_sushi_hero_subheading) : ?>
                    <h2 class="hero-subtitle"><?php echo esc_html($wujin_sushi_hero_subheading); ?></h2>
                <?php endif; ?>

                <h2 class="hero-address"><?php echo esc_html($wujin_sushi_address); ?></h2>

                <div class="web_info">
                    <h2><a href="<?php echo esc_url('tel:' . wujin_sushi_get_phone_uri($wujin_sushi_phone)); ?>"><?php echo esc_html($wujin_sushi_phone); ?></a></h2>
                    <a class="font-title underline" href="#about"><?php esc_html_e('Plus d informations', 'wujin-sushi'); ?></a>
                </div>
            </div>

            <div class="home_top_btn">
                <div class="emporter_livraison_btn_container halfWidth">
                    <div class="btn_container bubble_box_container emporter_btn_container">
                        <a class="emporter_livraison_btn emporter_btn active animation" href="<?php echo esc_url($wujin_sushi_order_url); ?>">
                            <span class="takeaway-icon" aria-hidden="true"></span>
                            <?php esc_html_e('A Emporter', 'wujin-sushi'); ?>
                        </a>

                        <div class="bubble_box">
                            <div class="bubble_box_content"><?php esc_html_e('Je recupere ma commande !', 'wujin-sushi'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="home_main" id="menu">
            <aside class="home_menu_container">
                <nav aria-label="<?php esc_attr_e('Menu categories', 'wujin-sushi'); ?>">
                    <?php foreach ($wujin_sushi_nav_sections as $wujin_sushi_section_index => $wujin_sushi_nav_section) : ?>
                        <a class="home_menu_item menuCategory<?php echo 0 === $wujin_sushi_section_index ? ' active' : ''; ?>" href="#<?php echo esc_attr($wujin_sushi_nav_section['id']); ?>" data-category-link>
                            <span class="menu-label"><?php echo esc_html($wujin_sushi_nav_section['label']); ?></span>

                            <?php if (! empty($wujin_sushi_nav_section['thumb'])) : ?>
                                <img class="menu-thumb" src="<?php echo esc_url($wujin_sushi_nav_section['thumb']); ?>" alt="">
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
            </aside>

            <div class="home_product_container">
                <section id="category-featured" class="storefront-category" data-category-panel>
                    <h1 class="storefront-category-heading font-title"><?php esc_html_e('Consultes par nos chefs', 'wujin-sushi'); ?></h1>

                    <div class="product_container">
                        <?php $wujin_sushi_render_promo_card(); ?>

                        <?php if (! empty($wujin_sushi_featured_posts)) : ?>
                            <?php foreach ($wujin_sushi_featured_posts as $wujin_sushi_menu_post) : ?>
                                <?php $wujin_sushi_render_product_card($wujin_sushi_menu_post); ?>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="storefront-placeholder">
                                <h3><?php esc_html_e('Ajoutez vos premiers plats', 'wujin-sushi'); ?></h3>
                                <p><?php esc_html_e('Creez des Menu Items dans WordPress pour remplir cette page avec votre vraie carte.', 'wujin-sushi'); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

                <?php if (! is_wp_error($wujin_sushi_menu_terms) && ! empty($wujin_sushi_menu_terms)) : ?>
                    <?php foreach ($wujin_sushi_menu_terms as $wujin_sushi_term) : ?>
                        <?php
                        if (sanitize_title($wujin_sushi_term->name) === 'consultes-par-nos-chefs') {
                            continue;
                        }

                        $wujin_sushi_term_items = isset($wujin_sushi_menu_items_by_term[$wujin_sushi_term->term_id]) ? $wujin_sushi_menu_items_by_term[$wujin_sushi_term->term_id] : array();
                        ?>
                        <section id="category-<?php echo esc_attr($wujin_sushi_term->slug); ?>" class="storefront-category" data-category-panel>
                            <h2 class="storefront-category-heading font-title"><?php echo esc_html($wujin_sushi_term->name); ?></h2>

                            <div class="product_container">
                                <?php if (! empty($wujin_sushi_term_items)) : ?>
                                    <?php foreach ($wujin_sushi_term_items as $wujin_sushi_menu_post) : ?>
                                        <?php $wujin_sushi_render_product_card($wujin_sushi_menu_post); ?>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <div class="storefront-placeholder">
                                        <h3><?php esc_html_e('Categorie prete', 'wujin-sushi'); ?></h3>
                                        <p><?php esc_html_e('Ajoutez des plats dans cette categorie depuis Menu Items pour la faire apparaitre ici.', 'wujin-sushi'); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </section>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <section class="section storefront-support" id="about">
            <div class="section-card">
                <div class="storefront-support-grid">
                    <div class="storefront-story">
                        <p class="eyebrow"><?php esc_html_e('A propos', 'wujin-sushi'); ?></p>
                        <h2><?php echo esc_html($wujin_sushi_about_title); ?></h2>

                        <?php if ($wujin_sushi_hero_description) : ?>
                            <p class="storefront-lead"><?php echo esc_html($wujin_sushi_hero_description); ?></p>
                        <?php endif; ?>

                        <p><?php echo esc_html($wujin_sushi_about_text); ?></p>

                        <?php if ($wujin_sushi_front_page_markup) : ?>
                            <div class="entry-content">
                                <?php echo wp_kses_post($wujin_sushi_front_page_markup); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (! empty($wujin_sushi_gallery_image_ids)) : ?>
                            <div class="gallery-grid compact-gallery" id="gallery">
                                <?php foreach ($wujin_sushi_gallery_image_ids as $wujin_sushi_gallery_image_id) : ?>
                                    <a class="gallery-card image-anchor" href="<?php echo esc_url(wp_get_attachment_image_url($wujin_sushi_gallery_image_id, 'full')); ?>">
                                        <?php echo wp_get_attachment_image($wujin_sushi_gallery_image_id, 'large', false, array('class' => 'image-anchor-img')); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <aside class="storefront-contact-stack" id="contact">
                        <div class="hero-panel-card">
                            <h3><?php esc_html_e('Adresse', 'wujin-sushi'); ?></h3>
                            <p><?php echo esc_html($wujin_sushi_address); ?></p>
                        </div>

                        <div class="hero-panel-card">
                            <h3><?php esc_html_e('Telephone', 'wujin-sushi'); ?></h3>
                            <p><a href="<?php echo esc_url('tel:' . wujin_sushi_get_phone_uri($wujin_sushi_phone)); ?>"><?php echo esc_html($wujin_sushi_phone); ?></a></p>
                            <p><a href="<?php echo esc_url('mailto:' . antispambot($wujin_sushi_email)); ?>"><?php echo esc_html(antispambot($wujin_sushi_email)); ?></a></p>
                        </div>

                        <div class="hero-panel-card">
                            <h3><?php esc_html_e('Horaires', 'wujin-sushi'); ?></h3>
                            <ul class="hero-panel-list">
                                <?php foreach (wujin_sushi_get_opening_hours_lines() as $wujin_sushi_line) : ?>
                                    <li><?php echo esc_html($wujin_sushi_line); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <div class="storefront-link-row">
                            <a class="button button-primary" href="<?php echo esc_url($wujin_sushi_order_url); ?>"><?php esc_html_e('Commander', 'wujin-sushi'); ?></a>
                            <a class="button button-secondary" href="<?php echo esc_url($wujin_sushi_reservation_url); ?>"><?php esc_html_e('Reservation', 'wujin-sushi'); ?></a>
                        </div>

                        <?php if (! empty($wujin_sushi_social_links)) : ?>
                            <div class="footer-socials storefront-socials">
                                <?php foreach ($wujin_sushi_social_links as $wujin_sushi_network => $wujin_sushi_url) : ?>
                                    <a href="<?php echo esc_url($wujin_sushi_url); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($wujin_sushi_network); ?></a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </aside>
                </div>
            </div>
        </section>
    </div>
</main>

<?php
get_footer();
