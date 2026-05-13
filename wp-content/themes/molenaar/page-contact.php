<?php
/**
 * Template Name: Contact
 */
get_header();
?>

<article class="wrap" style="padding-block: var(--s-5);">
    <?php while (have_posts()) : the_post(); ?>
        <h1><?php the_title(); ?></h1>
        <?php the_content(); ?>

        <div class="contact-card">
            <dl>
                <dt>E-mail</dt>
                <dd><a href="mailto:<?php echo esc_attr(MOLENAAR_CONTACT['email']); ?>"><?php echo esc_html(MOLENAAR_CONTACT['email']); ?></a></dd>

                <dt>Telefoon</dt>
                <dd><a href="tel:<?php echo esc_attr(str_replace('-', '', MOLENAAR_CONTACT['phone'])); ?>"><?php echo esc_html(MOLENAAR_CONTACT['phone']); ?></a></dd>

                <dt>KVK</dt>
                <dd><?php echo esc_html(MOLENAAR_CONTACT['kvk']); ?></dd>

                <dt>BTW</dt>
                <dd><?php echo esc_html(MOLENAAR_CONTACT['btw']); ?></dd>
            </dl>
        </div>
    <?php endwhile; ?>
</article>

<?php get_footer(); ?>
