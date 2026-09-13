<?php
$lang=(!isset($_GET['lang']) || !($_GET['lang']=='fr' || $_GET['lang']=='en')) ? 'fr' : $_GET['lang'];
include('page/lang/'.$lang.'/'.$lang.'_menu.inc.php');
include_once('content/pkg/temps.inc.php'); // $H

e('<!-- '.heure().' | '.$H.' -->');

/*=== Ouvrir fichiers config ===*/

$desc = fopen('config/config_prix.txt', 'r');
$prix = fgets($desc);
fclose($desc);

/*===*/

e('<div id="menu">');

e('<img id="logoevt" src="page/img/logo-'.$ev->couleur.'.png" alt="Logo '.$ev->nom[$lang].'" />');

e('<ul>');

$class = ($selection=='informations') ? 'class="selected" ' : '';
e('<li><a '.$class.'href="index.php?lang='.$lang.'">'.$menu_1.'</a></li>');

$class = ($selection=='reglement') ? 'class="selected" ' : '';
e('<li><a '.$class.' href="reglement.php?lang='.$lang.'">'.$menu_4.'</a></li>');

if ($H>-6) {
  $class = ($selection=='equipes') ? 'class="selected" ' : '';
  e('<li><a '.$class.' href="equipes.php?lang='.$lang.'">'.$menu_9.'</a></li>');
}

if ($prix=='open') {
  $class = ($selection=='palmares') ? 'class="selected" ' : '';
  e('<li><a '.$class.' href="palmares.php?lang='.$lang.'">'.$menu_12.'</a></li>');
}

e('</ul>');

e('</div>');
?>
