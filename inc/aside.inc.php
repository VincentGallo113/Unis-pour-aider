<?php
if(isset($_POST['disconnect'])) {
session_destroy();
header("Location: index.php");
exit;
}
?>

<aside>
    <i class="fa-solid fa-bars III"></i>
    <nav>
        <a href="index.php">Accueil</a>
        <a href="equipe.php">Équipe</a>
        <a href="contact.php">Contact</a>
        <a href="departement.php">Département</a>
        <?php
        if(isset($_SESSION['user_id'])) {
            echo "<a href=\"profil.php\">Profil</a>";
            echo "<form method=\"POST\">
            <input type=\"submit\" name=\"disconnect\" id=\"disconnect\" value=\"Déconnexion\">
        </form>";
        } else {
            echo "<a href=\"login.php\">Se connecter</a>";
        }
        ?>

    </nav>
</aside>