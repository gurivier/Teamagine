<?php

/**
 * Retourne l'heure actuelle,
 * formatee dans une chaine de caracteres.
 */
function heure(): string {
  return date( "d M Y | H:i:s", time());
}

/**
 * Calcul le crenaux horaire durant la phase de concours.
 * 
 * Par exemple, s'il est 15h30 et que le concours a commence a 14H00,
 * alors nous avons H=2, et le crenau actuel est 15:00 - 16:00.
 */
function heure_intervalle_courant(int $h, string &$heure_debut, string &$heure_fin): void { 
  global $ev;
  
  $temps_depart = $ev->temps_depart();

  $temps_courant = $temps_depart + ($h-1) * 3600;

  $heure_debut = date( "H:i", $temps_courant);

  $heure_fin = date( "H:i", $temps_courant+3600);
}

/**
 * Retourne l'heure "H" : c'est le nombre d'heures,
 * - a venir jusqu'a l'heure de depart du concours (H<0),
 * - ecoulees depuis l'heure de depart du concours (H>0).
 */
function heure_H(): int { 
  global $ev;
    
  $time = time(); // Heure courante

  $temps_depart = $ev->temps_depart();

  if ($time >= $temps_depart) {
    $H = floor(($time - $temps_depart) / 3600) + 1;
  }
  else {
    $H = -1 * floor(($temps_depart - $time) / 3600) - 1;
  }

  if ($H > $ev->duree) {
    $H = $ev->duree;
  }

  return 1; // <=========== SUPPR
  return $H;
}

function chrono_afficher_alpha(int $h): void {
  echo '<span class="bold">'.$h.'</span><br/>';
  $debut='';
  $fin='';
  heure_intervalle_courant($h, $debut, $fin);
  echo $debut.'<br/>'.$fin;
}

function chrono_afficher(int $h, bool $avec_couleur): void {
  global $ev;

  $couleur = $avec_couleur ? $ev->couleur : 'gris';
  
  $nombre = $h; // Le nombre a decomposer

  echo '<div class="chrono">';

  /* Debut de l'affichage */
  echo '<img src="content/img/chrono2026/'.$couleur.'/bordG.png" alt="[" />';
  echo '<img src="content/img/chrono2026/'.$couleur.'/H.png" alt="H" />';
  echo '<img src="content/img/chrono2026/'.$couleur.'/egal.png" alt="=" />';

  /* Si le nombre est negatif,
   * afficher un moins,
   * puis afficher la partie absolue.
   */
  if ($nombre < 0) {
    echo '<img src="content/img/chrono2026/'.$couleur.'/moins.png" alt="-" />';
    $nombre = $nombre * -1;
  }

  /* Decomposition du nombre positif dans un tableau */
  $i = 0;
  while ($nombre>0) {
    $tab[$i++] = $nombre % 10;
    $nombre = floor($nombre / 10);
  }

  /* Affichage du nombre */
  for ($i = count($tab)-1 ; $i >= 0  ; $i--) {
    echo '<img src="content/img/chrono2026/'.$couleur.'/'.$tab[$i].'.png" alt="'.$tab[$i].'" />';
  }
  
  /* Fin de l'affichage */
  echo '<img src="content/img/chrono2026/'.$couleur.'/bordD.png" alt="]" />';

  if ($h >= -3 && $h <= $ev->duree + 1) {
    $debut='';
    $fin='';
    heure_intervalle_courant($h, $debut, $fin);
    echo '<div class="center bold '.$couleur.'">'.date('M. d').' | '.$debut.'&nbsp; &gt; &nbsp;'.$fin.'</div>';
  }
  
  echo '</div>';
}

//== Globals

$H = heure_H();

?>
