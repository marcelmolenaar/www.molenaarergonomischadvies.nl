<?php
/**
 * Template Name: Over
 *
 * Twee-koloms layout met portretfoto links (op desktop), tekst rechts.
 */
get_header();
?>

<article class="wrap over" style="padding-block: var(--s-5);">
    <?php while (have_posts()) : the_post(); ?>
        <h1><?php the_title(); ?></h1>
        <div class="grid">
            <img class="portrait" src="<?php echo esc_url(get_theme_file_uri('assets/images/ellen.jpg')); ?>" alt="Ellen Molenaar" width="636" height="649">
            <div>
                <?php the_content(); ?>
            </div>
        </div>
    <?php endwhile; ?>
</article>

<?php get_footer(); ?>
