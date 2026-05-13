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
 * Veeg blog-rommel uit admin (deze site gebruikt CPT "Nieuws", geen WP Posts).
 */
add_action('admin_menu', function (): void {
    remove_menu_page('edit.php');           // Berichten (WP Posts)
    remove_menu_page('edit-comments.php');  // Reacties
});

/**
 * Custom Post Type "Nieuws" — eigen sectie in WP-admin, eigen archief op /nieuws/.
 */
add_action('init', function (): void {
    register_post_type('nieuws', [
        'label'              => __('Nieuws', 'molenaar'),
        'labels'             => [
            'name'               => __('Nieuws', 'molenaar'),
            'singular_name'      => __('Nieuwsbericht', 'molenaar'),
            'add_new'            => __('Nieuw bericht', 'molenaar'),
            'add_new_item'       => __('Nieuw nieuwsbericht', 'molenaar'),
            'edit_item'          => __('Bericht bewerken', 'molenaar'),
            'new_item'           => __('Nieuw bericht', 'molenaar'),
            'view_item'          => __('Bericht bekijken', 'molenaar'),
            'search_items'       => __('Berichten zoeken', 'molenaar'),
            'not_found'          => __('Geen berichten gevonden', 'molenaar'),
            'not_found_in_trash' => __('Geen berichten in prullenbak', 'molenaar'),
            'menu_name'          => __('Nieuws', 'molenaar'),
        ],
        'public'             => true,
        'show_in_rest'       => true, // block editor
        'has_archive'        => 'nieuws',
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-megaphone',
        'supports'           => ['title', 'editor', 'excerpt', 'thumbnail', 'revisions'],
        'rewrite'            => ['slug' => 'nieuws', 'with_front' => false],
        'capability_type'    => 'post',
    ]);
});

add_action('wp_dashboard_setup', function (): void {
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
});

add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open',    '__return_false', 20, 2);

/**
 * Eenmalige seed bij theme-activatie: maak de hoofdpages aan, koppel templates,
 * zet front page + posts page, seed nieuwsitems, en bouw het hoofdmenu.
 * Idempotent — bestaande pages en posts worden niet overschreven.
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

    // Migratie van eerdere A-aanpak (WP Posts): page_for_posts uitzetten, oude "Nieuws"-page
    // weggooien (slug-conflict met /nieuws/-archief), en eerder geseede 'post'-entries
    // omzetten naar het CPT 'nieuws'.
    if ((int) get_option('page_for_posts') > 0) {
        update_option('page_for_posts', 0);
    }
    $old_nieuws_page = get_page_by_path('nieuws');
    if ($old_nieuws_page && $old_nieuws_page->post_type === 'page') {
        wp_delete_post($old_nieuws_page->ID, true); // hard delete — anders blokkeert het de slug
    }

    // Deze site gebruikt CPT 'nieuws' — eventuele losse WP Posts (zoals het default
    // "Hallo wereld!"-bericht) horen er niet en worden naar de prullenbak verplaatst.
    $leftover_posts = get_posts([
        'post_type'   => 'post',
        'post_status' => ['publish', 'draft', 'pending', 'future', 'private'],
        'numberposts' => -1,
    ]);
    foreach ($leftover_posts as $leftover) {
        wp_trash_post($leftover->ID);
    }

    $posts_seed = require get_theme_file_path('inc/seed-posts.php');
    foreach ($posts_seed as $post) {
        // Bestaand item met deze slug? Converteer naar 'nieuws' indien nog op 'post'.
        $existing = get_posts([
            'name'        => $post['slug'],
            'post_type'   => ['post', 'nieuws'],
            'post_status' => 'any',
            'numberposts' => 1,
        ]);
        if ($existing) {
            $existing_post = $existing[0];
            if ($existing_post->post_type !== 'nieuws') {
                set_post_type($existing_post->ID, 'nieuws');
            }
            continue;
        }
        wp_insert_post([
            'post_type'    => 'nieuws',
            'post_status'  => 'publish',
            'post_title'   => $post['title'],
            'post_name'    => $post['slug'],
            'post_excerpt' => $post['excerpt'] ?? '',
            'post_content' => $post['content'],
        ]);
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
        $desired_order = ['home', 'diensten', 'nieuws', 'over', 'contact'];

        // 1. Verwijder verweesde menu-items (refereren aan een verwijderde page).
        foreach (wp_get_nav_menu_items($menu_id) ?: [] as $item) {
            if ($item->type === 'post_type' && $item->object === 'page') {
                $page = get_post((int) $item->object_id);
                if (!$page || $page->post_status === 'trash') {
                    wp_delete_post($item->ID, true);
                }
            }
        }

        // 2. Inventariseer wat er al aanwezig is.
        $present = [];
        foreach (wp_get_nav_menu_items($menu_id) ?: [] as $item) {
            if ($item->type === 'post_type_archive' && $item->object === 'nieuws') {
                $present['nieuws'] = true;
            } elseif ($item->type === 'post_type' && $item->object === 'page') {
                $page = get_post((int) $item->object_id);
                if ($page) {
                    $present[$page->post_name] = true;
                }
            }
        }

        // 3. Voeg ontbrekende items toe (page voor de hoofdpages, post_type_archive voor Nieuws).
        foreach ($desired_order as $slug) {
            if (!empty($present[$slug])) {
                continue;
            }
            if ($slug === 'nieuws') {
                wp_update_nav_menu_item($menu_id, 0, [
                    'menu-item-title'  => __('Nieuws', 'molenaar'),
                    'menu-item-object' => 'nieuws',
                    'menu-item-type'   => 'post_type_archive',
                    'menu-item-status' => 'publish',
                ]);
            } elseif (!empty($ids[$slug])) {
                wp_update_nav_menu_item($menu_id, 0, [
                    'menu-item-title'     => get_the_title($ids[$slug]),
                    'menu-item-object'    => 'page',
                    'menu-item-object-id' => $ids[$slug],
                    'menu-item-type'      => 'post_type',
                    'menu-item-status'    => 'publish',
                ]);
            }
        }

        // 4. Sorteer in gewenste volgorde.
        $position = array_flip($desired_order);
        foreach (wp_get_nav_menu_items($menu_id) ?: [] as $item) {
            $slug = null;
            if ($item->type === 'post_type_archive' && $item->object === 'nieuws') {
                $slug = 'nieuws';
            } elseif ($item->type === 'post_type' && $item->object === 'page') {
                $page = get_post((int) $item->object_id);
                $slug = $page ? $page->post_name : null;
            }
            if ($slug !== null && isset($position[$slug])) {
                $target = $position[$slug] + 1;
                if ((int) $item->menu_order !== $target) {
                    wp_update_post(['ID' => $item->ID, 'menu_order' => $target]);
                }
            }
        }

        $locations = get_theme_mod('nav_menu_locations', []);
        if (empty($locations['primary'])) {
            $locations['primary'] = $menu_id;
            set_theme_mod('nav_menu_locations', $locations);
        }
    }

    // Flush rewrite rules — CPT-registratie heeft nieuwe routes geïntroduceerd voor /nieuws/.
    flush_rewrite_rules(true);
}

/**
 * Fallback voor wp_nav_menu wanneer er nog geen hoofdmenu is gekoppeld.
 * Toont de hoofdpages in vaste volgorde — zo verschijnt er altijd een menu in de header.
 */
function molenaar_default_menu(): void {
    $items = [];
    foreach (['home', 'diensten', 'nieuws', 'over', 'contact'] as $slug) {
        if ($slug === 'nieuws') {
            $url = get_post_type_archive_link('nieuws');
            if ($url) {
                $items[] = [
                    'url'   => $url,
                    'title' => __('Nieuws', 'molenaar'),
                    'is_current' => is_post_type_archive('nieuws') || is_singular('nieuws'),
                ];
            }
            continue;
        }
        $page = get_page_by_path($slug);
        if ($page) {
            $items[] = [
                'url'   => get_permalink($page),
                'title' => $page->post_title,
                'is_current' => is_page($page->ID),
            ];
        }
    }
    if (!$items) {
        return;
    }
    echo '<ul class="menu">';
    foreach ($items as $item) {
        $current = $item['is_current'] ? ' class="current-menu-item"' : '';
        printf(
            '<li%s><a href="%s">%s</a></li>',
            $current,
            esc_url($item['url']),
            esc_html($item['title'])
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

/**
 * Helper: render een Lucide-stijl line-icon op naam.
 */
function molenaar_icon(string $name, int $size = 28): string {
    static $icons = null;
    if ($icons === null) {
        $icons = require get_theme_file_path('inc/icons.php');
    }
    if (empty($icons[$name])) {
        return '';
    }
    return sprintf(
        '<svg class="card-icon" width="%1$d" height="%1$d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">%2$s</svg>',
        $size,
        $icons[$name]
    );
}
