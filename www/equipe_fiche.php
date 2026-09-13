<?php
function e($s){echo $s."\n";}

include_once('config/Evenement.class.php'); // $ev

include_once('pkg/erreurs.inc.php');

//== i18n
$lang=(!isset($_GET['lang']) || !($_GET['lang']=='fr' || $_GET['lang']=='en')) ? 'fr' : $_GET['lang'];
$i18n='content/lang/'.$lang.'/'.$lang.'_equipe_fiche.inc.php'; // $titre_page
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

include('content/equipe_fiche.inc.php');

//== end
e('</div>'); // corpsPage
include('page/cartouche.inc.php');
e('</div>'); // body
e('</body>');
e('</html>');
?>
