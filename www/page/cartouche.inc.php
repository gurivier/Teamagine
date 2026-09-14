
<div id="basdepage">
<?php
$t1=filemtime($i18n); $t2=getlastmod();
echo '<i>Last updated:</i> '.date( "F d, Y", ($t1>$t2)?$t1:$t2).' -  <i>Contact:</i> '.$ev->contact.' - <i>URL:</i> <a href="'.$ev->url.'">'.$ev->url.'</a><br/>';
echo '<br/>';
echo '<a href="http://validator.w3.org/check?uri=referer"><img class="logoW3C" src="page/img/w3c/valid-xhtml10" alt="Valid XHTML 1.0 Strict" /></a>';
echo '<a href="http://jigsaw.w3.org/css-validator/check/referer"><img class="logoW3C" src="page/img/w3c/vcss" alt="Valid CSS!" /></a>';
?>
</div>
