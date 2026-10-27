<?php
$lang=(!isset($_GET['lang']) || !($_GET['lang']=='fr' || $_GET['lang']=='en')) ? 'fr' : $_GET['lang'];
include('page/lang/'.$lang.'/'.$lang.'_menu.inc.php');
include_once('content/pkg/temps.inc.php'); // $H

$montrer_palmares=file_exists('config/runtime/palmares');

e('<div id="menu">');

e('<img id="logoevt" src="page/img/logo-'.$ev->couleur.'.png" alt="Logo '.$ev->nom[$lang].'" />');

e('<ul>');

$class = ($selection=='informations') ? 'class="selected" ' : '';
e('<li><a '.$class.'href="index.php?lang='.$lang.'">'.$menu_1.'</a></li>');

$class = ($selection=='reglement') ? 'class="selected" ' : '';
e('<li><a '.$class.' href="reglement.php?lang='.$lang.'">'.$menu_4.'</a></li>');

if ($H >= $ev->H_ouvrir_equipes) {
  $class = ($selection=='equipes') ? 'class="selected" ' : '';
  e('<li><a '.$class.' href="equipes.php?lang='.$lang.'">'.$menu_9.'</a></li>');
}

if ($montrer_palmares) {
  $class = ($selection=='palmares') ? 'class="selected" ' : '';
  e('<li><a '.$class.' href="palmares.php?lang='.$lang.'">'.$menu_12.'</a></li>');
}

e('</ul>');

e('</div>');
?>
