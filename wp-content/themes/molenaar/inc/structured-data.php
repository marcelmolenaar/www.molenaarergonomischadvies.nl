<?php
/**
 * Structured data for the site, its owner and news articles.
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('wp_head', 'molenaar_output_structured_data', 30);

function molenaar_output_structured_data(): void {
    if (is_admin() || is_feed() || is_search() || is_404()) {
        return;
    }

    if (!is_front_page() && !is_singular() && !is_post_type_archive()) {
        return;
    }

    $site_url         = home_url('/');
    $organization_id  = $site_url . '#organization';
    $person_id        = $site_url . '#ellen-molenaar';
    $website_id       = $site_url . '#website';
    $webpage_id       = '';

    if (is_front_page()) {
        $page_url = $site_url;
    } elseif (is_singular()) {
        $page_url = get_permalink();
    } else {
        $page_url = get_pagenum_link();
    }

    $webpage_id = $page_url . '#webpage';

    $organization = [
        '@type'   => 'Organization',
        '@id'     => $organization_id,
        'name'    => get_bloginfo('name'),
        'url'     => $site_url,
        'email'   => MOLENAAR_CONTACT['email'],
        'telephone' => MOLENAAR_CONTACT['phone'],
        'logo'    => [
            '@type' => 'ImageObject',
            'url'   => get_theme_file_uri('assets/images/logo-mark.svg'),
        ],
        'founder' => [
            '@id' => $person_id,
        ],
    ];

    $person = [
        '@type'    => 'Person',
        '@id'      => $person_id,
        'name'     => 'Ellen Molenaar',
        'url'      => home_url('/over/'),
        'image'    => get_theme_file_uri('assets/images/ellen.jpg'),
        'jobTitle' => 'Ergonoom',
        'worksFor' => [
            '@id' => $organization_id,
        ],
    ];

    $website = [
        '@type'      => 'WebSite',
        '@id'        => $website_id,
        'url'        => $site_url,
        'name'       => get_bloginfo('name'),
        'publisher'  => [
            '@id' => $organization_id,
        ],
        'inLanguage' => get_bloginfo('language'),
    ];

    $webpage = [
        '@type'      => is_post_type_archive() ? 'CollectionPage' : 'WebPage',
        '@id'        => $webpage_id,
        'url'        => $page_url,
        'name'       => wp_get_document_title(),
        'isPartOf'   => [
            '@id' => $website_id,
        ],
        'inLanguage' => get_bloginfo('language'),
    ];

    $description = '';
    if (is_singular()) {
        $description = get_the_excerpt();
    } elseif (is_post_type_archive('nieuws')) {
        $description = 'Nieuws en artikelen over ergonomie, gezond werken en fysieke belasting op het werk.';
    }
    if ($description !== '') {
        $webpage['description'] = wp_strip_all_tags($description);
    }

    $graph = [$organization, $person, $website, $webpage];

    if (is_front_page()) {
        $graph[3]['mainEntity'] = [
            '@id' => $organization_id,
        ];
    }

    if (is_singular('nieuws')) {
        $article = get_post();
        if ($article) {
            $news_article = [
                '@type'            => 'NewsArticle',
                '@id'              => $page_url . '#article',
                'headline'          => get_the_title($article),
                'datePublished'     => get_the_date(DATE_W3C, $article),
                'dateModified'      => get_the_modified_date(DATE_W3C, $article),
                'mainEntityOfPage'  => [
                    '@id' => $webpage_id,
                ],
                'publisher'         => [
                    '@id' => $organization_id,
                ],
                'inLanguage'        => get_bloginfo('language'),
            ];

            $article_description = get_the_excerpt($article);
            if ($article_description !== '') {
                $news_article['description'] = wp_strip_all_tags($article_description);
            }

            $image_url = get_the_post_thumbnail_url($article, 'full');
            if ($image_url) {
                $news_article['image'] = [$image_url];
            }

            $author_id = (int) get_post_field('post_author', $article);
            $author_name = get_the_author_meta('display_name', $author_id);
            if ($author_name !== '') {
                $news_article['author'] = [
                    '@type' => 'Person',
                    'name'  => $author_name,
                ];
            }

            $graph[3]['mainEntity'] = [
                '@id' => $news_article['@id'],
            ];
            $graph[] = $news_article;
        }
    }

    $json = wp_json_encode(
        ['@context' => 'https://schema.org', '@graph' => $graph],
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
    );

    if ($json === false) {
        error_log('Molenaar structured data could not be encoded as JSON-LD.');
        return;
    }

    echo '<script type="application/ld+json">' . $json . '</script>' . "\n";
}
