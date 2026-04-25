<?php
/**
 * The header for the theme.
 *
 * @package Wujin_Sushi
 */

$wujin_sushi_order_url  = wujin_sushi_get_theme_option('order_url', home_url('/#menu'));
$wujin_sushi_logo_id    = (int) get_theme_mod('custom_logo');
$wujin_sushi_cart_url   = $wujin_sushi_order_url;
$wujin_sushi_cart_count = 0;
$wujin_sushi_account_url = is_user_logged_in() ? admin_url() : wp_login_url(home_url('/'));

if (class_exists('WooCommerce') && function_exists('wc_get_cart_url')) {
    $wujin_sushi_cart_url   = wc_get_cart_url();
    $wujin_sushi_cart_count = (int) wujin_sushi_woocommerce_cart_count();
}
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
        <div class="site-shell header-nav" id="top">
            <div id="logo_container" class="site-branding">
                <a class="brand-link" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                    <?php if ($wujin_sushi_logo_id) : ?>
                        <?php echo wp_get_attachment_image($wujin_sushi_logo_id, 'full', false, array('class' => 'custom-logo brand-mark')); ?>
                    <?php else : ?>
                        <img class="brand-mark" src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo.png'); ?>" alt="<?php bloginfo('name'); ?>">
                    <?php endif; ?>
                </a>
            </div>

            <button class="menu-toggle" type="button" aria-controls="primary-menu" aria-expanded="false" data-menu-toggle>
                <span class="menu-toggle-icon" aria-hidden="true"></span>
                <span class="menu-toggle-label"><?php esc_html_e('Menu', 'wujin-sushi'); ?></span>
            </button>

            <nav id="center_menu" class="main-navigation" aria-label="<?php esc_attr_e('Primary Navigation', 'wujin-sushi'); ?>">
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

            <div id="user_menu_container">
                <a id="user_menu" href="<?php echo esc_url($wujin_sushi_account_url); ?>" aria-label="<?php esc_attr_e('Compte', 'wujin-sushi'); ?>">
                    <svg width="32" height="38" viewBox="0 0 32 38" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M25.9494 28.2424C27.9701 30.482 29.2042 33.4 29.2042 36.6053C29.2042 37.0512 29.1797 37.4915 29.1336 37.9257H26.4634C26.5223 37.4924 26.5634 37.0539 26.5634 36.6053C26.5634 33.9491 25.4837 31.5441 23.7361 29.74C21.447 31.0241 18.8115 31.7637 16.0001 31.7637C13.1914 31.7637 10.558 31.0257 8.27046 29.7438C6.52153 31.5475 5.43687 33.9485 5.43687 36.6053C5.43687 37.0539 5.47787 37.4925 5.53687 37.9257H2.86667C2.81985 37.4871 2.79629 37.0464 2.79609 36.6053C2.79609 33.4003 4.02775 30.4802 6.04639 28.2392C2.4555 25.3343 0.155273 20.8974 0.155273 15.9189C0.155273 7.16812 7.24929 0.0742188 16.0001 0.0742188C24.751 0.0742188 31.845 7.16812 31.845 15.9189C31.845 20.8994 29.5428 25.3377 25.9494 28.2424ZM16.0001 10.9764C8.70772 10.9764 2.79609 7.99648 2.79609 15.5131C2.79609 23.0296 8.70772 29.1229 16.0001 29.1229C23.2925 29.1229 29.2042 23.0296 29.2042 15.5131C29.2042 7.99648 23.2925 10.9764 16.0001 10.9764ZM22.162 18.5597C21.1898 18.5597 20.4015 17.7715 20.4015 16.7992C20.4015 15.827 21.1898 15.0386 22.162 15.0386C23.1344 15.0386 23.9226 15.827 23.9226 16.7992C23.9225 17.7715 23.1344 18.5597 22.162 18.5597ZM21.2818 23.4012C21.2818 24.6167 18.9171 25.6018 16.0001 25.6018C13.0832 25.6018 10.7185 24.6166 10.7185 23.4012C10.7185 23.0878 10.8809 22.7909 11.1644 22.521C11.9801 23.2976 13.8355 23.8413 16.0001 23.8413C18.1647 23.8413 20.0201 23.2976 20.8358 22.521C21.1193 22.7909 21.2818 23.0878 21.2818 23.4012ZM9.83822 18.5597C8.86588 18.5597 8.07768 17.7715 8.07768 16.7992C8.07768 15.827 8.86588 15.0386 9.83822 15.0386C10.8105 15.0386 11.5988 15.827 11.5988 16.7992C11.5988 17.7715 10.8105 18.5597 9.83822 18.5597Z" />
                    </svg>
                </a>

                <a id="cart_menu" href="<?php echo esc_url($wujin_sushi_cart_url); ?>" aria-label="<?php esc_attr_e('Panier', 'wujin-sushi'); ?>">
                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M24.1733 8.18222L28 1.55556L25.3089 0L21.1944 7.11667C18.8454 6.50669 16.4269 6.206 14 6.22222C6.26889 6.22222 0 9.00667 0 12.4444C0.00177301 14.9094 0.654312 17.3301 1.89165 19.462C3.12898 21.5939 4.90725 23.3613 7.04667 24.5856C7.01979 24.6846 7.00414 24.7863 7 24.8889C7 26.6078 10.1111 28 14 28C17.8889 28 21 26.6078 21 24.8889C20.9959 24.7863 20.9802 24.6846 20.9533 24.5856C23.0928 23.3613 24.871 21.5939 26.1084 19.462C27.3457 17.3301 27.9982 14.9094 28 12.4444C28 10.7956 26.5378 9.33333 24.1733 8.18222ZM14 9.33333C15.8773 9.32024 17.7503 9.51589 19.5844 9.91667L17.3522 13.8056C18.7761 13.6339 20.1751 13.2972 21.5211 12.8022L22.6178 10.8889C23.5069 11.1817 24.2946 11.7212 24.8889 12.4444C24.4456 13.3622 20.6889 15.5556 14 15.5556C7.31111 15.5556 3.57 13.3622 3.11111 12.4444C3.57 11.5267 7.32667 9.33333 14 9.33333ZM14 23.3333C11.8836 23.3323 9.81341 22.7145 8.04256 21.5556C6.2717 20.3967 4.87695 18.7468 4.02889 16.8078C7.18976 18.1053 10.5839 18.738 14 18.6667C17.4161 18.738 20.8102 18.1053 23.9711 16.8078C23.123 18.7468 21.7283 20.3967 19.9574 21.5556C18.1866 22.7145 16.1164 23.3323 14 23.3333Z" />
                    </svg>
                    <span id="cart_count"><?php echo esc_html((string) $wujin_sushi_cart_count); ?></span>
                </a>
            </div>
        </div>

        <div id="sub_header" aria-label="<?php esc_attr_e('Restaurant announcement', 'wujin-sushi'); ?>">
            <div id="sub_header_content">
                <div class="sub_header_content">
                    <?php echo esc_html(wujin_sushi_get_theme_option('announcement_text', 'Votre restaurant prefere, Plat a emporter dispo en ligne !')); ?>
                </div>
                <div id="sub_header_holder"></div>
                <div class="sub_header_content" aria-hidden="true">
                    <?php echo esc_html(wujin_sushi_get_theme_option('announcement_text', 'Votre restaurant prefere, Plat a emporter dispo en ligne !')); ?>
                </div>
            </div>
        </div>
    </header>

    <div id="content" class="site-content">
