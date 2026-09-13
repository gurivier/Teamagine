<?php

//-- Drapeaux
e('<div style="width: 166px;" class="hautdepage fluxL">');
$scriptfilename=substr(getenv('SCRIPT_NAME'),strrpos(getenv('SCRIPT_NAME'),'/')+1);
e('<a href="'.$scriptfilename.'?lang=fr"><img class="drapeau'.(($lang=='fr')?'-sel':'').'" src="page/img/francais.gif" alt="fran&ccedil;ais" title="En fran&ccedil;ais" /></a>&nbsp;');
e('<a href="'.$scriptfilename.'?lang=en"><img class="drapeau'.(($lang=='en')?'-sel':'').'" src="page/img/anglais.gif" alt="anglais" title="In english" /></a>');
e('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
e('<a href="'.$ev->facebook.'"><img src="page/img/fb.png" alt="facebook" title="Facebook" /></a>&nbsp;');
e('<a href="'.$ev->twitter.'"><img src="page/img/tw.png" alt="twitter" title="Twitter" /></a>&nbsp;');
e('<a href="'.$ev->youtube.'"><img src="page/img/yt.png" alt="youtube" title="YouTube" /></a>');
e('</div>');

//-- Banniere
e('<div id="entete" class="flux">');

e('<img id="pavillon" src="page/img/banniere2026-'.$ev->couleur.'_'.$lang.'.png?v=202605" alt="'.$alt_event.'" />');

e('<p>');
e($ev->info1[$lang]);
if (isset($ev->info2[$lang]) && $ev->info2[$lang] != '') {
  e('<br/>'.$ev->info2[$lang]);
}
if (isset($ev->info3[$lang]) && $ev->info3[$lang] != '') {
  e('<br/>'.$ev->info3[$lang]);
}
if (isset($ev->info4[$lang]) && $ev->info4[$lang] != '') {
  e('<br/>'.$ev->info4[$lang]);
}
e('</p>');

e('<h1 class="invisible">'.$title_event.'</h1>');
e('<p class="invisible"><span class="bold">'.$txt_event.'</p>');
e('</div>');

?>
