<?php
/**
 * Canonical URLs for indexable pages.
 */

if (!defined('ABSPATH')) {
    exit;
}

remove_action('wp_head', 'rel_canonical');
add_action('wp_head', 'molenaar_output_canonical', 1);

function molenaar_output_canonical(): void {
    if (is_admin() || is_feed() || is_search() || is_404() || is_preview()) {
        return;
    }

    if (is_singular()) {
        $canonical_url = wp_get_canonical_url();
    } elseif (is_home()) {
        $posts_page_id = (int) get_option('page_for_posts');
        $canonical_url = $posts_page_id ? get_permalink($posts_page_id) : home_url('/');
    } elseif (is_post_type_archive()) {
        $canonical_url = get_post_type_archive_link(get_query_var('post_type'));
    } elseif (is_archive()) {
        $canonical_url = get_pagenum_link();
        $query_args = array_diff(array_keys($_GET), ['paged']);
        if ($query_args) {
            $canonical_url = remove_query_arg($query_args, $canonical_url);
        }
    } else {
        return;
    }

    if ($canonical_url) {
        printf("<link rel=\"canonical\" href=\"%s\" />\n", esc_url($canonical_url));
    }
}
