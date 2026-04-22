<?php
/**
 * Functions which enhance the theme by hooking into WordPress.
 *
 * @package Wujin_Sushi
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param string[] $classes Existing classes.
 * @return string[]
 */
function wujin_sushi_body_classes($classes) {
    if (is_front_page()) {
        $classes[] = 'is-front-page';
    }

    if (is_singular('menu_item')) {
        $classes[] = 'is-menu-item';
    }

    if (! is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_filter('body_class', 'wujin_sushi_body_classes');

/**
 * Adds a pingback url auto-discovery header for single posts, pages, or attachments.
 *
 * @return void
 */
function wujin_sushi_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'wujin_sushi_pingback_header');

/**
 * Reads a namespaced theme setting.
 *
 * @param string $setting Setting suffix.
 * @param string $default Default value.
 * @return string
 */
function wujin_sushi_get_theme_option($setting, $default = '') {
    $value = get_theme_mod('wujin_sushi_' . $setting, $default);

    if (! is_string($value)) {
        return $default;
    }

    $value = trim($value);

    if ($value === '' && $default !== '') {
        return $default;
    }

    return $value;
}

/**
 * Builds a tel: URI from a display phone number.
 *
 * @param string $phone Phone number.
 * @return string
 */
function wujin_sushi_get_phone_uri($phone) {
    return preg_replace('/[^0-9+]/', '', $phone);
}

/**
 * Returns restaurant opening hours as clean lines.
 *
 * @return string[]
 */
function wujin_sushi_get_opening_hours_lines() {
    $hours = wujin_sushi_get_theme_option(
        'opening_hours',
        "Lundi - Samedi: 11h30 - 15h00 / 18h30 - 23h00\nDimanche: 18h30 - 23h00"
    );

    $lines = preg_split('/\r\n|\r|\n/', $hours);

    return array_values(array_filter(array_map('trim', $lines)));
}

/**
 * Returns the configured social links.
 *
 * @return array<string,string>
 */
function wujin_sushi_get_social_links() {
    $links = array(
        'Facebook'  => wujin_sushi_get_theme_option('facebook_url'),
        'Instagram' => wujin_sushi_get_theme_option('instagram_url'),
    );

    return array_filter($links);
}

/**
 * Returns an image attachment ID from a theme setting.
 *
 * @param string $setting Setting suffix.
 * @return int
 */
function wujin_sushi_get_theme_image_id($setting) {
    return absint(get_theme_mod('wujin_sushi_' . $setting, 0));
}

/**
 * Returns configured homepage gallery image IDs.
 *
 * @return int[]
 */
function wujin_sushi_get_gallery_image_ids() {
    $image_ids = array(
        wujin_sushi_get_theme_image_id('gallery_image_1'),
        wujin_sushi_get_theme_image_id('gallery_image_2'),
        wujin_sushi_get_theme_image_id('gallery_image_3'),
    );

    return array_values(array_filter($image_ids));
}

/**
 * Returns the menu item price.
 *
 * @param int $post_id Optional post ID.
 * @return string
 */
function wujin_sushi_get_menu_item_price($post_id = 0) {
    $post_id = $post_id ?: get_the_ID();

    return trim((string) get_post_meta($post_id, '_wujin_sushi_price', true));
}

/**
 * Returns the menu item badge.
 *
 * @param int $post_id Optional post ID.
 * @return string
 */
function wujin_sushi_get_menu_item_badge($post_id = 0) {
    $post_id = $post_id ?: get_the_ID();

    return trim((string) get_post_meta($post_id, '_wujin_sushi_badge', true));
}

/**
 * Returns whether a menu item is featured.
 *
 * @param int $post_id Optional post ID.
 * @return bool
 */
function wujin_sushi_is_menu_item_featured($post_id = 0) {
    $post_id = $post_id ?: get_the_ID();

    return get_post_meta($post_id, '_wujin_sushi_featured', true) === '1';
}

/**
 * Returns the default primary navigation when no menu is assigned.
 *
 * @param array $args wp_nav_menu arguments.
 * @return void
 */
function wujin_sushi_primary_menu_fallback($args) {
    $items = array(
        home_url('/') . '#top'     => esc_html__('Accueil', 'wujin-sushi'),
        home_url('/') . '#menu'    => esc_html__('La carte', 'wujin-sushi'),
        home_url('/') . '#about'   => esc_html__('A propos', 'wujin-sushi'),
        home_url('/') . '#contact' => esc_html__('Contact', 'wujin-sushi'),
        get_post_type_archive_link('menu_item') ?: home_url('/') . '#menu' => esc_html__('Menu complet', 'wujin-sushi'),
    );

    if (! empty(wujin_sushi_get_gallery_image_ids())) {
        $items[home_url('/') . '#gallery'] = esc_html__('Photos', 'wujin-sushi');
    }

    echo '<ul id="primary-menu" class="menu">';

    foreach ($items as $url => $label) {
        printf(
            '<li class="menu-item"><a href="%1$s">%2$s</a></li>',
            esc_url($url),
            esc_html($label)
        );
    }

    echo '</ul>';
}

/**
 * Returns the default footer navigation when no menu is assigned.
 *
 * @param array $args wp_nav_menu arguments.
 * @return void
 */
function wujin_sushi_footer_menu_fallback($args) {
    $posts_page_url = home_url('/blog/');

    if (get_option('page_for_posts')) {
        $resolved_posts_page_url = get_permalink((int) get_option('page_for_posts'));

        if ($resolved_posts_page_url) {
            $posts_page_url = $resolved_posts_page_url;
        }
    }

    $items = array(
        home_url('/')                   => esc_html__('Accueil', 'wujin-sushi'),
        get_post_type_archive_link('menu_item') ?: home_url('/') . '#menu' => esc_html__('Carte', 'wujin-sushi'),
        $posts_page_url => esc_html__('Actualites', 'wujin-sushi'),
    );

    echo '<ul class="footer-menu">';

    foreach ($items as $url => $label) {
        printf(
            '<li class="menu-item"><a href="%1$s">%2$s</a></li>',
            esc_url($url),
            esc_html($label)
        );
    }

    echo '</ul>';
}

/**
 * Returns the menu category terms for a menu item.
 *
 * @param int $post_id Optional post ID.
 * @return WP_Term[]
 */
function wujin_sushi_get_menu_terms($post_id = 0) {
    $post_id = $post_id ?: get_the_ID();
    $terms   = get_the_terms($post_id, 'menu_category');

    if (is_wp_error($terms) || empty($terms)) {
        return array();
    }

    return $terms;
}
