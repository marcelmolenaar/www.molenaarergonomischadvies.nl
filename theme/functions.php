<?php
/**
 * Molenaar theme — bootstrap.
 */

if (!defined('ABSPATH')) {
    exit;
}

const MOLENAAR_CONTACT = [
    'email'   => 'ellenm@quicknet.nl',
    'phone'   => '06-44163102',
    'kvk'     => '99277492',
    'btw'     => 'NL002984193B84',
];

add_action('after_setup_theme', function (): void {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('wp-block-styles');
    add_theme_support('responsive-embeds');

    register_nav_menus([
        'primary' => __('Hoofdmenu', 'molenaar'),
    ]);
});

add_action('wp_enqueue_scripts', function (): void {
    $version = wp_get_theme()->get('Version');
    wp_enqueue_style('molenaar-style', get_stylesheet_uri(), [], $version);
});

/**
 * Veeg blog-rommel uit admin en frontend (deze site is geen blog).
 */
add_action('admin_menu', function (): void {
    remove_menu_page('edit.php');           // Berichten
    remove_menu_page('edit-comments.php');  // Reacties
});

add_action('wp_dashboard_setup', function (): void {
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
});

add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open',    '__return_false', 20, 2);

/**
 * Eenmalige seed bij theme-activatie: maak de 4 pages aan, koppel templates,
 * zet front page en bouw het hoofdmenu. Idempotent — bestaande pages worden niet overschreven.
 */
add_action('after_switch_theme', 'molenaar_seed');

function molenaar_seed(): void {
    $seed = require get_theme_file_path('inc/seed.php');
    $ids  = [];

    foreach ($seed as $page) {
        $existing = get_page_by_path($page['slug']);
        if ($existing) {
            $ids[$page['slug']] = $existing->ID;
            continue;
        }
        $id = wp_insert_post([
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'post_title'   => $page['title'],
            'post_name'    => $page['slug'],
            'post_content' => $page['content'],
        ]);
        if (is_wp_error($id) || !$id) {
            continue;
        }
        if (!empty($page['template'])) {
            update_post_meta($id, '_wp_page_template', $page['template']);
        }
        $ids[$page['slug']] = $id;
    }

    if (!empty($ids['home'])) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $ids['home']);
    }

    // Pretty permalinks aanzetten zodat /diensten/ etc. werken.
    // Belangrijk: de globale $wp_rewrite leest 'permalink_structure' op `init`. Op het moment
    // dat deze hook draait staat die nog op de oude (lege) waarde in geheugen, dus alleen
    // update_option() is niet genoeg — we moeten $wp_rewrite ook expliciet bijpraten voordat
    // flush_rewrite_rules() naar .htaccess schrijft.
    if (!get_option('permalink_structure')) {
        global $wp_rewrite;
        update_option('permalink_structure', '/%postname%/');
        if (is_object($wp_rewrite)) {
            $wp_rewrite->set_permalink_structure('/%postname%/');
            $wp_rewrite->init();
        }
        if (!function_exists('save_mod_rewrite_rules')) {
            require_once ABSPATH . 'wp-admin/includes/misc.php';
        }
        flush_rewrite_rules(true);
    }

    // Hoofdmenu opbouwen — idempotent: maak menu indien afwezig, vul alleen ontbrekende items aan,
    // koppel locatie alleen als die nog niet gezet is.
    $menu_name = 'Hoofdmenu';
    $menu      = wp_get_nav_menu_object($menu_name);
    $menu_id   = $menu ? (int) $menu->term_id : 0;

    if (!$menu_id) {
        $created = wp_create_nav_menu($menu_name);
        if (!is_wp_error($created)) {
            $menu_id = (int) $created;
        }
    }

    if ($menu_id) {
        $existing_object_ids = array_map(
            static fn($item) => (int) $item->object_id,
            wp_get_nav_menu_items($menu_id) ?: []
        );

        foreach (['home', 'diensten', 'over', 'contact'] as $slug) {
            if (empty($ids[$slug]) || in_array((int) $ids[$slug], $existing_object_ids, true)) {
                continue;
            }
            wp_update_nav_menu_item($menu_id, 0, [
                'menu-item-title'     => get_the_title($ids[$slug]),
                'menu-item-object'    => 'page',
                'menu-item-object-id' => $ids[$slug],
                'menu-item-type'      => 'post_type',
                'menu-item-status'    => 'publish',
            ]);
        }

        $locations = get_theme_mod('nav_menu_locations', []);
        if (empty($locations['primary'])) {
            $locations['primary'] = $menu_id;
            set_theme_mod('nav_menu_locations', $locations);
        }
    }
}

/**
 * Fallback voor wp_nav_menu wanneer er nog geen hoofdmenu is gekoppeld.
 * Toont de 4 hoofdpages in vaste volgorde — zo verschijnt er altijd een menu in de header.
 */
function molenaar_default_menu(): void {
    $items = [];
    foreach (['home', 'diensten', 'over', 'contact'] as $slug) {
        $page = get_page_by_path($slug);
        if ($page) {
            $items[] = $page;
        }
    }
    if (!$items) {
        return;
    }
    echo '<ul class="menu">';
    foreach ($items as $page) {
        $current = is_page($page->ID) ? ' class="current-menu-item"' : '';
        printf(
            '<li%s><a href="%s">%s</a></li>',
            $current,
            esc_url(get_permalink($page)),
            esc_html($page->post_title)
        );
    }
    echo '</ul>';
}

/**
 * Helper: SVG-logo inline renderen (zo kunnen we 'm met CSS kleuren).
 */
function molenaar_inline_svg(string $relative): string {
    $path = get_theme_file_path('assets/images/' . $relative);
    return is_readable($path) ? (string) file_get_contents($path) : '';
}
