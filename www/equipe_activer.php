<?php

include_once('pkg/erreurs.inc.php');

//== i18n
$lang=(!isset($_GET['lang']) || !($_GET['lang']=='fr' || $_GET['lang']=='en')) ? 'fr' : $_GET['lang'];
$i18n='content/lang/'.$lang.'/'.$lang.'_equipe_activer.inc.php'; // $page_title
include($i18n);

//== head
include('page/head.inc.php');

//== body
echo '<body>';
echo '<div id="body">';

//== banner
include('page/entete.inc.php');

//== menu
$selected='equipes';
include('page/menu.inc.php');

//== content
echo '<div id="corpsPage" class="corps">';

/*-- Message d'erreur --*/
if (isset($_GET['mess']) && $_GET['mess'] == 'err') {
  echo '<p class="erreur">'.$txt_avert_passwd.'</p>';
}

/*-- Formulaire --*/
echo '<h3>'.$h3_1.'</h3>';
echo '<form id="FormLoginEquipe" method="post" action="equipe_verifier.action.php?lang='.$lang.'">';
echo '<p>';
echo $txt_numero.' <input class="text" type="text" id="Login" name="e" /> ';
echo $txt_passwd.' <input class="text" type="password" id="Pass" name="Pass" /> ';
echo '<input type="submit" value="'.$txt_btn_valider.'" id="FormLogin" name="FormLogin" />';
echo '</p>';
echo '</form>';

//== end
echo '</div>'; // corpsPage
include('page/cartouche.inc.php');
echo '</div>'; // body
echo '</body>';
echo '</html>';
?>
