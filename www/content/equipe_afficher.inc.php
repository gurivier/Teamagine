<?php

$num = $_GET['e'] ?? null;

if ($num != null) {
  include('class/Equipe.class.php');
  
  $equipe = new Equipe($num);
  $equipe->unserialize();
  $equipe->afficher();
}

?>
