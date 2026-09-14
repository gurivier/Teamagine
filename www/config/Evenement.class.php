<?php

//== CLASSE

class Evenement {

  // Execution
  public bool $montrer_erreurs_php=true;

  // Theme
  public string $couleur='rouge'; // bleu rose rouge sarcelle vert
    
  // Membres des equipes
  public int $max_membres=10;
  
  // Date
  public string $depart_A='2026';
  public string $depart_M='12';
  public string $depart_J='03';

  // Horaire
  public string $depart_h='14';
  public string $depart_m='00';

  // Heures
  public $duree=120;

  // Informations
  public array $nom=['fr'=>'Concours Créatif', 'en'=>'Creative Contest'];
  public array $info1=['fr'=>'Jeudi 3 décembre 14h ---- Mardi 8 décembre 14h', 'en'=>'Thursday December 3, 2PM ---- Tuesday December 8, 2PM'];
  public array $info2=['fr'=>'Bidart – France', 'en'=>'Bidart – France'];
  public array $info3=['fr'=>'www.creativity.eu', 'en'=>'www.creativity.eu'];
  public array $info4=['fr'=>'', 'en'=>''];

  // Adresses
  public string $url='https://www.creativity.eu';
  public string $contact='contact@creativity.eu';

  // Reseaux sociaux
  public string $youtube='http://www.youtube.com/user/CreativityContest';
  public string $twitter='http://twitter.com/CreativityContest';
  public string $facebook='http://www.facebook.com/group.php?gid=123456789012#/group.php?gid=12345678900';
    
  /**
   * Retourne l'heure de depart du concours.
   */
  public function temps_depart(): string {
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
