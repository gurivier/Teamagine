<?php

e('<h2>'.$h2_concept.'</h2>');

e('<p>'.$lipsum.'</p>');

e('<h2>'.$h2_organisation.'</h2>');

e('<p>'.$lipsum.'</p>');

e('<h2>'.$h2_sponsors.'</h2>');

e('<p>'.$lipsum.'</p>');

e('<h2>'.$h2_inscription.'</h2>');

$inscriptions_objet=array('fr'=>'[INSCRIPTION CC2026E1] NOM Prénom', 'en'=>'[INSCRIPTION CC2026E1] SURNAME Firstname');
$inscriptions_corps=array('fr'=>'Affiliation, Droit à l\'image, Charte de comportement, Régime alimentaire', 'en'=>'Affiliation, Image rights, Code of conduct, Food');

$objet=urlencode($inscriptions_objet[$lang]);
$corps=urlencode($inscriptions_corps[$lang]);

$mailto='mailto:'.$ev->contact.'?subject='.$objet.'&amp;body='.$corps;

e('<p>'.$txt_contact.' <a href="'.$mailto.'">'.$ev->contact.'</a></p>');

e('<h2>'.$h2_localisation.'</h2>');

e('<p>'.$lipsum.'</p>');

?>
 
