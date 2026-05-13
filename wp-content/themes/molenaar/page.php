<?php get_header(); ?>

<article class="wrap" style="padding-block: var(--s-5);">
    <?php while (have_posts()) : the_post(); ?>
        <h1><?php the_title(); ?></h1>
        <?php the_content(); ?>
    <?php endwhile; ?>
</article>

<?php get_footer(); ?>
