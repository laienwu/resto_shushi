<?php
/**
 * WooCommerce compatibility helpers.
 *
 * @package Wujin_Sushi
 */

/**
 * Adds extra WooCommerce gallery support.
 *
 * @return void
 */
function wujin_sushi_woocommerce_setup() {
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'wujin_sushi_woocommerce_setup');

/**
 * Returns the current WooCommerce cart count.
 *
 * @return int
 */
function wujin_sushi_woocommerce_cart_count() {
    if (! function_exists('WC')) {
        return 0;
    }

    $woocommerce = WC();

    if (! isset($woocommerce->cart) || ! $woocommerce->cart) {
        return 0;
    }

    return (int) $woocommerce->cart->get_cart_contents_count();
}
