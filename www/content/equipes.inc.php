<?php

include_once('pkg/verif.inc.php');

echo "<!-- DEBUT SUIVI -->\r\n";

/*=== Informations diverses (Heure, Legende...) ===*/

echo '<div class="fluxL">';

echo '<p class="bold">'.$body_title_01.'<br/>'.$body_title_02.'<br/><br/></p>';

include_once('config/params.inc.php'); // $ev
include_once('pkg/temps.inc.php'); // $H

echo '<p>'.heure().'</p>';

chrono_afficher($H, ($H > 0 && $H < $ev->duree) ? 'rouge' : 'gris');

include_once('class/HeureActivite.class.php');

if ($H >= 0 && $H <= $ev->duree + 1) {
  /* Afficher la legende */
  echo '<div class="tlegende">';
  $activite = new HeureActivite();
  $activite->afficher_legende();
  echo '</div>';
}
else {
  /* Afficher le a-propos */
  echo '<p class="apropos"><span class="bold">'.$txt_apropos.'</span><br/>';
  echo $txt_apropos_conception.' Olivier Z&eacute;phir '.$txt_apropos_et.' Olivier Pialot<br/>';
  echo $txt_apropos_devel.' Guillaume Rivi&egrave;re</p>';
}

echo '</div>';

/*=== Menu lateral avec les noms des équipes ===*/

include_once('class/Equipe.class.php');

/** GetExtensionName - Renvoie le nom d'un fichier sans l'extension */
function GetFileName($File) {
  return substr($File, 0, strrpos($File, '.'));
}

/*-- Parcourir le repertoire et afficher les equipes --*/
$dirname = 'data/equipes/';

/* Ouverture du repertoire */

// if (!$dir = opendir($dirname)) {
//   echo "Erreur ouverture r&eacute;pertoire fiches";
// }

$tab_dir = scandir($dirname); // PHP 5, PHP 7, PHP 8
$tab_equipes = array();

echo '<ul class="equipes">'."\r\n";

/* Parcours du repertoire */
$j=0;
for ($i = 0 ; $i < count($tab_dir) ; $i++) {
  $f = $tab_dir[$i];

  if (is_file($dirname.$f)) {
    
    $num = GetFileName($f);

    if (est_numero_valide($num)) {
    
      /* Creer une equipe a partir du fichier */
      $equipe = new Equipe($num);
      $equipe->unserialize();
      array_push($tab_equipes, $equipe);
  
      /* Calculer le nom raccourcis */
      $nom_equipe_ascii_full = str_replace('\\\'', "'", $equipe->get_nom());
      $nom_equipe_ascii_short = '';
      $len_ascii = strlen($nom_equipe_ascii_full);
      $len_html = 0;
      $k = 0;
      while ($k<$len_ascii && $len_html<22) {
        $nom_equipe_ascii_short .= $nom_equipe_ascii_full[$k];
        $len_html++;
        if ($nom_equipe_ascii_full[$k++] == '&') {
          while($nom_equipe_ascii_full[$k] != ';' && $k < $len_ascii) {
            $nom_equipe_ascii_short .= $nom_equipe_ascii_full[$k++];
          }
          $nom_equipe_ascii_short .= $nom_equipe_ascii_full[$k++];
        }
      }
  
      /* Afficher le raccourcis */
      echo '<li><a href="#'.$num.'">'.str_replace(' ', '&nbsp;', $nom_equipe_ascii_short).'</a></li>'."\r\n";
  
      $j++;
      if ($j % 9 == 0) {
        echo '</ul><ul class="equipes">'."\r\n";
      }
    }
  }
}


/* Parcours du repertoire */
// $i = 1;
// while ($f = readdir($dir)) {
//   if (is_file($dirname.$f)) {
// 
//     if ($i % 19 == 0) {
//       echo '</ul><ul class="equipes">'."\r\n";
//     }
//     $i++;
//  
//     $num = GetFileName($f);
// 
//     /* Creer une equipe a partir du fichier */
//     $equipe = new Equipe($num);
//     $equipe->unserialize();
//     array_push($tab_equipes, $equipe);
// 
//     /* Afficher le raccourcis */
//     echo '<li><a href="#'.$num.'">'.str_replace(' ', '&nbsp;', substr(str_replace('\\\'', "'", $equipe->get_nom()), 0, 22)).'</a></li>'."\r\n";
//   }
// }

echo '</ul>'."\r\n";

/* Fermeture du repertoire */
//closedir($dir);

if ($H > 0 && $H <= $ev->duree) {
  echo '<p class="fluxR"><a href="equipe_activer.php?lang='.$lang.'">'.$txt_activer_fiche.'&nbsp;&nbsp;</p>'."\r\n";
}

echo '<br class="flux" />';

/*=== Activites des equipes ===*/

/* Afficher les equipes */
foreach ($tab_equipes as $key => $equipe) {
    $equipe->afficher();
}

echo "<!-- FIN SUIVI -->\r\n";

?>
