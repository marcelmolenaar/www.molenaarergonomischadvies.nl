<?php
/**
 * Nieuws-posts seed — eenmalig aangemaakt bij theme-activatie als ze nog niet bestaan.
 * Post type 'nieuws' (CPT) wordt geforceerd in functions.php; idempotent via slug-check.
 */

if (!defined('ABSPATH')) {
    exit;
}

return [
    [
        'slug'    => 'zitten-is-niet-het-nieuwe-roken',
        'title'   => 'Zitten is niét het nieuwe roken!',
        'excerpt' => 'De vergelijking "zitten is het nieuwe roken" zet het probleem terecht op de kaart, maar gaat mank — en doet de echte verslavingsproblematiek tekort.',
        'content' => <<<HTML
<p>De slogan "zitten is het nieuwe roken" heeft het probleem van langdurig zitten terecht op de kaart gezet, maar de vergelijking gaat mank. Veel zitten is ongezond en verhoogt het risico op vroegtijdig overlijden, dus aandacht en actie zijn absoluut nodig.</p>

<p>Maar roken is schadelijk vanaf de allereerste sigaret, werkt verslavend, schaadt ook omstanders en veroorzaakt wereldwijd aanzienlijk meer sterfte.</p>

<p>Zitten is dus níet het nieuwe roken — maar wel een serieuze leefstijluitdaging die we niet mogen negeren.</p>
HTML,
    ],
    [
        'slug'    => 'van-zitcultuur-naar-beweegcultuur',
        'title'   => 'Van zitcultuur naar beweegcultuur: hoe krijg je het wél in beweging?',
        'excerpt' => 'Wat helpt om de zittijd in een organisatie écht te verminderen? Een gecombineerde aanpak van omgeving, organisatie en gedrag.',
        'content' => <<<HTML
<p>We weten het inmiddels allemaal: te veel zitten is slecht voor je gezondheid. Toch lukt het in veel organisaties nog steeds niet om die "zittijd" echt te verminderen. Medewerkers vertellen mij vaak dat ze er geen tijd voor hebben — of zichzelf die tijd niet gunnen. Dat gevoel van tijdsdruk is hardnekkig.</p>

<p>Soms is die druk reëel: er ligt simpelweg veel werk of vergaderingen worden achter elkaar door gepland. Maar vaak leggen mensen zichzelf óók extra druk op. Alles moet vandaag af, terwijl sommige taken prima morgen kunnen. En dan is er nog iets anders: het sociale ongemak. Medewerkers zeggen regelmatig dat ze zich bezwaard voelen om elk half uur even op te staan, omdat niemand anders dat doet. Alsof bewegen betekent dat je minder hard werkt dan de collega's die de hele dag blijven zitten.</p>

<p>Maar laten we eerlijk zijn: blijven zitten is geen bewijs van productiviteit — het is vooral een gewoonte.</p>

<h2>Wat wél werkt: een gecombineerde aanpak</h2>

<p>Een beweegcultuur ontstaat niet vanzelf. Daar is een slimme mix van omgeving, organisatie en gedrag voor nodig:</p>

<h3>Een werkomgeving die uitnodigt tot bewegen</h3>
<p>Denk aan een centraal koffiepunt verder van de werkplek, een bedrijfsrestaurant of kantine met alleen (of deels) staplaatsen, statafels in vergaderruimtes, eenpersoons vergaderruimtes met een loopband of deskbike, uitgezette (lunch)wandelroutes in de omgeving, et cetera.</p>

<h3>Een werkorganisatie die stimuleert en ruimte biedt voor beweging</h3>
<p>Medewerkers krijgen de tijd om tussendoor te bewegen, leidinggevenden en collega's vinden het normaal om regelmatig het werk even te onderbreken en bijvoorbeeld een korte loopronde te maken, en managers stimuleren dit gedrag actief.</p>

<h3>Voorlichting en begeleiding voor alle medewerkers</h3>
<p>Gedragsverandering vraagt tijd, aandacht en herhaling. Mensen moeten begrijpen waarom het belangrijk is én ervaren dat het haalbaar is. Als regelmatig bewegen tijdens de werkdag normaal wordt en veel collega's dit doen, dan worden ook medewerkers die dit lastig vinden of er geen zin in hebben gestimuleerd om mee te doen.</p>

<p>Werkgevers hebben een wettelijke zorgplicht voor een gezonde en veilige werkomgeving. Medewerkers hebben de verantwoordelijkheid om de geboden mogelijkheden ook echt te benutten. En dat loont: medewerkers die regelmatig bewegen, presteren aantoonbaar beter (Van der Put, 2023). Het mes snijdt dus aan twee kanten: gezondere mensen én betere resultaten.</p>
HTML,
    ],
];
