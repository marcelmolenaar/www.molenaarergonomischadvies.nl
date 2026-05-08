<?php
/**
 * Molenaar theme — bootstrap.
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('after_setup_theme', function (): void {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);

    register_nav_menus([
        'primary' => __('Hoofdmenu', 'molenaar'),
    ]);
});

add_action('wp_enqueue_scripts', function (): void {
    $version = wp_get_theme()->get('Version');
    wp_enqueue_style('molenaar-style', get_stylesheet_uri(), [], $version);
});
