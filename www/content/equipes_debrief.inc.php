<?php

echo "<!-- DEBUT DEBRIEF -->\r\n";

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

echo '<ul class="equipes">'."\r\n";

/* Parcours du repertoire */
$i = 1;
while ($f = readdir($dir)) {
  if (is_file($dirname.$f)) {

    if ($i % 9 == 0) {
      echo '</ul><ul class="equipes">'."\r\n";
    }
    $i++;
 
    $num = GetFileName($f);

    /* Creer une equipe a partir du fichier */
    $equipe = new Equipe($num);
    $equipe->unserialize();
    array_push($tab_equipes, $equipe);

    /* Afficher le raccourcis */
    echo '<li><a href="#'.$num.'">'.$num.'-'.str_replace(' ', '&nbsp;', $equipe->get_nom()).'</a></li>'."\r\n";
  }
}

echo '</ul>'."\r\n";

/* Fermeture du repertoire */
closedir($dir);


echo '<br class="flux" />';

/* Afficher les equipes */
foreach ($tab_equipes as $key=>$equipe) {
    $equipe->afficher_debrief();
}

echo "<!-- FIN DEBRIEF -->\r\n";

?>
