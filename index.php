<?php
$m = $message = '';
require_once __DIR__ . '/php/session.inc.php';

require 'php/db_actualites.php';
use ASBL\ActualiteRepository;
$latestActualites = ActualiteRepository::getMostRecentActualies($m);
require_once __DIR__ . '/inc/view.php';
?>
<?php pageStart('Accueil', 'accueil'); ?>
<section class="hero">
    <h1>Bienvenue chez Unis pour aider</h1>
    <p>Notre association accompagne les personnes qui en ont besoin grâce au mentorat professionnel et au transport solidaire.</p>
    <a class="button" href="contact.php">Nous contacter</a>
</section>
<section class="section" id="services">
    <h2>Nos services</h2>
    <div class="service-grid">
        <article class="service-card">
            <h3>Mentorat professionnel</h3>
            <p>Des professionnels bénévoles accompagnent les personnes en recherche d’emploi pour développer leurs compétences et découvrir de nouvelles opportunités.</p>
            <a class="text-link" href="contact.php">En savoir plus</a>
        </article>
        <article class="service-card">
            <h3>Transport solidaire</h3>
            <p>Nos bénévoles aident les personnes âgées ou à mobilité réduite à se déplacer pour leurs rendez-vous médicaux, leurs courses et leurs besoins quotidiens.</p>
            <a class="text-link" href="contact.php">En savoir plus</a>
        </article>
    </div>
</section>
<section class="section">
    <div class="section-heading">
        <h2>Dernières actualités</h2>
        <a class="text-link" href="actualites.php">Toutes les actualités</a>
    </div>
    <div class="news-grid">
        <?php foreach ($latestActualites as $actualite) newsCard($actualite); ?>
    </div>
</section>
<?php pageEnd(); ?>
