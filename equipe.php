<?php
$m = $message = '';
require_once __DIR__ . '/php/session.inc.php';

require 'php/db_personnel.php';
use ASBL\PersonnelsRepository;

$personnel = PersonnelsRepository::getAllEquipes($m);
require_once __DIR__ . '/inc/view.php';
?>
<?php pageStart('Notre équipe', 'equipe'); heading('Les visages de l’engagement','Notre équipe','Des parcours différents, une ambition commune : être présents là où un coup de main fait la différence.'); notice($m); ?>
<div class="section-line"><span>Les membres de l’association</span><span>Liège · Belgique</span></div><ul class="member-grid"><?php foreach ($personnel as $membre) memberCard($membre); ?></ul><?php pageEnd(); ?>