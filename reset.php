<?php
$m = $message = '';
require_once __DIR__ . '/php/session.inc.php';
if(isset($_POST['cancel'])){
    header("Location: index.php");
    exit;
}
require_once __DIR__ . '/inc/view.php';
?>
<?php pageStart('Mot de passe oublié'); ?><div class="form-card reset-card"><span class="eyebrow">Espace membre</span><h1>Mot de passe oublié</h1><p>La réinitialisation par e-mail n’est pas disponible dans cette démonstration locale. Utilisez le compte de présentation pour explorer le projet.</p><div class="demo-note"><strong>Compte de démonstration</strong><span>demo@example.test</span><span>Portfolio2026!</span></div><a class="button full" href="login.php">Retour à la connexion</a></div><?php pageEnd(); ?>