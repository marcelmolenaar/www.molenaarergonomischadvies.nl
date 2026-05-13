<?php
if (php_sapi_name() !== 'cli') exit;
require '/var/www/html/wp-load.php';

echo "=== Posts van type 'nieuws' ===\n";
$posts = get_posts(['post_type' => 'nieuws', 'numberposts' => -1, 'post_status' => 'any']);
foreach ($posts as $p) {
    echo "#{$p->ID} [{$p->post_type}] {$p->post_status} - {$p->post_title}\n";
}

echo "\n=== Posts van type 'post' (zou leeg moeten zijn) ===\n";
$posts = get_posts(['post_type' => 'post', 'numberposts' => -1, 'post_status' => 'any']);
foreach ($posts as $p) {
    echo "#{$p->ID} [{$p->post_type}] {$p->post_status} - {$p->post_title}\n";
}
if (!$posts) echo "(geen)\n";

echo "\n=== Page met slug 'nieuws' ===\n";
$page = get_page_by_path('nieuws');
echo $page ? "BESTAAT: #{$page->ID} ({$page->post_status})\n" : "Verwijderd ✓\n";

echo "\n=== Opties ===\n";
echo "show_on_front: " . get_option('show_on_front') . "\n";
echo "page_on_front: " . get_option('page_on_front') . "\n";
echo "page_for_posts: " . get_option('page_for_posts') . " (zou 0 moeten zijn)\n";
echo "permalink_structure: " . get_option('permalink_structure') . "\n";
