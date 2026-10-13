<?php
$m = $message = '';
require_once __DIR__ . '/php/session.inc.php';

require_once 'php/db_departements.php';
use ASBL\DepartementRepository;

require_once 'php/db_personnel.php';
use ASBL\PersonnelsRepository;
if(isset($_GET['did'])){
    $id = intval($_GET['did']);
    $dept = DepartementRepository::getDepartementById($id, $message);
    $MembresDuDepartement = PersonnelsRepository::getAllPersonnelByDept($id, $message);
}

if (isset($_POST['nomDept'])) {
    $nouveauNomDept = $_POST['nomDept'];
    $result = DepartementRepository::updateDepartementName($id, $nouveauNomDept, $message);
    if ($result) {
        $message = "Le nom du département a été mis à jour avec succès.";
        $dept = DepartementRepository::getDepartementById($id, $message);
    } else {
        $message = "Erreur lors de la mise à jour du nom du département.";
    }
}
if (!isset($dept) || !$dept) { http_response_code(404); exit('Département introuvable.'); }
require_once __DIR__ . '/inc/view.php';
?>
<?php pageStart('Modifier un département','departement'); ?><a class="back-link" href="departement.php">← Tous les départements</a><?php heading('Un collectif en action',$dept->departement,'Les personnes qui font vivre ce département.'); notice($message); ?><form method="post" class="inline-edit"><div class="field"><label for="nomDept">Nom du département</label><input id="nomDept" name="nomDept" value="<?= e($dept->departement) ?>" required></div><button class="button">Enregistrer</button></form><ul class="member-grid"><?php foreach ($MembresDuDepartement as $membre) memberCard($membre); ?></ul><?php pageEnd(); ?>