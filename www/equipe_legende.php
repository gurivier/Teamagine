<?php
function e($s){echo $s."\n";}

include_once('config/Evenement.class.php'); // $ev

include_once('pkg/erreurs.inc.php');

//== i18n
$lang=(!isset($_GET['lang']) || !($_GET['lang']=='fr' || $_GET['lang']=='en')) ? 'fr' : $_GET['lang'];
$i18n='content/lang/'.$lang.'/'.$lang.'_equipe_legende.inc.php'; // $titre_page
include($i18n);

//== head
$page_equipes=true;
include('page/head.inc.php');

//== body
e('<body>');
e('<script type="text/javascript">window.resizeTo(400, 480);</script>');
e('<div id="body">');

//== content
include_once('content/class/HeureActivite.class.php');
$activite = new HeureActivite();
$activite->afficher_legende();

//== end
e('</div>'); // body
e('</body>');
e('</html>');
?>
