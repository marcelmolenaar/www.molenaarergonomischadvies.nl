<?php
/**
 * Single nieuwsbericht (CPT "nieuws").
 */
get_header();

$archive_url = get_post_type_archive_link('nieuws') ?: home_url('/');
?>

<article class="wrap news-single">
    <?php while (have_posts()) : the_post(); ?>
        <p class="section-eyebrow"><a href="<?php echo esc_url($archive_url); ?>">&larr; Nieuws</a></p>
        <p class="news-date"><time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time></p>
        <h1><?php the_title(); ?></h1>

        <div class="news-body">
            <?php the_content(); ?>
        </div>

        <p class="news-back">
            <a href="<?php echo esc_url($archive_url); ?>">&larr; <?php esc_html_e('Terug naar nieuwsoverzicht', 'molenaar'); ?></a>
        </p>
    <?php endwhile; ?>
</article>

<?php get_footer();
