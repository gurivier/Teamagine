<?php
function e($s){echo $s."\n";}

include_once('config/Evenement.class.php'); // $ev

include_once('pkg/erreurs.inc.php');

$lang=(!isset($_GET['lang']) || !($_GET['lang']=='fr' || $_GET['lang']=='en')) ? 'fr' : $_GET['lang'];

include_once('config/Evenement.class.php'); // $ev

include_once('auth/auth.inc.php');
include_once('pkg/verif.inc.php');
include_once('content/pkg/temps.inc.php'); // $H
include_once('content/pkg/no_accent.inc.php');

$num = $_GET['e'] ?? null;
$Pass = $_POST['Pass'] ?? '';

/* Verification du login et du mot de passe */

if ($num == null || !est_numero_valide($num) || $Pass == '' || $Pass != getPasswd($num) || !($H > 0 && $H <= 25)) {

  /*-- Message d'erreur --*/

  header('location: equipe_enregistrer.php?lang='.$lang.'&e='.$num.'&m=err');
}
else {

  /*-- Enregistrement de l'equipe --*/

  include_once('content/class/Equipe.class.php');

  $equipe = new Equipe($num);
  $equipe->unserialize();

  /* Nom */
  
  $EquipeNom = $_POST['EquipeNom'] ?? '';
  if ($EquipeNom == '') {
    $EquipeNom = 'NoName_'.$num;
  }
  $EquipeNom = htmlentities(no_accent($EquipeNom));
  
  $equipe->set_nom($EquipeNom);

  /* Titre du projet */

  $EquipeProjet = $_POST['EquipeProjet'] ?? '';
  $EquipeProjet = htmlentities(no_accent($EquipeProjet));
  
  $equipe->set_projet($EquipeProjet);

  /* Commentaire */
    
  $EquipeCommentaire = $_POST['EquipeCommentaire'] ?? '';
  $EquipeCommentaire = htmlentities(no_accent($EquipeCommentaire));
  $EquipeCommentaire = str_replace(array("\r\n", "\n", "\r"), array('\nl', '\nl', '\nl'), $EquipeCommentaire);

  $equipe->set_commentaire($EquipeCommentaire);

  /* Localisation */
  
  $EquipeLieu_etage = $_POST['EquipeLieu_etage'] ?? '';
  $EquipeLieu_etage = htmlentities(no_accent($EquipeLieu_etage));

  $EquipeLieu_salle = $_POST['EquipeLieu_salle'] ?? '';
  $EquipeLieu_salle = htmlentities(no_accent($EquipeLieu_salle));

  $EquipeLieu_endroit = $_POST['EquipeLieu_endroit'] ?? '';
  $EquipeLieu_endroit = htmlentities(no_accent($EquipeLieu_endroit));
  
  $equipe->set_lieu($EquipeLieu_etage, $EquipeLieu_salle, $EquipeLieu_endroit);

  /* Membres */
  
  $equipe->clear_membres();
  
  for ($i = 0 ; $i < $ev->max_membres ; $i++) {
    $EquipeMembre_nom = $_POST['EquipeMembre_nom'][$i] ?? '';
    $EquipeMembre_nom = strtoupper($EquipeMembre_nom);
    $EquipeMembre_nom = htmlentities(no_accent($EquipeMembre_nom));

    $EquipeMembre_prenom = $_POST['EquipeMembre_prenom'][$i] ?? '';
    $EquipeMembre_prenom = htmlentities(no_accent($EquipeMembre_prenom));
    
    $EquipeMembre_affiliation = $_POST['EquipeMembre_affiliation'][$i] ?? '';
    $EquipeMembre_affiliation = htmlentities(no_accent($EquipeMembre_affiliation));
    
    if ($EquipeMembre_nom != '' && $EquipeMembre_prenom != '') {
      $equipe->ajouter_membre($EquipeMembre_nom, $EquipeMembre_prenom, $EquipeMembre_affiliation);
    }
  }

  /* Enregistrement des pauses */
  
  for ($h = 0 ; $h < $ev->duree ; $h++) {
    $EQ_pause = $_POST['EQ_pause'][$h] ?? '0';
    $equipe->set_pause($h, ($EQ_pause == '1'));
  }

  /* Enregistrement des activites */

  if (isset($_POST['h'])) {
    $h = $_POST['h'];
    $equipe->clear_activite($h);
    $equipe->enregistrer_formulaire($h);
  }

  if (isset($_POST['h_1'])) {
    $h = $_POST['h_1'];
    $equipe->clear_activite($h);
    $equipe->enregistrer_formulaire($h);
  }

  if (isset($_POST['h_2'])) {
    $h = $_POST['h_2'];
    $equipe->clear_activite($h);
    $equipe->enregistrer_formulaire($h);
  }

  /* Enregistrement */

  $equipe->serialize();

  /* Afficher */

  header('location: equipe_enregistrer.php?lang='.$lang.'&e='.$num);

}

?>
