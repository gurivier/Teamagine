<?php
function e($s){echo $s."\n";}

include_once('config/Evenement.class.php'); // $ev

include_once('pkg/erreurs.inc.php');

//== i18n
$lang=(!isset($_GET['lang']) || !($_GET['lang']=='fr' || $_GET['lang']=='en')) ? 'fr' : $_GET['lang'];
$i18n='content/lang/'.$lang.'/'.$lang.'_equipe_activer.inc.php'; // $titre_page
include($i18n);

//== head
include('page/head.inc.php');

//== body
e('<body>');
e('<div id="body">');

//== banner
include('page/entete.inc.php');

//== menu
$selection='equipes';
include('page/menu.inc.php');

//== content
e('<div id="corpsPage" class="corps">');

/*-- Message d'erreur --*/
if (isset($_GET['mess']) && $_GET['mess'] == 'err') {
  e('<p class="erreur">'.$txt_avert_passwd.'</p>');
}

/*-- Formulaire --*/
e('<h3>'.$h3_1.'</h3>');
e('<form id="FormLoginEquipe" method="post" action="equipe_verifier.action.php?lang='.$lang.'">');
e('<p>');
e($txt_numero.' <input class="text" type="text" id="Login" name="e" /> ');
e($txt_passwd.' <input class="text" type="password" id="Pass" name="Pass" /> ');
e('<input type="submit" value="'.$txt_btn_valider.'" id="FormLogin" name="FormLogin" />');
e('</p>');
e('</form>');

//== end
e('</div>'); // corpsPage
include('page/cartouche.inc.php');
e('</div>'); // body
e('</body>');
e('</html>');
?>
