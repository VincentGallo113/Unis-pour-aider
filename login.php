<?php
$m = $message = '';
require_once __DIR__ . '/php/session.inc.php';
if(isset($_SESSION['user_id'])) {
    header('Location: index.php');
}
require 'php/db_personnel.php';
use ASBL\PersonnelsRepository;


if(isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
if(isset($_POST['Soumission'])){
        $username = strip_tags($_POST['username']);
        $password = strip_tags($_POST['password']);
        $user = PersonnelsRepository::personnelAndpasswordMatch($username, $password);
        if(isset($user['correspond']) && $user['correspond'] === true) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Adresse e-mail ou mot de passe incorrect.";
        }

    }
if(isset($_POST['cancel'])){
    header("Location: index.php");
    exit;
}
require_once __DIR__ . '/inc/view.php';
?>
<?php pageStart('Espace membre'); ?><div class="auth-layout"><div class="auth-intro"><span class="eyebrow">L’espace des membres</span><h1>Espace membre</h1><p>Connectez-vous pour accéder à votre profil.</p></div><form method="post" class="form-card"><span class="eyebrow">Bienvenue</span><h2>Se connecter.</h2><?php notice($error ?? ''); ?><div class="field"><label for="username">Adresse e-mail</label><input type="email" id="username" name="username" autocomplete="username" required placeholder="vous@exemple.be"></div><div class="field"><label for="password">Mot de passe</label><input type="password" id="password" name="password" autocomplete="current-password" required placeholder="Votre mot de passe"></div><button class="button full" name="Soumission">Entrer dans mon espace</button><a class="muted-link" href="reset.php">Mot de passe oublié ?</a><div class="demo-note"><strong>Pour explorer la démonstration</strong><span>demo@example.test</span><span>Portfolio2026!</span></div></form></div><?php pageEnd(); ?>