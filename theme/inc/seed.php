<?php
/**
 * Content seed — wordt op theme-activatie ingelezen om de 4 pages aan te maken.
 * Aanpassen kan ook achteraf via WP-admin (Pagina's).
 */

if (!defined('ABSPATH')) {
    exit;
}

return [
    [
        'slug'     => 'home',
        'title'    => 'Home',
        'template' => '', // front-page.php pakt deze automatisch
        'content'  => '<p>Een gezonde, ergonomisch verantwoorde werkomgeving is geen luxe, maar een voorwaarde voor productiviteit, werkplezier en duurzame inzetbaarheid. Met mijn expertise help ik bedrijven een werkomgeving te creëren waarin medewerkers duurzaam inzetbaar blijven, vandaag én in de toekomst.</p>',
    ],
    [
        'slug'     => 'diensten',
        'title'    => 'Diensten',
        'template' => 'page-diensten.php',
        'content'  => <<<HTML
<p class="lead">Hieronder vind je een overzicht van de diensten die ik aanbied. Praktisch, onderbouwd en altijd afgestemd op de realiteit van uw organisatie.</p>

<h2 id="individueel-werkplekonderzoek">Individueel werkplekonderzoek</h2>
<p>Een individueel werkplekonderzoek biedt medewerkers met klachten snel en gericht inzicht in de oorzaken van hun klachten. Dit kan zowel bij beeldschermwerk als bij fysiek werk worden ingezet. Het onderzoek ondersteunt re-integratie, maar is minstens zo waardevol om klachten te verminderen en verzuim te voorkomen.</p>
<p>We analyseren alle factoren die invloed kunnen hebben op het ontstaan of in stand houden van klachten: werkplek, werkwijze, werktaken, werkomgeving, werkdruk en de balans tussen werk en privé. De resultaten worden samengevat in een helder rapport met concrete, toepasbare adviezen. Zo wordt herstel ondersteund en uitval voorkomen.</p>

<h2 id="werkplekchecks">Werkplekchecks</h2>
<p>Bij een herinrichting, verbouwing of de komst van nieuwe medewerkers is het belangrijk dat werkplekken vanaf dag één goed zijn ingesteld. Met werkplekchecks richt ik meerdere werkplekken preventief in en geef ik medewerkers praktische tips voor gezond werken.</p>
<p>Per werkplek reken ik 20–30 minuten, met een maximum van 12 werkplekken per dag. Na afloop ontvangt de organisatie een overzicht met algemene aanbevelingen.</p>

<h2 id="fysieke-belasting">Ergonomische beoordeling van fysieke belasting</h2>
<p>In productieomgevingen, laboratoria of andere fysiek intensieve werksituaties onderzoek ik welke werkzaamheden risico's vormen voor het ontstaan van klachten. Samen met medewerkers en leidinggevenden ontwikkel ik oplossingen die de fysieke belasting verlagen én de efficiëntie verhogen.</p>
<p>Het resultaat: minder klachten, hogere productiviteit en een gezondere werkomgeving.</p>

<h2 id="training-ergocoach">Training Ergocoach</h2>
<p>Ergocoaches vormen een waardevolle interne vraagbaak. Zij ondersteunen collega's bij het instellen van werkplekken en begeleiden nieuwe medewerkers direct bij binnenkomst. Dit voorkomt klachten en borgt de aandacht voor een gezonde werkomgeving binnen de organisatie.</p>
<p>De ergocoachtraining bestaat uit twee dagdelen, met een tussenliggende periode van 2–3 maanden waarin deelnemers een praktijkopdracht uitvoeren.</p>
<p><strong>Dagdeel 1: theorie en praktijk.</strong> Onderwerpen:</p>
<ul>
<li>De werking van het lichaam</li>
<li>De Arbowet</li>
<li>Richtlijnen voor het instellen van de werkplek</li>
<li>Het geven van gevraagd en ongevraagd advies</li>
<li>Praktisch oefenen met het instellen van bureaustoelen en de werkplek</li>
</ul>
<p><strong>Dagdeel 2:</strong> herhaling, uitwisseling van ervaringen en presentatie van opdrachten. Een opfriscursus bestaat uit één dagdeel.</p>

<h2 id="training-kantoor">Training 'Gezond werken op kantoor' (1 dagdeel)</h2>
<p>In deze interactieve training leren medewerkers hoe zij gezond, efficiënt en met minder belasting kunnen werken. We behandelen onder andere:</p>
<ul>
<li>Optimale werkplekinstellingen</li>
<li>De werking van het lichaam</li>
<li>Factoren die klachten veroorzaken</li>
<li>Praktische oefeningen en tips om klachten te voorkomen</li>
</ul>
<p>We wisselen theorie af met beweging, zodat deelnemers direct ervaren hoe belangrijk deze afwisseling is.</p>

<h2 id="training-fysiek">Training 'Gezond werken met fysieke belasting' (1 dagdeel)</h2>
<p>Deze training combineert theorie met praktijk op de werkvloer.</p>
<ul>
<li><strong>Theorie:</strong> werking van het lichaam, ontstaan en voorkomen van blessures, werkplekinstellingen, inzet van hulpmiddelen en richtlijnen voor gezond werken.</li>
<li><strong>Praktijk:</strong> samen knelpunten in het bedrijf bekijken en direct oefenen met verbeteringen.</li>
</ul>
<p>Zo ontstaat bewustwording en een aanzet tot gedragsverandering.</p>

<h2 id="verbouwingen">Ergonomisch advies bij verbouwingen en herinrichtingen</h2>
<p>Een ergonomisch doordacht ontwerp voorkomt problemen achteraf. Ik beoordeel tekeningen en plannen op ergonomische kwaliteit en op naleving van de Arbowet. Door vroeg in het proces mee te denken, worden knelpunten tijdig gesignaleerd en worden dure aanpassingen na oplevering voorkomen. Dit zorgt voor een toekomstbestendige, ergonomisch verantwoorde werkomgeving.</p>

<h2 id="meubilair">Advies bij de aankoop van nieuw meubilair</h2>
<p>De keuze voor goed kantoormeubilair vraagt om expertise. Ik adviseer over bureaustoelen, bureaus en andere werkplekcomponenten, afgestemd op de behoeften van uw organisatie en medewerkers. We kijken onder andere naar:</p>
<ul>
<li>Programma van Eisen</li>
<li>Gebruik van flexplekken</li>
<li>Instelhoogtes en vormen van bureaus</li>
<li>Voor- en nadelen van verschillende modellen bureaustoelen</li>
</ul>
<p>Een goede keuze voorkomt onnodige kosten en zorgt voor duurzame, passende oplossingen voor de hele organisatie.</p>

<h2 id="functieprofielen">Opstellen van functieprofielen</h2>
<p>Ik breng de fysieke belasting van verschillende werkzaamheden in kaart en vertaal dit naar duidelijke functieprofielen. Hiermee krijgt de organisatie en/of de bedrijfsarts inzicht in welke taken wel of niet geschikt zijn voor medewerkers met specifieke klachten of beperkingen. Dit ondersteunt zowel preventie als re-integratie.</p>
HTML,
    ],
    [
        'slug'     => 'over',
        'title'    => 'Over',
        'template' => 'page-over.php',
        'content'  => <<<HTML
<p>Ellen Molenaar is eigenaar en oprichter van Molenaar Ergonomisch Advies.</p>

<blockquote>
<p>Mijn loopbaan begon als oefentherapeut Mensendieck. In mijn praktijk merkte ik al snel dat veel fysieke klachten hun oorsprong vinden op de werkvloer. Dat inzicht bracht me ertoe het roer om te gooien. Na het afronden van de opleiding Ergonomie en Arbeid aan de Vrije Universiteit heb ik me volledig gericht op het bedrijfsleven.</p>

<p>Inmiddels werk ik ruim twintig jaar als ergonoom binnen een breed scala aan organisaties: telecombedrijven, ziekenhuizen, winkels, laboratoria, gemeenten, provincies, rijksoverheid, musea, industrie, onderwijs en universiteiten, magazijnen, ambulancedienst, kantoren en meer. Die diversiteit maakt mijn werk bijzonder waardevol. Ik krijg letterlijk en figuurlijk een kijkje in de keuken bij organisaties waar je normaal nooit komt. Ervaringen uit de ene branche neem ik mee naar een andere — die kruisbestuiving zorgt voor nieuwe inzichten en een brede kijk op problemen én oplossingen.</p>

<p>Ik ben van mening dat duurzame oplossingen alleen ontstaan wanneer medewerkers en leidinggevenden actief worden betrokken. Zij zijn de ervaringsdeskundigen; zij weten waar de knelpunten liggen en hebben vaak al verrassend goede ideeën voor verbetering. Door samen te onderzoeken, creëren we niet alleen draagvlak, maar ook praktische en haalbare oplossingen die écht werken.</p>
</blockquote>
HTML,
    ],
    [
        'slug'     => 'contact',
        'title'    => 'Contact',
        'template' => 'page-contact.php',
        'content'  => '<p>Heeft u vragen of wilt u een afspraak maken? Neem gerust contact op.</p>',
    ],
];
