<?php
$m = $message = '';
require_once __DIR__ . '/php/session.inc.php';
require 'php/db_personnel.php';
use ASBL\PersonnelsRepository;
const TAILLE = 5 * 1024 * 1024;

if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
else {
$user_id = $_SESSION['user_id'];
$user = PersonnelsRepository::getPersonnelById($message, $user_id);

$placeholderNom = $user->nom ?? '';
$placeholderPrenom = $user->prenom ?? '';
$placeholdertelephone = $user->telephone ?? '';
}
if(isset($_POST['Soumission'])) {
    $erreur = telechargerImage($user);
}
function telechargerImage($user) {
    $erreur = '';

    if($_FILES['image']['error'] > 0) {
        $erreur = "Erreur lors de l'envoi du fichier";
    } else {
        if($_FILES['image']['size'] > TAILLE) {
            $erreur = "Fichier trop grand";
        } else {
            $nomFichier = $_FILES['image']['name'];
            $partiesFichier = pathinfo($nomFichier);
            $extensionFichier = strtolower($partiesFichier['extension']);

            if (!in_array($extensionFichier, array('png', 'jpg'))) {
                $erreur = "Extension de fichier non valide";
            } else {
                $nomFichierDefinitif = basename($user->photo);
                if(!move_uploaded_file($_FILES['image']['tmp_name'], "uploads/ImageUtilisateurs/".$nomFichierDefinitif)) {
                    $erreur = "Erreur lors de la copie sur le serveur";
                } else {
                    $erreur = 'Photo mise à jour.';
                }
            }
        }
    }

    return $erreur;
}
require_once __DIR__ . '/inc/view.php';
?>
<?php pageStart('Mon profil'); heading('L’espace des membres','Bonjour '.$user->prenom.'.','Votre place dans le collectif, et les informations de votre profil.'); ?><div class="profile-layout"><article class="profile-card"><img src="<?= e($user->photo) ?>" alt="<?= e($user->prenom.' '.$user->nom) ?>"><span class="eyebrow">Membre de l’association</span><h2><?= e($user->prenom.' '.$user->nom) ?></h2><p><?= e($user->description) ?></p></article><form method="post" class="form-card" enctype="multipart/form-data"><h2>Votre photo de profil.</h2><input type="hidden" name="MAX_FILE_SIZE" value="<?= TAILLE ?>"><div class="field"><label for="image">Nouvelle photo</label><input type="file" id="image" name="image" accept=".png,.jpg" required><small>PNG ou JPG · 5 Mo maximum</small></div><div class="field"><label for="nom">Nom</label><input id="nom" value="<?= e($placeholderNom) ?>" readonly></div><div class="field"><label for="prenom">Prénom</label><input id="prenom" value="<?= e($placeholderPrenom) ?>" readonly></div><div class="field"><label for="telephone">Téléphone</label><input id="telephone" value="<?= e($placeholdertelephone) ?>" readonly></div><p class="form-note">L’édition des informations personnelles n’est pas encore disponible dans cette démonstration.</p><button class="button" name="Soumission">Mettre à jour la photo</button><?php notice($erreur ?? ''); ?></form></div><?php pageEnd(); ?>