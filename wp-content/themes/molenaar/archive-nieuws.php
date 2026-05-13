<?php
/**
 * Nieuwsarchief — gerenderd op /nieuws/ (CPT-archief).
 */
get_header();
?>

<article class="wrap news-archive">
    <p class="section-eyebrow">Nieuws</p>
    <h1 class="section-title"><?php post_type_archive_title(); ?></h1>

    <?php if (have_posts()) : ?>
        <div class="news-list">
            <?php while (have_posts()) : the_post(); ?>
                <article class="news-card">
                    <p class="news-date"><time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time></p>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <p class="news-excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>
                    <p><a class="news-readmore" href="<?php the_permalink(); ?>">Lees verder &rarr;</a></p>
                </article>
            <?php endwhile; ?>
        </div>

        <?php
        the_posts_pagination([
            'mid_size'  => 2,
            'prev_text' => '&larr; Vorige',
            'next_text' => 'Volgende &rarr;',
        ]);
        ?>
    <?php else : ?>
        <p><?php esc_html_e('Er zijn nog geen nieuwsberichten.', 'molenaar'); ?></p>
    <?php endif; ?>
</article>

<?php get_footer();
