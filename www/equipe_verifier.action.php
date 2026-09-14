<?php

include_once('config/Evenement.class.php'); // $ev

include_once('pkg/erreurs.inc.php');

$lang=(!isset($_GET['lang']) || !($_GET['lang']=='fr' || $_GET['lang']=='en')) ? 'fr' : $_GET['lang'];

include_once('pkg/verif.inc.php');
include_once('auth/auth.inc.php');

/* Numero de l'equipe */

if (isset($_GET['e']) && est_numero_valide($_GET['e'])) {
  $num = $_GET['e'];
}
elseif (isset($_POST['e']) && est_numero_valide($_POST['e'])) {
  $num = $_POST['e'];
}
else {
  $num = null;
}

/* Verification du login et du mot de passe */

if ($num == null || $_POST['Pass'] == '' || $_POST['Pass'] != getPasswd($num)) {
  header('location: equipe_activer.php?lang='.$lang.'&mess=err');
}
else {
  header('location: equipe_fiche.php?lang='.$lang.'&e='.$num);
}

?>
