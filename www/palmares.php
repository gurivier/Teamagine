<?php

include_once('config/Evenement.class.php'); // $ev

include_once('pkg/erreurs.inc.php');

//== i18n
$lang=(!isset($_GET['lang']) || !($_GET['lang']=='fr' || $_GET['lang']=='en')) ? 'fr' : $_GET['lang'];
$i18n='content/lang/'.$lang.'/'.$lang.'_palmares.inc.php'; // $titre_page $titre_corps
include($i18n);

//== head
include('page/head.inc.php');

//== body
echo '<body>';
echo '<div id="body">';

//== banner
include('page/entete.inc.php');

//== menu
$selection='palmares';
include('page/menu.inc.php');

//== content
echo '<div id="corpsPage" class="corps">';

echo '<p class="italic bold center">'.$titre_corps.'</p>';

include('content/palmares.inc.php');

echo '<br/><br/>';

//== end
echo '</div>'; // corpsPage
include('page/cartouche.inc.php');
echo '</div>'; // body
echo '</body>';
echo '</html>';
?>
