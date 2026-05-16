<?php
/**
 * Diensten-overzicht voor de homepage-tegels.
 * Anchor verwijst naar het corresponderende H2-id op /diensten/.
 * Icon-namen mappen op theme/inc/icons.php.
 */

if (!defined('ABSPATH')) {
    exit;
}

return [
    ['anchor' => 'individueel-werkplekonderzoek', 'icon' => 'user-search',     'title' => 'Individueel werkplekonderzoek',                  'lead' => 'Snel inzicht in oorzaken van klachten bij beeldscherm- of fysiek werk.'],
    ['anchor' => 'werkplekchecks',                'icon' => 'clipboard-check', 'title' => 'Werkplekchecks',                                  'lead' => 'Meerdere werkplekken preventief inrichten met praktische tips.'],
    ['anchor' => 'fysieke-belasting',             'icon' => 'activity',        'title' => 'Beoordeling fysieke belasting',                   'lead' => 'Risico\'s in fysiek belastend werk in kaart brengen en aanpakken'],
    ['anchor' => 'training-ergocoach',            'icon' => 'graduation-cap',  'title' => 'Training Ergocoach',                              'lead' => 'Interne vraagbaak opleiden in twee dagdelen met praktijkopdracht.'],
    ['anchor' => 'training-kantoor',              'icon' => 'monitor',         'title' => 'Training Gezond werken op kantoor',               'lead' => 'Interactieve sessie over werkplek, lichaam en gezond gedrag.'],
    ['anchor' => 'training-fysiek',               'icon' => 'dumbbell',        'title' => 'Training Gezond werken met fysieke belasting',    'lead' => 'Theorie en praktijk op de werkvloer.'],
    ['anchor' => 'verbouwingen',                  'icon' => 'building',        'title' => 'Advies bij verbouwingen en herinrichtingen',      'lead' => 'Tekeningen en plannen ergonomisch beoordelen.'],
    ['anchor' => 'meubilair',                     'icon' => 'armchair',        'title' => 'Advies bij aankoop van meubilair',                'lead' => 'Onderbouwde keuze voor stoelen, bureaus en werkplekcomponenten.'],
    ['anchor' => 'functieprofielen',              'icon' => 'file-text',       'title' => 'Functieprofielen opstellen',                      'lead' => 'Fysieke belasting per functie in kaart brengen, voor preventie en re-integratie.'],
];
