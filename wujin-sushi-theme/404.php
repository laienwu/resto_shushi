<?php
/**
 * Template for displaying 404 pages.
 *
 * @package Wujin_Sushi
 */

get_header();
?>

<main id="primary" class="site-main site-shell">
    <section class="empty-state">
        <p class="eyebrow"><?php esc_html_e('404', 'wujin-sushi'); ?></p>
        <h1><?php esc_html_e('Page introuvable', 'wujin-sushi'); ?></h1>
        <p><?php esc_html_e('The page you requested does not exist. Return to the homepage or explore the menu.', 'wujin-sushi'); ?></p>
        <div class="hero-actions">
            <a class="button button-primary" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Accueil', 'wujin-sushi'); ?></a>
            <a class="button button-secondary" href="<?php echo esc_url(get_post_type_archive_link('menu_item') ?: home_url('/#menu')); ?>"><?php esc_html_e('Voir la carte', 'wujin-sushi'); ?></a>
        </div>
    </section>
</main>

<?php
get_footer();
