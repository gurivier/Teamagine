<?php

include_once('pkg/erreurs.inc.php');

//== i18n
$lang=(!isset($_GET['lang']) || !($_GET['lang']=='fr' || $_GET['lang']=='en')) ? 'fr' : $_GET['lang'];
$i18n='content/lang/'.$lang.'/'.$lang.'_index.inc.php'; // $page_title $body_title
include($i18n);

//== head
include('page/head.inc.php');

//== body
echo '<body>';
echo '<div id="body">';

//== banner
include('page/entete.inc.php');

//== menu
$selected='informations';
include('page/menu.inc.php');

//== content
echo '<div id="corpsAccueil" class="corps">';

echo '<p class="italic bold center">'.$body_title.'</p>';

include('content/index.inc.php');

//== end
echo '</div>'; // corpsPage
include('page/cartouche.inc.php');
echo '</div>'; // body
echo '</body>';
echo '</html>';
?>
