<?php
$m = $message = '';
require_once __DIR__ . '/php/session.inc.php';

require 'php/db_actualites.php';
use ASBL\ActualiteRepository;
if(isset($_POST['Submit'])){
    $intitule = htmlspecialchars($_POST['nomActu']);
    $actualite = htmlspecialchars($_POST['descriptionActu']);
    $date = htmlspecialchars($_POST['dateActu']);
    ActualiteRepository::newActualite($m,null,$date,$intitule,$actualite);
    if (!$m) { header("Location: actualites.php"); exit; }
}
if(isset($_POST['cancel'])){
    header("Location: index.php");
    exit;
}
require_once __DIR__ . '/inc/view.php';
?>
<?php pageStart('Nouvelle actualité','actualites'); ?><a class="back-link" href="actualites.php">← Toutes les actualités</a><?php heading('Partager un moment','Ajouter une actualité','Ajoutez une initiative ou un temps fort à la vie de l’association.'); ?><form method="post" class="form-card wide-form"><?php notice($m); ?><div class="field"><label for="nomActu">Titre de l’actualité</label><input id="nomActu" name="nomActu" required placeholder="Un titre qui raconte l’essentiel"></div><div class="field"><label for="descriptionActu">Votre récit</label><textarea id="descriptionActu" name="descriptionActu" rows="8" required placeholder="Ce qui s’est passé, ce qui se prépare…"></textarea></div><div class="field"><label for="dateActu">Date</label><input type="date" id="dateActu" name="dateActu" required value="<?= date('Y-m-d') ?>"></div><div class="form-actions"><a class="text-link" href="actualites.php">Annuler</a><button class="button" name="Submit">Publier l’actualité</button></div></form><?php pageEnd(); ?>