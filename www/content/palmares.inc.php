<?php

include_once('class/Equipe.class.php');

//== CLASSE

class Vainqueur {
    
  function __construct($num_equipe, $txt_prix, $img_prix) {
    $this->num_equipe = $num_equipe;
    $this->txt_prix = $txt_prix;
    $this->img_prix = $img_prix;
  }

  var $num_equipe;
  var $txt_prix;
  var $img_prix;
}

//== VARIABLE

/* Palmares des equipes dans l'ordre de classement (en partant du premier prix) */
$vainqueurs = [
 new Vainqueur('100', $h2_1, 'content/img/totem2026_'.$lang.'.png'),
 new Vainqueur('011', $h2_2, ''),
 new Vainqueur('010', $h2_3, '')
];

//== HTML

foreach ($vainqueurs as $vainqueur) {
  $equipe = new Equipe($vainqueur->num_equipe);
  $equipe->unserialize();
  $equipe->afficher_pour_palmares($vainqueur->txt_prix, $vainqueur->img_prix);
}

?>
