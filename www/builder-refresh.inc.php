<?php

include_once('config/Evenement.class.php'); // $ev

include_once('content/pkg/temps.inc.php'); // $H

$regenerer=0;

if($H >= $ev->H_ouvrir_equipes && $H <= 2){
  $t_last_clean=filemtime('builder/runtime/last_refresh');
  $t_actualisation=$ev->temps_depart()+($ev->H_ouvrir_equipes*3600);
  if($t_last_clean < $t_actualisation){
      $regenerer=1;
  }
}

if($regenerer){
  include('builder/builder.inc.php');
  clean_cache_files();
  touch('builder/runtime/last_refresh');
}

?>
