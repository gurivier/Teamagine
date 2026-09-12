<?php
$lang=(!isset($_GET['lang']) || !($_GET['lang']=='fr' || $_GET['lang']=='en')) ? 'fr' : $_GET['lang'];
include('page/lang/'.$lang.'/'.$lang.'_menu.inc.php');
include_once('content/pkg/temps.inc.php'); // $H

echo '<!-- '.heure().' | '.$H.' -->';

/*=== Ouvrir fichiers config ===*/

$desc = fopen('config/config_prix.txt', 'r');
$prix = fgets($desc);
fclose($desc);

/*===*/

echo '<div id="menu">';

echo '<img id="logoevt" src="page/img/logo-'.$ev->couleur.'.png" alt="Logo '.$ev->nom[$lang].'" />';

echo '<ul>';

$class = ($selected=='informations') ? 'class="selected" ' : '';
echo '<li><a '.$class.'href="index.php?lang='.$lang.'">'.$menu_1.'</a></li>';

$class = ($selected=='reglement') ? 'class="selected" ' : '';
echo '<li><a '.$class.' href="reglement.php?lang='.$lang.'">'.$menu_4.'</a></li>';

if ($H>-6) {
  $class = ($selected=='equipes') ? 'class="selected" ' : '';
  echo '<li><a '.$class.' href="equipes.php?lang='.$lang.'">'.$menu_9.'</a></li>';
}

if ($prix=='open') {
  $class = ($selected=='palmares') ? 'class="selected" ' : '';
  echo '<li><a '.$class.' href="palmares.php?lang='.$lang.'">'.$menu_12.'</a></li>';
}

echo '</ul>';

echo '</div>';
?>
