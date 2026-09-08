<?php

function no_accent($str_accent) {
  $pattern = array("/é/", "/è/", "/ê/", "/ç/", "/à/", "/â/", "/î/", "/ï/", "/ù/", "/ô/");
  $rep_pat = array("e", "e", "e", "c", "a", "a", "i", "i", "u", "o");
  $str_noacc = preg_replace($pattern, $rep_pat, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $str_accent));
  return $str_noacc;
}

?>
