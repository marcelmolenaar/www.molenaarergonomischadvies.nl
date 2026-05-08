<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="<?php echo esc_url(get_theme_file_uri('assets/images/logo-mark.svg')); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#content"><?php esc_html_e('Naar inhoud', 'molenaar'); ?></a>

<header class="site-header">
    <div class="wrap inner">
        <a class="site-logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php bloginfo('name'); ?>">
            <?php echo molenaar_inline_svg('logo.svg'); ?>
        </a>
        <nav class="primary-nav" aria-label="<?php esc_attr_e('Hoofdmenu', 'molenaar'); ?>">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'fallback_cb'    => 'molenaar_default_menu',
                'depth'          => 1,
            ]);
            ?>
        </nav>
    </div>
</header>

<main id="content">
