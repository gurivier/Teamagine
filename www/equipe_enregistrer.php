<?php
function e($s){echo $s."\n";}

include_once('config/Evenement.class.php'); // $ev

include_once('pkg/erreurs.inc.php');

//== i18n
$lang=(!isset($_GET['lang']) || !($_GET['lang']=='fr' || $_GET['lang']=='en')) ? 'fr' : $_GET['lang'];
$i18n='content/lang/'.$lang.'/'.$lang.'_equipe_enregistrer.inc.php'; // $titre_page
include($i18n);

//== head
$page_equipes=true;
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

$num = $_GET['e'];

if (isset($_GET['m']) && $_GET['m']=='err') {
  /*-- Message d'erreur --*/
  e('<h3>'.$h3_1.'</h3>');
  e('<p class="erreur">'.$p_11.'</p>');
  e('<p>'.$p_12.'</p>');
}
else {
  /*-- Confirmation --*/
  e('<h3>'.$h3_2.'</h3>');
  e('<p><img src="content/img/check.png" alt="OK!" />&nbsp;'.$p_21.'</p>');
  e('<p><a href="equipes.php?lang='.$lang.'">'.$p_22.'</a></p>');
  include('content/equipe_afficher.inc.php');
}

//== end
e('</div>'); // corpsPage
include('page/cartouche.inc.php');
e('</div>'); // body
e('</body>');
e('</html>');
?>
