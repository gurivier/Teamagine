<?php

include_once('pkg/erreurs.inc.php');

//== i18n
$lang=(!isset($_GET['lang']) || !($_GET['lang']=='fr' || $_GET['lang']=='en')) ? 'fr' : $_GET['lang'];
$i18n='content/lang/'.$lang.'/'.$lang.'_equipe_enregistrer.inc.php'; // $page_title
include($i18n);

//== head
$page_equipes=true;
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

$num = $_GET['e'];

if (isset($_GET['m']) && $_GET['m']=='err') {
  /*-- Message d'erreur --*/
  echo '<h3>'.$h3_1.'</h3>';
  echo '<p class="erreur">'.$p_11.'</p>';
  echo '<p>'.$p_12.'</p>';
}
else {
  /*-- Confirmation --*/
  echo '<h3>'.$h3_2.'</h3>';
  echo '<p><img src="content/img/check.png" alt="OK!" />&nbsp;'.$p_21.'</p>';
  echo '<p><a href="equipes.php?lang='.$lang.'">'.$p_22.'</a></p>';
  include('content/equipe_afficher.inc.php');
}

//== end
echo '</div>'; // corpsPage
include('page/cartouche.inc.php');
echo '</div>'; // body
echo '</body>';
echo '</html>';
?>
