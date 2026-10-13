<?php
$m = $message = '';
require_once __DIR__ . '/php/session.inc.php';

require 'php/db_actualites.php';
use ASBL\ActualiteRepository;

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $tri = isset($_GET['tri']) ? $_GET['tri'] : 'DESC';
    if($tri==='DESC') {
        $actualites = ActualiteRepository::getAllActualite($m, "DESC");
    }
    else  {
        $actualites = ActualiteRepository::getAllActualite($m, "ASC");
    }
}

if(isset($_GET['search'])) {
    $search = htmlspecialchars($_GET['search']);
    $actualites = ActualiteRepository::searchInActualites($m, $search);
}
require_once __DIR__ . '/inc/view.php';
?>
<?php pageStart('Actualités', 'actualites'); heading('Le journal de l’association','Actualités','Nos initiatives, nos rencontres et les moments qui nous font avancer ensemble.'); ?>
<div class="toolbar"><form method="get" class="search-form"><label class="sr-only" for="search">Rechercher une actualité</label><input type="search" id="search" name="search" placeholder="Rechercher une actualité…" value="<?= e($_GET['search'] ?? '') ?>"><button class="button" type="submit">Rechercher</button></form><form method="get" class="sort-form"><label for="tri">Trier par</label><select name="tri" id="tri"><option value="DESC" <?= $tri === 'DESC' ? 'selected' : '' ?>>Plus récentes</option><option value="ASC" <?= $tri === 'ASC' ? 'selected' : '' ?>>Plus anciennes</option></select><button class="button secondary">Trier</button></form><a class="text-link" href="nouvelleActu.php">+ Nouvelle actualité</a></div>
<?php notice($m); $hasNews = false; ?><div class="news-grid"><?php foreach ($actualites as $actualite) { $hasNews = true; newsCard($actualite); } ?></div><?php if (!$hasNews): ?><div class="empty-state"><h2>Aucune actualité trouvée.</h2><p>Essayez un autre mot-clé ou retrouvez toutes nos nouvelles.</p><a class="button" href="actualites.php">Voir les actualités</a></div><?php endif; ?>
<?php pageEnd(); ?>