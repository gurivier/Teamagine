<?php

//== CLASSE

class Evenement {

  // Execution
  public $montrer_erreurs_php=true;

  // Theme
  public $couleur='rouge'; // bleu rose rouge sarcelle vert
    
  // Membres des equipes
  public $max_membres=10;
  
  // Date
  public $depart_A='2026';
  public $depart_M='12';
  public $depart_J='03';

  // Horaire
  public $depart_h='14';
  public $depart_m='00';

  // Heures
  public $duree=120;

  // Informations
  public $nom=array('fr'=>'Concours Créatif', 'en'=>'Creative Contest');
  public $info1=array('fr'=>'Jeudi 3 décembre 14h ---- Mardi 8 décembre 14h', 'en'=>'Thursday December 3, 2PM ---- Tuesday December 8, 2PM');
  public $info2=array('fr'=>'Bidart – France', 'en'=>'Bidart – France');
  public $info3=array('fr'=>'www.creativity.eu', 'en'=>'www.creativity.eu');
  public $info4=array('fr'=>'', 'en'=>'');

  // Adresses
  public $url='https://www.creativity.eu';
  public $contact='contact@creativity.eu';

  // Reseaux sociaux
  public $youtube='http://www.youtube.com/user/CreativityContest';
  public $twitter='http://twitter.com/CreativityContest';
  public $facebook='http://www.facebook.com/group.php?gid=123456789012#/group.php?gid=12345678900';
    
  /**
   * Retourne l'heure de depart du concours.
   */
  public function temps_depart() {
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

$ev=new Evenement();

?>
