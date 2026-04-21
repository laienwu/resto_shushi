<?php
/**
 * Wujin Sushi functions and definitions
 *
 * @package Wujin_Sushi
 */

if (! defined('WUJIN_SUSHI_VERSION')) {
    $wujin_sushi_theme = wp_get_theme();
    define('WUJIN_SUSHI_VERSION', $wujin_sushi_theme->get('Version') ?: '1.0.0');
}

/**
 * Returns the starter menu category names used across the theme.
 *
 * @return string[]
 */
function wujin_sushi_default_menu_category_names() {
    return array(
        'Consultes par nos chefs',
        'Menu Midi',
        'Menu Mixte',
        'Menus Tibetains',
        'Menus Brochettes',
        'Menu A',
        'Menu J',
        'Menus Chirashi',
        'Menu Bateau',
        'Menus Speciaux',
        'Poke Bowl',
        'Special Roll',
        'Nos Burgers',
        'Hors D oeuvre',
        'Nos Maki',
        'Yakitori',
        'Nos Sushi',
        'Saumon Roll',
    );
}

if (! function_exists('wujin_sushi_setup')) :
    /**
     * Sets up theme defaults and registers support for WordPress features.
     *
     * @return void
     */
    function wujin_sushi_setup() {
        load_theme_textdomain('wujin-sushi', get_template_directory() . '/languages');

        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('customize-selective-refresh-widgets');
        add_theme_support('woocommerce');
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
            )
        );

        add_theme_support(
            'custom-background',
            array(
                'default-color' => 'f7f2e8',
                'default-image' => '',
            )
        );

        add_theme_support(
            'custom-logo',
            array(
                'height'      => 200,
                'width'       => 200,
                'flex-height' => true,
                'flex-width'  => true,
            )
        );

        add_image_size('wujin-sushi-menu-card', 720, 520, true);

        register_nav_menus(
            array(
                'primary' => esc_html__('Primary Navigation', 'wujin-sushi'),
                'footer'  => esc_html__('Footer Navigation', 'wujin-sushi'),
            )
        );
    }
endif;
add_action('after_setup_theme', 'wujin_sushi_setup');

/**
 * Sets the content width in pixels.
 *
 * @return void
 */
function wujin_sushi_content_width() {
    $GLOBALS['content_width'] = apply_filters('wujin_sushi_content_width', 1200);
}
add_action('after_setup_theme', 'wujin_sushi_content_width', 0);

/**
 * Registers widget areas.
 *
 * @return void
 */
function wujin_sushi_widgets_init() {
    register_sidebar(
        array(
            'name'          => esc_html__('Sidebar', 'wujin-sushi'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Add blog widgets here.', 'wujin-sushi'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );

    register_sidebar(
        array(
            'name'          => esc_html__('Footer Column', 'wujin-sushi'),
            'id'            => 'footer-1',
            'description'   => esc_html__('Add footer widgets here.', 'wujin-sushi'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action('widgets_init', 'wujin_sushi_widgets_init');

/**
 * Enqueues scripts and styles.
 *
 * @return void
 */
function wujin_sushi_scripts() {
    wp_enqueue_style(
        'wujin-sushi-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Manrope:wght@400;500;600;700&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'wujin-sushi-style',
        get_stylesheet_uri(),
        array('wujin-sushi-fonts'),
        WUJIN_SUSHI_VERSION
    );

    wp_enqueue_script(
        'wujin-sushi-script',
        get_template_directory_uri() . '/js/theme.js',
        array(),
        WUJIN_SUSHI_VERSION,
        true
    );

    wp_localize_script(
        'wujin-sushi-script',
        'wujinSushiLabels',
        array(
            'menu'  => esc_html__('Menu', 'wujin-sushi'),
            'close' => esc_html__('Close', 'wujin-sushi'),
        )
    );

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'wujin_sushi_scripts');

/**
 * Loads admin styles.
 *
 * @return void
 */
function wujin_sushi_admin_styles() {
    wp_enqueue_style(
        'wujin-sushi-admin-style',
        get_template_directory_uri() . '/css/admin-style.css',
        array(),
        WUJIN_SUSHI_VERSION
    );
}
add_action('admin_enqueue_scripts', 'wujin_sushi_admin_styles');

/**
 * Registers custom post types and taxonomies used by the theme.
 *
 * @return void
 */
function wujin_sushi_register_content() {
    register_taxonomy(
        'menu_category',
        array('menu_item'),
        array(
            'hierarchical'      => true,
            'labels'            => array(
                'name'              => esc_html__('Menu Categories', 'wujin-sushi'),
                'singular_name'     => esc_html__('Menu Category', 'wujin-sushi'),
                'search_items'      => esc_html__('Search Menu Categories', 'wujin-sushi'),
                'all_items'         => esc_html__('All Menu Categories', 'wujin-sushi'),
                'edit_item'         => esc_html__('Edit Menu Category', 'wujin-sushi'),
                'update_item'       => esc_html__('Update Menu Category', 'wujin-sushi'),
                'add_new_item'      => esc_html__('Add New Menu Category', 'wujin-sushi'),
                'new_item_name'     => esc_html__('New Menu Category Name', 'wujin-sushi'),
                'menu_name'         => esc_html__('Menu Categories', 'wujin-sushi'),
            ),
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array(
                'slug'       => 'menu',
                'with_front' => false,
            ),
            'show_in_rest'      => true,
        )
    );

    register_post_type(
        'menu_item',
        array(
            'labels'       => array(
                'name'               => esc_html__('Menu Items', 'wujin-sushi'),
                'singular_name'      => esc_html__('Menu Item', 'wujin-sushi'),
                'add_new'            => esc_html__('Add Menu Item', 'wujin-sushi'),
                'add_new_item'       => esc_html__('Add New Menu Item', 'wujin-sushi'),
                'edit_item'          => esc_html__('Edit Menu Item', 'wujin-sushi'),
                'new_item'           => esc_html__('New Menu Item', 'wujin-sushi'),
                'view_item'          => esc_html__('View Menu Item', 'wujin-sushi'),
                'view_items'         => esc_html__('View Menu Items', 'wujin-sushi'),
                'search_items'       => esc_html__('Search Menu Items', 'wujin-sushi'),
                'not_found'          => esc_html__('No menu items found.', 'wujin-sushi'),
                'not_found_in_trash' => esc_html__('No menu items found in Trash.', 'wujin-sushi'),
                'all_items'          => esc_html__('All Menu Items', 'wujin-sushi'),
                'menu_name'          => esc_html__('Menu Items', 'wujin-sushi'),
            ),
            'public'       => true,
            'show_in_rest' => true,
            'menu_icon'    => 'dashicons-carrot',
            'has_archive'  => true,
            'rewrite'      => array(
                'slug'       => 'menu-items',
                'with_front' => false,
            ),
            'supports'     => array(
                'title',
                'editor',
                'excerpt',
                'thumbnail',
                'page-attributes',
            ),
            'taxonomies'   => array('menu_category'),
        )
    );
}
add_action('init', 'wujin_sushi_register_content');

/**
 * Adds menu item meta boxes.
 *
 * @return void
 */
function wujin_sushi_add_menu_item_meta_boxes() {
    add_meta_box(
        'wujin-sushi-menu-item-details',
        esc_html__('Menu Item Details', 'wujin-sushi'),
        'wujin_sushi_render_menu_item_details_meta_box',
        'menu_item',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'wujin_sushi_add_menu_item_meta_boxes');

/**
 * Renders the menu item details meta box.
 *
 * @param WP_Post $post Current post object.
 * @return void
 */
function wujin_sushi_render_menu_item_details_meta_box($post) {
    $price    = get_post_meta($post->ID, '_wujin_sushi_price', true);
    $badge    = get_post_meta($post->ID, '_wujin_sushi_badge', true);
    $featured = get_post_meta($post->ID, '_wujin_sushi_featured', true);

    wp_nonce_field('wujin_sushi_save_menu_item_details', 'wujin_sushi_menu_item_nonce');
    ?>
    <p>
        <label for="wujin-sushi-price"><strong><?php esc_html_e('Price', 'wujin-sushi'); ?></strong></label>
        <input
            id="wujin-sushi-price"
            name="wujin_sushi_price"
            type="text"
            class="widefat"
            value="<?php echo esc_attr($price); ?>"
            placeholder="<?php echo esc_attr__('12,50 EUR', 'wujin-sushi'); ?>"
        />
    </p>
    <p>
        <label for="wujin-sushi-badge"><strong><?php esc_html_e('Badge', 'wujin-sushi'); ?></strong></label>
        <input
            id="wujin-sushi-badge"
            name="wujin_sushi_badge"
            type="text"
            class="widefat"
            value="<?php echo esc_attr($badge); ?>"
            placeholder="<?php echo esc_attr__('Chef signature', 'wujin-sushi'); ?>"
        />
    </p>
    <p>
        <label for="wujin-sushi-featured">
            <input
                id="wujin-sushi-featured"
                name="wujin_sushi_featured"
                type="checkbox"
                value="1"
                <?php checked($featured, '1'); ?>
            />
            <?php esc_html_e('Show this dish on the homepage', 'wujin-sushi'); ?>
        </label>
    </p>
    <?php
}

/**
 * Saves menu item details.
 *
 * @param int $post_id Current post ID.
 * @return void
 */
function wujin_sushi_save_menu_item_details($post_id) {
    if (! isset($_POST['wujin_sushi_menu_item_nonce'])) {
        return;
    }

    if (! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['wujin_sushi_menu_item_nonce'])), 'wujin_sushi_save_menu_item_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (! current_user_can('edit_post', $post_id)) {
        return;
    }

    $price    = isset($_POST['wujin_sushi_price']) ? sanitize_text_field(wp_unslash($_POST['wujin_sushi_price'])) : '';
    $badge    = isset($_POST['wujin_sushi_badge']) ? sanitize_text_field(wp_unslash($_POST['wujin_sushi_badge'])) : '';
    $featured = isset($_POST['wujin_sushi_featured']) ? '1' : '';

    if ($price !== '') {
        update_post_meta($post_id, '_wujin_sushi_price', $price);
    } else {
        delete_post_meta($post_id, '_wujin_sushi_price');
    }

    if ($badge !== '') {
        update_post_meta($post_id, '_wujin_sushi_badge', $badge);
    } else {
        delete_post_meta($post_id, '_wujin_sushi_badge');
    }

    if ($featured === '1') {
        update_post_meta($post_id, '_wujin_sushi_featured', '1');
    } else {
        delete_post_meta($post_id, '_wujin_sushi_featured');
    }
}
add_action('save_post_menu_item', 'wujin_sushi_save_menu_item_details');

/**
 * Marks the theme for starter taxonomy seeding.
 *
 * @return void
 */
function wujin_sushi_schedule_seed_content() {
    update_option('wujin_sushi_seed_menu_categories', '1');
}
add_action('after_switch_theme', 'wujin_sushi_schedule_seed_content');

/**
 * Inserts starter menu categories on the first activation.
 *
 * @return void
 */
function wujin_sushi_seed_default_menu_categories() {
    if (get_option('wujin_sushi_seed_menu_categories') !== '1') {
        return;
    }

    $existing_terms = get_terms(
        array(
            'taxonomy'   => 'menu_category',
            'hide_empty' => false,
            'fields'     => 'ids',
        )
    );

    if (is_wp_error($existing_terms) || ! empty($existing_terms)) {
        delete_option('wujin_sushi_seed_menu_categories');
        return;
    }

    foreach (wujin_sushi_default_menu_category_names() as $category_name) {
        if (! term_exists($category_name, 'menu_category')) {
            wp_insert_term($category_name, 'menu_category');
        }
    }

    delete_option('wujin_sushi_seed_menu_categories');
}
add_action('init', 'wujin_sushi_seed_default_menu_categories', 30);

require_once get_template_directory() . '/inc/custom-header.php';
require_once get_template_directory() . '/inc/template-tags.php';
require_once get_template_directory() . '/inc/template-functions.php';
require_once get_template_directory() . '/inc/customizer.php';

if (defined('JETPACK__VERSION')) {
    require_once get_template_directory() . '/inc/jetpack.php';
}

if (class_exists('WooCommerce')) {
    require_once get_template_directory() . '/inc/woocommerce.php';
}
