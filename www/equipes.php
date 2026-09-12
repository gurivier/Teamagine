<?php

include_once('config/Evenement.class.php'); // $ev

include_once('pkg/erreurs.inc.php');

//== i18n
$lang=(!isset($_GET['lang']) || !($_GET['lang']=='fr' || $_GET['lang']=='en')) ? 'fr' : $_GET['lang'];
$i18n='content/lang/'.$lang.'/'.$lang.'_equipes.inc.php'; // $page_title
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

include('content/equipes.inc.php');

//== end
echo '</div>'; // corpsPage
include('page/cartouche.inc.php');
echo '</div>'; // body
echo '</body>';
echo '</html>';
?>
