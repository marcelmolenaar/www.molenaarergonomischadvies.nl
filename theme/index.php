<?php
/**
 * Fallback-template — komt zelden in beeld bij een page-only site.
 */
get_header();
?>

<article class="wrap" style="padding-block: var(--s-5);">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <h1><?php the_title(); ?></h1>
        <?php the_content(); ?>
    <?php endwhile; else : ?>
        <h1><?php esc_html_e('Pagina niet gevonden', 'molenaar'); ?></h1>
        <p><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Terug naar de homepage', 'molenaar'); ?></a></p>
    <?php endif; ?>
</article>

<?php get_footer();
