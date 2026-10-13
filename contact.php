<?php
$m = $message = '';
require_once __DIR__ . '/php/session.inc.php';

require './php/PHPMailer/src/PHPMailer.php';
require './php/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
if(isset($_POST['submitContact'])) {
$intitule = htmlspecialchars($_POST['intitule']);
$mail = htmlspecialchars($_POST['mail']);
$mailBody = htmlspecialchars($_POST['contact']);
$returnSendMail = sendMail($intitule, $mail, $mailBody);
}

function sendMail($intitule, $mailSource, $mailBody)
{
    if (!filter_var($mailSource, FILTER_VALIDATE_EMAIL) || trim($intitule) === '' || trim($mailBody) === '') {
        return 'Merci de renseigner un objet, une adresse e-mail valide et un message.';
    }
    require_once __DIR__ . '/php/db_link.inc.php';
    $message = '';
    $db = \DB\DBLink::connect2db(MYDB, $message);
    $db->exec('CREATE TABLE IF NOT EXISTS Messages (id INTEGER PRIMARY KEY AUTOINCREMENT, objet TEXT NOT NULL, email TEXT NOT NULL, message TEXT NOT NULL, date_creation TEXT DEFAULT CURRENT_TIMESTAMP)');
    $stmt = $db->prepare('INSERT INTO Messages (objet, email, message) VALUES (?, ?, ?)');
    $stmt->execute([$intitule, $mailSource, $mailBody]);
    return 'Mode démonstration : message enregistré dans la base locale. Aucun e-mail envoyé.';
}

if(isset($_POST['cancel'])){
    header("Location: index.php");
    exit;
}
require_once __DIR__ . '/inc/view.php';
?>
<?php pageStart('Contact'); ?><div class="contact-layout"><div><?php heading('Un premier pas, un nouveau lien','Contactez-nous','Une question, une idée, besoin d’un coup de main ? Prenons le temps d’en parler.'); ?><div class="contact-details"><span class="eyebrow">À notre rencontre</span><h3>Liège, Belgique</h3><p>Rue de Harlez 25</p><div class="contact-detail-line"></div><p>Une association de proximité,<br>une équipe à votre écoute.</p></div></div><form method="post" class="form-card"><span class="eyebrow">Votre message</span><h2>On vous écoute.</h2><div class="field"><label for="intitule">Objet</label><input id="intitule" name="intitule" placeholder="De quoi souhaitez-vous parler ?" required></div><div class="field"><label for="mail">Adresse e-mail</label><input type="email" id="mail" name="mail" placeholder="vous@exemple.be" required></div><div class="field"><label for="contact">Message</label><textarea id="contact" name="contact" rows="6" placeholder="Dites-nous en quelques mots…" required></textarea></div><div class="form-actions"><a class="text-link" href="index.php">Annuler</a><button class="button" name="submitContact">Envoyer mon message</button></div><?php notice($returnSendMail ?? ''); ?><p class="form-note">Démonstration : votre message est enregistré localement, sans envoi d’e-mail.</p></form></div><?php pageEnd(); ?>