<?php
$m = $message = '';
require_once __DIR__ . '/php/session.inc.php';

require 'php/db_departements.php';
use ASBL\DepartementRepository;


if(isset($_POST['submitDel'])) {
    $id = intval($_POST['id']);
    $_POST['id'] = null;
    DepartementRepository::deleteDept($id, $message);
    $id = null;

}
$departements = DepartementRepository::getAllDepartement($m);
require_once __DIR__ . '/inc/view.php';
?>
<?php pageStart('Départements','departement'); heading('Notre organisation','Nos départements','Découvrez les équipes qui donnent vie aux actions d’Unis pour aider.'); notice($message); ?><div class="department-grid"><?php foreach ($departements as $dept): ?><article class="department-card"><span class="eyebrow">Pôle <?= str_pad($dept->did,2,'0',STR_PAD_LEFT) ?></span><h2><?= e($dept->departement) ?></h2><p><strong><?= e($dept->nbmembres) ?></strong> membres dans cette équipe</p><div class="department-actions"><a class="text-link" href="modifierDepartement.php?did=<?= e($dept->did) ?>">Voir et modifier</a><form method="post" onsubmit="return confirm('Supprimer ce département ? Ses membres seront conservés.');"><input type="hidden" name="id" value="<?= e($dept->did) ?>"><button class="delete-link" name="submitDel">Supprimer</button></form></div></article><?php endforeach; ?></div><?php pageEnd(); ?>