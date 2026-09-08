<?php

//== CLASSE

class Evenement {
    
  // Team members
  var $max_membres = 10;
  
  // Date
  var $depart_A = '2026';
  var $depart_M = '12';
  var $depart_J = '03';

  // Time
  var $depart_h = '14';
  var $depart_m = '00';

  // Heures
  var $duree = 120;

  var $nom = array('fr' => 'Concours Créatif', 'en' => 'Creative Contest');
  var $url = 'https://www.creativity.eu';
  var $contact = 'contact@creativity.eu';
  var $info1 = array('fr' => 'Jeudi 3 décembre 14h ---- Mardi 8 décembre 14h', 'en' => 'Thursday December 3, 2PM ---- Tuesday December 8, 2PM');
  var $info2 = array('fr' => 'Bidart – France', 'en' => 'Bidart – France');
  var $info3 = array('fr' => 'www.creativity.eu', 'en' => 'www.creativity.eu');
  var $info4 = array('fr' => '', 'en' => '');
  var $youtube = 'http://www.youtube.com/user/CreativityContest';
  var $twitter = 'http://twitter.com/CreativityContest';
  var $facebook = 'http://www.facebook.com/group.php?gid=123456789012#/group.php?gid=12345678900';
  
  /**
   * Retourne l'heure de depart du concours.
   */
  function temps_depart() {
    return mktime(
      $this->depart_h,   // Heures
      $this->depart_m,   // Minutes
      0,                 // Secondes
      $this->depart_M,   // Mois
      $this->depart_J,   // Jour
      $this->depart_A    // Annee
    );
  }
}

//== GLOBALES

$ev = new Evenement();

$montrer_erreurs_php = true;

?>
