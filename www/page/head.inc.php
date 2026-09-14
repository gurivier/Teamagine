<?php
echo '<?xml version="1.0" encoding="iso-8859-1"?>';
$lang=(!isset($_GET['lang']) || !($_GET['lang']=='fr' || $_GET['lang']=='en')) ? 'fr' : $_GET['lang'];
include('page/lang/'.$lang.'/'.$lang.'_page.inc.php');

$page_equipes = isset($page_equipes) && $page_equipes;
$page_saisons = isset($page_saisons) && $page_saisons;
$page_concept = isset($page_concept) && $page_concept;
$page_debrief = isset($page_debrief) && $page_debrief;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo $lang; ?>" xml:lang="<?php echo $lang; ?>">
<head>
 <meta http-equiv="Content-type" content="application/xhtml+xml; charset=ISO-8859-1" />
<?php

echo '<link rel="icon" type="image/png" href="page/img/ico_32x32-'.$ev->couleur.'.png" />';

echo '<link href="page/style/skin.css?v=131010" rel="stylesheet" type="text/css" media="screen" title="screen1" />';

if ($ev->couleur != 'rouge'){
  echo '<link href="page/style/skin-'.$ev->couleur.'.css?v=120926" rel="stylesheet" type="text/css" media="screen" title="screen1" />';
}

if ($msie=preg_match("/msie/", strtolower(getenv('HTTP_USER_AGENT')))) {
  echo '<link href="page/style/msie.css?v=170910" rel="stylesheet" type="text/css" media="screen" title="screen1" />';
}

echo '<link href="page/style/print.css" rel="stylesheet" type="text/css" media="print" />';

if ($page_equipes) {
 echo '<link href="page/style/equipes.css?v3" rel="stylesheet" type="text/css" title="screen1" />';
 if ($ev->couleur != 'rouge'){
  echo '<link href="page/style/equipes-'.$ev->couleur.'.css?v3" rel="stylesheet" type="text/css" title="screen1" />';
 }
}

if ($page_debrief) {
 echo '<link href="page/style/equipes.css" rel="stylesheet" type="text/css" title="screen1" />';
 echo '<link href="page/style/debrief.css" rel="stylesheet" type="text/css" title="screen1" />';
}

echo '<title>'.$titre_page.'</title>';
?>

<script type="text/javascript">
<!--
function open_ext_link(){
 var liens = document.getElementsByTagName('a');
 for (var i=0; i<liens.length; ++i){
  if (liens[i].className == 'lien_ext'){
   liens[i].title = '<?php echo $link_title; ?>';
   liens[i].onclick = function(){window.open(this.href);return false;};
  }
 }
}
window.onload=open_ext_link;
-->
</script>

<?php

//-- Resize
echo '<script type="text/javascript" src="page/script/resize_menu.js?v=20101027"></script>';

if ($page_concept) {
 echo '<script type="text/javascript" src="page/script/resize_sponsors.js?v=20101027"></script>';
}

if ($page_saisons) {
 echo '<script type="text/javascript" src="page/script/unhide.js"></script>';
}

?>
</head>
