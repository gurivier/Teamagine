<?php

function getPasswd(string $login): string {
  if ($fid = fopen('auth/r4opz5j3ko/codes.txt', 'r')) {
    while (!feof($fid)){
      $ligne_courante = fgets($fid, 80);
      $tab = explode(';',$ligne_courante);
      if (!strcmp($tab[0],$login)){
        fclose($fid);
        return $tab[1];
      }
    }
    fclose($fid);
    return '';
  } else {
    die('Le fichier de mots de passe est introuvable.');
  }
}

?>
