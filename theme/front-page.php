<?php
/**
 * Homepage — hero (intro uit WP-page) + dienst-tegels + over-teaser + CTA.
 */
get_header();

$services      = require get_theme_file_path('inc/services.php');
$diensten_page = get_page_by_path('diensten');
$over_page     = get_page_by_path('over');
$contact_page  = get_page_by_path('contact');
?>

<section class="hero">
    <div class="wrap">
        <div class="grid">
            <div>
                <h1>Duurzame inzetbaarheid begint bij een gezonde werkplek</h1>
                <div class="lead">
                    <?php
                    if (have_posts()) :
                        while (have_posts()) :
                            the_post();
                            the_content();
                        endwhile;
                    endif;
                    ?>
                </div>
                <?php if ($contact_page) : ?>
                    <a class="cta" href="<?php echo esc_url(get_permalink($contact_page)); ?>">Neem contact op</a>
                <?php endif; ?>
            </div>
            <img class="portrait" src="<?php echo esc_url(get_theme_file_uri('assets/images/ellen.jpg')); ?>" alt="Ellen Molenaar" width="636" height="649" loading="eager">
        </div>
    </div>
</section>

<section class="wrap" aria-labelledby="diensten-heading">
    <h2 id="diensten-heading">Diensten</h2>
    <div class="cards">
        <?php foreach ($services as $s) : ?>
            <a class="card" href="<?php echo $diensten_page ? esc_url(get_permalink($diensten_page) . '#' . $s['anchor']) : '#'; ?>">
                <h3><?php echo esc_html($s['title']); ?></h3>
                <p><?php echo esc_html($s['lead']); ?></p>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<?php if ($over_page) : ?>
    <section class="wrap over" aria-labelledby="over-heading" style="margin-top: var(--s-6);">
        <h2 id="over-heading">Over Ellen Molenaar</h2>
        <div class="grid">
            <img class="portrait" src="<?php echo esc_url(get_theme_file_uri('assets/images/ellen.jpg')); ?>" alt="" aria-hidden="true">
            <div>
                <p>Ruim twintig jaar ervaring als ergonoom in uiteenlopende sectoren — van ziekenhuizen en laboratoria tot gemeenten, industrie en onderwijs. Duurzame oplossingen ontstaan volgens Ellen alleen wanneer medewerkers en leidinggevenden actief worden betrokken.</p>
                <p><a href="<?php echo esc_url(get_permalink($over_page)); ?>">Lees verder &rarr;</a></p>
            </div>
        </div>
    </section>
<?php endif;

get_footer();
