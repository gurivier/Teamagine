<?php

include_once('pkg/verif.inc.php');
include_once('pkg/temps.inc.php'); // $H
include_once('class/Equipe.class.php');

/*-- Affichage de la fiche equipe --*/

/* Numero de l'equipe */
if (isset($_GET['e']) && est_numero_valide($_GET['e'])) {
  $num = $_GET['e'];
}
else if (isset($_POST['e']) && est_numero_valide($_POST['e'])) {
  $num = $_POST['e'];
}
else {
  $num = null;
  echo '<p>Num&eacute;ro d\'&eacute;quipe invalide.</p>';
}

if ($num != null) {
    
  /* Formulaire de la fiche equipe */     
  echo '<form id="FormFicheEquipe" method="post" action="equipe_enregistrer.action.php?lang='.$lang.'&amp;e='.$num.'">'."\r\n";

  /* Afficher le numero de l'equipe */
  echo '<h2>'.$num.'</h2>'."\r\n";

  echo '<p class="bold">'.$txt_avert_save.'</p>';

  echo '<p class="warn italic bold">('.$txt_avert_accents.')</p>';

  /* Affiche le formulaire */
  $equipe = new Equipe($num);
  $equipe->unserialize();
  $equipe->afficher_formulaire();

  echo '<h3>'.$h3_save.'</h3>';

  echo '<p>';
  echo $txt_numero.' <input class="text" type="text" id="Login" name="e" value="'.$num.'" disabled="disabled" /> ';
  echo $txt_passwd.' <input class="text" type="password" id="Pass" name="Pass" /> ';
  echo '<input type="submit" value="'.$txt_btn_enregistrer.'" id="FormLogin" name="FormLogin" />';
  echo '</p>';

  echo '</form>';
}

?>
