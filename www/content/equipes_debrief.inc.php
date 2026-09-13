<?php

e('<!-- DEBUT DEBRIEF -->');

include_once('class/Equipe.class.php');

/** GetExtensionName - Renvoie le nom d'un fichier sans l'extension */
function GetFileName($File) {
  return substr($File, 0, strrpos($File, '.'));
}

/*-- Parcourir le repertoire et afficher les equipes -- */
$dirname = 'data/equipes/';

/* Ouverture du repertoire */
$dir = opendir($dirname);

$tab_equipes = array();

e('<ul class="equipes">');

/* Parcours du repertoire */
$i = 1;
while ($f = readdir($dir)) {
  if (is_file($dirname.$f)) {

    if ($i % 9 == 0) {
      e('</ul><ul class="equipes">');
    }
    $i++;
 
    $num = GetFileName($f);

    /* Creer une equipe a partir du fichier */
    $equipe = new Equipe($num);
    $equipe->unserialize();
    array_push($tab_equipes, $equipe);

    /* Afficher le raccourcis */
    e('<li><a href="#'.$num.'">'.$num.'-'.str_replace(' ', '&nbsp;', $equipe->get_nom()).'</a></li>');
  }
}

e('</ul>');

/* Fermeture du repertoire */
closedir($dir);

e('<br class="flux" />');

/* Afficher les equipes */
foreach ($tab_equipes as $key=>$equipe) {
  $equipe->afficher_debrief();
}

e('<!-- FIN DEBRIEF -->');

?>
