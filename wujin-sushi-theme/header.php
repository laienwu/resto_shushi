<?php
/**
 * The header for the theme.
 *
 * @package Wujin_Sushi
 */

$wujin_sushi_phone           = wujin_sushi_get_theme_option('phone', '09 54 97 63 96');
$wujin_sushi_phone_uri       = wujin_sushi_get_phone_uri($wujin_sushi_phone);
$wujin_sushi_reservation_url = wujin_sushi_get_theme_option('reservation_url', home_url('/#contact'));
$wujin_sushi_order_url       = wujin_sushi_get_theme_option('order_url', home_url('/#menu'));
$wujin_sushi_tagline         = wujin_sushi_get_theme_option('hero_subheading', get_bloginfo('description'));
$wujin_sushi_logo_id         = (int) get_theme_mod('custom_logo');
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="screen-reader-text skip-link" href="#primary"><?php esc_html_e('Skip to content', 'wujin-sushi'); ?></a>

<div id="page" class="site">
    <header id="masthead" class="site-header">
        <div class="site-shell header-bar" id="top">
            <div class="site-branding">
                <a class="brand-link" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                    <?php if ($wujin_sushi_logo_id) : ?>
                        <?php echo wp_get_attachment_image($wujin_sushi_logo_id, 'full', false, array('class' => 'custom-logo brand-mark')); ?>
                    <?php else : ?>
                        <img class="brand-mark" src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo.png'); ?>" alt="<?php bloginfo('name'); ?>">
                    <?php endif; ?>
                    <span class="brand-copy">
                        <span class="brand-name"><?php bloginfo('name'); ?></span>
                        <?php if ($wujin_sushi_tagline) : ?>
                            <span class="brand-tagline"><?php echo esc_html($wujin_sushi_tagline); ?></span>
                        <?php endif; ?>
                    </span>
                </a>
            </div>

            <button class="menu-toggle" type="button" aria-controls="primary-menu" aria-expanded="false" data-menu-toggle>
                <span class="menu-toggle-icon" aria-hidden="true"></span>
                <span class="menu-toggle-label"><?php esc_html_e('Menu', 'wujin-sushi'); ?></span>
            </button>

            <div class="header-actions">
                <?php if ($wujin_sushi_phone && $wujin_sushi_phone_uri) : ?>
                    <a class="header-link" href="<?php echo esc_url('tel:' . $wujin_sushi_phone_uri); ?>">
                        <?php echo esc_html($wujin_sushi_phone); ?>
                    </a>
                <?php endif; ?>

                <a class="button button-secondary" href="<?php echo esc_url($wujin_sushi_reservation_url); ?>">
                    <?php esc_html_e('Reservation', 'wujin-sushi'); ?>
                </a>

                <a class="button button-primary" href="<?php echo esc_url($wujin_sushi_order_url); ?>">
                    <?php esc_html_e('Commander', 'wujin-sushi'); ?>
                </a>

                <?php if (class_exists('WooCommerce') && function_exists('wc_get_cart_url')) : ?>
                    <a class="cart-link" href="<?php echo esc_url(wc_get_cart_url()); ?>">
                        <?php esc_html_e('Panier', 'wujin-sushi'); ?>
                        <span class="cart-count"><?php echo esc_html((string) wujin_sushi_woocommerce_cart_count()); ?></span>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="site-shell navigation-bar">
            <nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e('Primary Navigation', 'wujin-sushi'); ?>">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                        'fallback_cb'    => 'wujin_sushi_primary_menu_fallback',
                    )
                );
                ?>
            </nav>
        </div>
    </header>

    <div id="content" class="site-content">
