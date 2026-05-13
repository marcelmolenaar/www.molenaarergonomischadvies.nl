<?php
/**
 * CLI-helper: trigger molenaar_seed() handmatig zonder theme-switch.
 *
 * Gebruik:
 *   docker compose exec -u www-data wordpress \
 *     php /var/www/html/wp-content/themes/molenaar/tools/run-seed.php
 */

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit("CLI-only.\n");
}

require '/var/www/html/wp-load.php';

if (!function_exists('molenaar_seed')) {
    fwrite(STDERR, "molenaar_seed() niet beschikbaar — is het theme actief?\n");
    exit(1);
}

molenaar_seed();
echo "✓ Seed uitgevoerd.\n";
