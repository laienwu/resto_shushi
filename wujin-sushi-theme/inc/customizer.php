<?php
/**
 * Theme Customizer additions.
 *
 * @package Wujin_Sushi
 */

/**
 * Registers Customizer settings used by the theme.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
 * @return void
 */
function wujin_sushi_customize_register($wp_customize) {
    $wp_customize->add_section(
        'wujin_sushi_restaurant',
        array(
            'title'       => esc_html__('Restaurant Settings', 'wujin-sushi'),
            'priority'    => 30,
            'description' => esc_html__('Manage the homepage content, contact details, and call-to-action links.', 'wujin-sushi'),
        )
    );

    $settings = array(
        'hero_heading' => array(
            'label'   => esc_html__('Hero heading', 'wujin-sushi'),
            'type'    => 'text',
            'default' => 'Wujin Sushi',
        ),
        'hero_subheading' => array(
            'label'   => esc_html__('Hero subheading', 'wujin-sushi'),
            'type'    => 'text',
            'default' => 'Restaurant Japonais et Tibetain',
        ),
        'hero_description' => array(
            'label'   => esc_html__('Hero description', 'wujin-sushi'),
            'type'    => 'textarea',
            'default' => 'Une table chaleureuse pour les sushis, les grillades et les specialites tibetaines a partager sur place, a emporter, ou en livraison.',
        ),
        'announcement_text' => array(
            'label'   => esc_html__('Announcement banner', 'wujin-sushi'),
            'type'    => 'textarea',
            'default' => 'Commande en ligne, retrait sur place, et reservations disponibles tous les jours.',
        ),
        'address' => array(
            'label'   => esc_html__('Address', 'wujin-sushi'),
            'type'    => 'text',
            'default' => '15 Bd du Temple, 75003 Paris',
        ),
        'phone' => array(
            'label'   => esc_html__('Phone number', 'wujin-sushi'),
            'type'    => 'text',
            'default' => '09 54 97 63 96',
        ),
        'email' => array(
            'label'   => esc_html__('Email address', 'wujin-sushi'),
            'type'    => 'email',
            'default' => 'bonjour@wujinsushi.fr',
        ),
        'reservation_url' => array(
            'label'   => esc_html__('Reservation URL', 'wujin-sushi'),
            'type'    => 'url',
            'default' => home_url('/#contact'),
        ),
        'order_url' => array(
            'label'   => esc_html__('Online ordering URL', 'wujin-sushi'),
            'type'    => 'url',
            'default' => home_url('/#menu'),
        ),
        'about_title' => array(
            'label'   => esc_html__('About section title', 'wujin-sushi'),
            'type'    => 'text',
            'default' => 'Cuisine soignee, service direct, site simple a administrer.',
        ),
        'about_text' => array(
            'label'   => esc_html__('About section text', 'wujin-sushi'),
            'type'    => 'textarea',
            'default' => 'Cette version WordPress est pensee pour etre exploitable en conditions reelles: la navigation, la page d accueil, les contenus du restaurant, et la carte peuvent etre mis a jour depuis l administration sans reouvrir le code.',
        ),
        'opening_hours' => array(
            'label'   => esc_html__('Opening hours', 'wujin-sushi'),
            'type'    => 'textarea',
            'default' => "Lundi - Samedi: 11h30 - 15h00 / 18h30 - 23h00\nDimanche: 18h30 - 23h00",
        ),
        'facebook_url' => array(
            'label'   => esc_html__('Facebook URL', 'wujin-sushi'),
            'type'    => 'url',
            'default' => '',
        ),
        'instagram_url' => array(
            'label'   => esc_html__('Instagram URL', 'wujin-sushi'),
            'type'    => 'url',
            'default' => '',
        ),
    );

    foreach ($settings as $setting_id => $config) {
        $sanitize_callback = 'sanitize_text_field';

        if ($config['type'] === 'textarea') {
            $sanitize_callback = 'sanitize_textarea_field';
        } elseif ($config['type'] === 'url') {
            $sanitize_callback = 'esc_url_raw';
        } elseif ($config['type'] === 'email') {
            $sanitize_callback = 'sanitize_email';
        }

        $wp_customize->add_setting(
            'wujin_sushi_' . $setting_id,
            array(
                'default'           => $config['default'],
                'sanitize_callback' => $sanitize_callback,
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            'wujin_sushi_' . $setting_id,
            array(
                'section' => 'wujin_sushi_restaurant',
                'label'   => $config['label'],
                'type'    => $config['type'],
            )
        );
    }
}
add_action('customize_register', 'wujin_sushi_customize_register');
