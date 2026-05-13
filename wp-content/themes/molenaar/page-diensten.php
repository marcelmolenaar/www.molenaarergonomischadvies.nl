<?php
/**
 * Template Name: Diensten
 *
 * Toont de page-content (intro + 9 H2-secties) met een sticky inhoudsopgave op desktop.
 */
get_header();

$services = require get_theme_file_path('inc/services.php');
?>

<article class="wrap" style="padding-block: var(--s-5);">
    <?php while (have_posts()) : the_post(); ?>
        <h1><?php the_title(); ?></h1>

        <nav class="toc" aria-label="Inhoudsopgave">
            <h2>Inhoud</h2>
            <ul>
                <?php foreach ($services as $s) : ?>
                    <li><a href="#<?php echo esc_attr($s['anchor']); ?>"><?php echo esc_html($s['title']); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <div class="services">
            <?php the_content(); ?>
        </div>
    <?php endwhile; ?>
</article>

<?php get_footer(); ?>
