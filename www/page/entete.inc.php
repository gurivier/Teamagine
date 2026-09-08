<?php

//-- Drapeaux
echo '<div style="width: 150px;" class="hautdepage fluxL">';
$scriptfilename=substr(getenv('SCRIPT_NAME'),strrpos(getenv('SCRIPT_NAME'),'/')+1);
echo '<a href="'.$scriptfilename.'?lang=fr"><img class="drapeau'.(($lang=='fr')?'-sel':'').'" src="page/img/francais.gif" alt="fran&ccedil;ais" title="En fran&ccedil;ais" /></a>&nbsp;';
echo '<a href="'.$scriptfilename.'?lang=en"><img class="drapeau'.(($lang=='en')?'-sel':'').'" src="page/img/anglais.gif" alt="anglais" title="In english" /></a>';
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
echo '<a href="'.$ev->facebook.'"><img src="page/img/fb.png" alt="facebook" title="Facebook" /></a>&nbsp;';
echo '<a href="'.$ev->twitter.'"><img src="page/img/tw.png" alt="twitter" title="Twitter" /></a>&nbsp;';
echo '<a href="'.$ev->youtube.'"><img src="page/img/yt.png" alt="youtube" title="YouTube" /></a>';
echo '</div>'."\r\n";

//-- Banniere
echo '<div id="entete" class="flux">';

echo '<img id="pavillon" src="page/img/banner2026_'.$lang.'.png?v=202605" alt="'.$alt_event.'" />';

echo '<p>';
echo $ev->info1[$lang];
if (isset($ev->info2[$lang]) && $ev->info2[$lang] != '') {
  echo '<br/>'.$ev->info2[$lang];
}
if (isset($ev->info3[$lang]) && $ev->info3[$lang] != '') {
  echo '<br/>'.$ev->info3[$lang];
}
if (isset($ev->info4[$lang]) && $ev->info4[$lang] != '') {
  echo '<br/>'.$ev->info4[$lang];
}
echo '</p>';

echo '<h1 class="invisible">'.$title_event.'</h1>';
echo '<p class="invisible"><span class="bold">'.$txt_event.'</p>';
echo '</div>'."\r\n";

?>
