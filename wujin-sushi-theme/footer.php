<?php
/**
 * The template for displaying the footer.
 *
 * @package Wujin_Sushi
 */

$wujin_sushi_address      = wujin_sushi_get_theme_option('address', '15 Bd du Temple, 75003 Paris');
$wujin_sushi_phone        = wujin_sushi_get_theme_option('phone', '09 54 97 63 96');
$wujin_sushi_email        = wujin_sushi_get_theme_option('email', 'bonjour@wujinsushi.fr');
$wujin_sushi_social_links = wujin_sushi_get_social_links();
?>
    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="site-shell footer-grid" id="contact">
            <div class="footer-panel">
                <p class="eyebrow"><?php esc_html_e('Wujin Sushi', 'wujin-sushi'); ?></p>
                <h2><?php echo esc_html(wujin_sushi_get_theme_option('hero_subheading', 'Restaurant Japonais et Tibetain')); ?></h2>
                <p><?php echo esc_html(wujin_sushi_get_theme_option('hero_description')); ?></p>
            </div>

            <div class="footer-panel">
                <p class="eyebrow"><?php esc_html_e('Contact', 'wujin-sushi'); ?></p>
                <ul class="footer-list">
                    <li><?php echo esc_html($wujin_sushi_address); ?></li>
                    <li><a href="<?php echo esc_url('tel:' . wujin_sushi_get_phone_uri($wujin_sushi_phone)); ?>"><?php echo esc_html($wujin_sushi_phone); ?></a></li>
                    <li><a href="<?php echo esc_url('mailto:' . antispambot($wujin_sushi_email)); ?>"><?php echo esc_html(antispambot($wujin_sushi_email)); ?></a></li>
                </ul>
            </div>

            <div class="footer-panel">
                <p class="eyebrow"><?php esc_html_e('Horaires', 'wujin-sushi'); ?></p>
                <ul class="footer-list">
                    <?php foreach (wujin_sushi_get_opening_hours_lines() as $wujin_sushi_line) : ?>
                        <li><?php echo esc_html($wujin_sushi_line); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="footer-panel">
                <p class="eyebrow"><?php esc_html_e('Navigation', 'wujin-sushi'); ?></p>
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'footer',
                        'container'      => false,
                        'menu_class'     => 'footer-menu',
                        'fallback_cb'    => 'wujin_sushi_footer_menu_fallback',
                    )
                );
                ?>

                <?php if (! empty($wujin_sushi_social_links)) : ?>
                    <div class="footer-socials">
                        <?php foreach ($wujin_sushi_social_links as $wujin_sushi_network => $wujin_sushi_url) : ?>
                            <a href="<?php echo esc_url($wujin_sushi_url); ?>" target="_blank" rel="noreferrer"><?php echo esc_html($wujin_sushi_network); ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (is_active_sidebar('footer-1')) : ?>
                    <div class="footer-widget-area">
                        <?php dynamic_sidebar('footer-1'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="site-shell footer-meta">
            <p>&copy; <?php echo esc_html(wp_date('Y')); ?> <?php bloginfo('name'); ?>.</p>
            <p><?php esc_html_e('Theme built for WordPress and editable from the admin dashboard.', 'wujin-sushi'); ?></p>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
