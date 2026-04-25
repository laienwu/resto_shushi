<?php
/**
 * Imports menu items from website_analysis.html piped over STDIN.
 *
 * Usage from the host:
 * Get-Content website_analysis.html -Raw | docker compose exec -T wordpress php /var/www/html/wp-content/themes/wujin-sushi-theme/tools/import-reference-menu.php
 */

declare(strict_types=1);

$wp_load = dirname(__DIR__, 4) . '/wp-load.php';

if (! file_exists($wp_load)) {
    fwrite(STDERR, "wp-load.php not found.\n");
    exit(1);
}

require_once $wp_load;
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

if (! defined('WPINC')) {
    fwrite(STDERR, "WordPress bootstrap failed.\n");
    exit(1);
}

/**
 * Normalizes a text value extracted from the reference HTML.
 *
 * @param string $text Input text.
 * @return string
 */
function wujin_sushi_import_normalize_text(string $text): string {
    $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $text = preg_replace('/\s+/u', ' ', $text);

    return trim((string) $text);
}

/**
 * Fetches a DOM node text by ID.
 *
 * @param DOMXPath $xpath XPath instance.
 * @param string   $id    Node ID.
 * @return string
 */
function wujin_sushi_import_text_by_id(DOMXPath $xpath, string $id): string {
    $node = $xpath->query(sprintf('//*[@id="%s"]', $id))->item(0);

    if (! $node instanceof DOMNode) {
        return '';
    }

    return wujin_sushi_import_normalize_text($node->textContent);
}

/**
 * Fetches an input value by ID.
 *
 * @param DOMXPath $xpath XPath instance.
 * @param string   $id    Input ID.
 * @return string
 */
function wujin_sushi_import_value_by_id(DOMXPath $xpath, string $id): string {
    $node = $xpath->query(sprintf('//*[@id="%s"]', $id))->item(0);

    if (! $node instanceof DOMElement) {
        return '';
    }

    return trim((string) $node->getAttribute('value'));
}

/**
 * Finds or creates a menu category, matching on sanitized slug first.
 *
 * @param string               $name       Desired term name.
 * @param array<string,WP_Term> $term_index Existing indexed terms.
 * @return int
 */
function wujin_sushi_import_ensure_term(string $name, array &$term_index): int {
    $slug = sanitize_title($name);

    if (isset($term_index[$slug])) {
        $term = $term_index[$slug];

        if ($term->name !== $name) {
            $updated = wp_update_term(
                $term->term_id,
                'menu_category',
                array(
                    'name' => $name,
                    'slug' => $slug,
                )
            );

            if (! is_wp_error($updated)) {
                $term = get_term((int) $updated['term_id'], 'menu_category');

                if ($term instanceof WP_Term) {
                    $term_index[$slug] = $term;
                }
            }
        }

        return (int) $term_index[$slug]->term_id;
    }

    $created = wp_insert_term(
        $name,
        'menu_category',
        array(
            'slug' => $slug,
        )
    );

    if (is_wp_error($created)) {
        return 0;
    }

    $term = get_term((int) $created['term_id'], 'menu_category');

    if ($term instanceof WP_Term) {
        $term_index[$slug] = $term;
    }

    return (int) $created['term_id'];
}

/**
 * Finds an imported menu item by reference product ID.
 *
 * @param string $reference_id Product reference ID from the source HTML.
 * @return int
 */
function wujin_sushi_import_find_post_id(string $reference_id): int {
    $posts = get_posts(
        array(
            'post_type'      => 'menu_item',
            'post_status'    => 'any',
            'posts_per_page' => 1,
            'fields'         => 'ids',
            'meta_key'       => '_wujin_sushi_reference_id',
            'meta_value'     => $reference_id,
        )
    );

    if (empty($posts)) {
        return 0;
    }

    return (int) $posts[0];
}

/**
 * Downloads and attaches the reference image if needed.
 *
 * @param int    $post_id   Post ID.
 * @param string $image_url Source image URL.
 * @param string $title     Attachment title fallback.
 * @return void
 */
function wujin_sushi_import_attach_image(int $post_id, string $image_url, string $title): void {
    if ($image_url === '') {
        return;
    }

    $current_url = (string) get_post_meta($post_id, '_wujin_sushi_reference_image_url', true);

    if ($current_url === $image_url && has_post_thumbnail($post_id)) {
        return;
    }

    $attachment_id = media_sideload_image($image_url, $post_id, $title, 'id');

    if (is_wp_error($attachment_id)) {
        fwrite(STDERR, sprintf("Image import failed for post %d: %s\n", $post_id, $attachment_id->get_error_message()));
        return;
    }

    set_post_thumbnail($post_id, (int) $attachment_id);
    update_post_meta($post_id, '_wujin_sushi_reference_image_url', $image_url);
}

$html = stream_get_contents(STDIN);

if (! is_string($html) || trim($html) === '') {
    fwrite(STDERR, "No HTML provided on STDIN.\n");
    exit(1);
}

libxml_use_internal_errors(true);

$dom = new DOMDocument();
$loaded = $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);

if (! $loaded) {
    fwrite(STDERR, "Unable to parse HTML.\n");
    exit(1);
}

$xpath    = new DOMXPath($dom);
$products = array();

$thumb_nodes = $xpath->query('//*[starts-with(@id, "productThumb_")]');

foreach ($thumb_nodes as $thumb_node) {
    if (! $thumb_node instanceof DOMElement) {
        continue;
    }

    $reference_id = str_replace('productThumb_', '', $thumb_node->getAttribute('id'));

    if ($reference_id === '') {
        continue;
    }

    $products[$reference_id] = array(
        'reference_id' => $reference_id,
        'upc'          => wujin_sushi_import_text_by_id($xpath, 'productUpc_' . $reference_id),
        'name'         => wujin_sushi_import_text_by_id($xpath, 'productName_' . $reference_id),
        'description'  => wujin_sushi_import_text_by_id($xpath, 'productDescription_' . $reference_id),
        'price'        => wujin_sushi_import_text_by_id($xpath, 'productPrice_' . $reference_id),
        'image_url'    => wujin_sushi_import_text_by_id($xpath, 'productThumb_' . $reference_id),
        'featured'     => wujin_sushi_import_value_by_id($xpath, 'productIsMeilleurVente_' . $reference_id) === '1',
        'badge'        => '',
        'title'        => '',
        'categories'   => array(),
        'menu_order'   => 0,
    );

    $percent = (int) wujin_sushi_import_value_by_id($xpath, 'productPercent_' . $reference_id);

    if ($percent > 0) {
        $products[$reference_id]['badge'] = '-' . $percent . '%';
    }
}

$global_order  = 0;
$section_nodes = $xpath->query('//div[contains(concat(" ", normalize-space(@class), " "), " category_container ")]');

foreach ($section_nodes as $section_node) {
    if (! $section_node instanceof DOMElement) {
        continue;
    }

    $section_id = $section_node->getAttribute('id');
    $panel_id   = preg_replace('/^categoryPanel_/', '', $section_id);
    $is_featured_panel = $panel_id === 'm';
    $heading_node = $xpath->query('.//h1', $section_node)->item(0);
    $heading      = $heading_node instanceof DOMNode ? wujin_sushi_import_normalize_text($heading_node->textContent) : '';

    if ($heading === '') {
        continue;
    }

    $product_nodes = $xpath->query('.//div[contains(concat(" ", normalize-space(@class), " "), " product_item_container ")]', $section_node);

    foreach ($product_nodes as $product_node) {
        if (! $product_node instanceof DOMElement) {
            continue;
        }

        $image_node = $xpath->query('.//*[@data-productid and contains(concat(" ", normalize-space(@class), " "), " product_image ")]', $product_node)->item(0);

        if (! $image_node instanceof DOMElement) {
            continue;
        }

        $reference_id = trim((string) $image_node->getAttribute('data-productid'));

        if ($reference_id === '') {
            continue;
        }

        if (! isset($products[$reference_id])) {
            $products[$reference_id] = array(
                'reference_id' => $reference_id,
                'upc'          => '',
                'name'         => '',
                'description'  => '',
                'price'        => '',
                'image_url'    => '',
                'featured'     => false,
                'badge'        => '',
                'title'        => '',
                'categories'   => array(),
                'menu_order'   => 0,
            );
        }

        $title_node = $xpath->query('.//*[contains(concat(" ", normalize-space(@class), " "), " product_name ")]', $product_node)->item(0);

        if ($title_node instanceof DOMNode) {
            $products[$reference_id]['title'] = wujin_sushi_import_normalize_text($title_node->textContent);
        }

        if ($is_featured_panel) {
            $products[$reference_id]['featured'] = true;
        } else {
            $products[$reference_id]['categories'][$heading] = true;
        }

        if ($products[$reference_id]['menu_order'] === 0) {
            $global_order++;
            $products[$reference_id]['menu_order'] = $global_order;
        }
    }
}

$existing_terms = get_terms(
    array(
        'taxonomy'   => 'menu_category',
        'hide_empty' => false,
    )
);

$term_index = array();

if (! is_wp_error($existing_terms)) {
    foreach ($existing_terms as $existing_term) {
        $term_index[sanitize_title($existing_term->name)] = $existing_term;
    }
}

$imported_posts = 0;
$image_updates  = 0;

foreach ($products as $reference_id => $product) {
    if (empty($product['categories']) && ! $product['featured']) {
        continue;
    }

    $upc         = trim((string) $product['upc']);
    $name        = trim((string) $product['name']);
    $description = trim((string) $product['description']);
    $title       = trim((string) $product['title']);

    if ($title === '') {
        if ($upc !== '' && $name !== '') {
            $title = $upc . ' - ' . $name;
        } elseif ($name !== '') {
            $title = $name;
        } else {
            $title = 'Menu Item ' . $reference_id;
        }
    }

    $postarr = array(
        'post_type'    => 'menu_item',
        'post_status'  => 'publish',
        'post_title'   => $title,
        'post_excerpt' => $description,
        'post_content' => $description,
        'menu_order'   => (int) $product['menu_order'],
    );

    $post_id = wujin_sushi_import_find_post_id((string) $reference_id);

    if ($post_id > 0) {
        $postarr['ID'] = $post_id;
        $post_id       = (int) wp_update_post($postarr, true);
    } else {
        $post_id = (int) wp_insert_post($postarr, true);
    }

    if ($post_id <= 0 || is_wp_error($post_id)) {
        fwrite(STDERR, sprintf("Post import failed for reference ID %s.\n", $reference_id));
        continue;
    }

    update_post_meta($post_id, '_wujin_sushi_reference_id', (string) $reference_id);
    update_post_meta($post_id, '_wujin_sushi_reference_upc', $upc);
    update_post_meta($post_id, '_wujin_sushi_reference_name', $name);

    if ($product['price'] !== '') {
        update_post_meta($post_id, '_wujin_sushi_price', $product['price']);
    }

    if ($product['badge'] !== '') {
        update_post_meta($post_id, '_wujin_sushi_badge', $product['badge']);
    } else {
        delete_post_meta($post_id, '_wujin_sushi_badge');
    }

    if (! empty($product['featured'])) {
        update_post_meta($post_id, '_wujin_sushi_featured', '1');
    } else {
        delete_post_meta($post_id, '_wujin_sushi_featured');
    }

    $term_ids = array();

    foreach (array_keys($product['categories']) as $category_name) {
        $term_id = wujin_sushi_import_ensure_term($category_name, $term_index);

        if ($term_id > 0) {
            $term_ids[] = $term_id;
        }
    }

    if (! empty($term_ids)) {
        wp_set_object_terms($post_id, array_values(array_unique($term_ids)), 'menu_category', false);
    }

    $before_thumb = get_post_thumbnail_id($post_id);
    wujin_sushi_import_attach_image($post_id, (string) $product['image_url'], $title);
    $after_thumb = get_post_thumbnail_id($post_id);

    if ($after_thumb && $after_thumb !== $before_thumb) {
        $image_updates++;
    }

    $imported_posts++;
}

fwrite(STDOUT, sprintf("Imported/updated %d menu items, refreshed %d featured images.\n", $imported_posts, $image_updates));
