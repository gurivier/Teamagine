<?php

function est_numero_valide($num) {
  return (strlen($num) == 3 && IntlChar::isdigit($num[0]) && IntlChar::isdigit($num[1]) && IntlChar::isdigit($num[2]));
}

?>
