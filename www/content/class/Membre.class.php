<?php

class Membre {

  //-- CONSTRUCTEURS

  public function __construct($nom = '', $prenom = '', $affiliation = '') {
    $this->m_nom = $nom;
    $this->m_prenom = $prenom;
    $this->m_affiliation = $affiliation;
  }

  //-- METHODES

  public function afficher() {
    e(str_replace('\\\'', "'", $this->m_prenom).' '.str_replace('\\\'', "'", $this->m_nom));
    if ($this->m_affiliation != '') {
      e(' <span class="italic">('.str_replace('\\\'', "'", $this->m_affiliation).')</span> ');
    }
  }

  public function afficher_formulaire($i) {
    membre_afficher_formulaire($i, str_replace('\\\'', "'", $this->m_nom), str_replace('\\\'', "'", $this->m_prenom), str_replace('\\\'', "'",$this->m_affiliation));
  }

  public function serialize($desc) {
    fputs($desc, 'MEMBRE>'.$this->m_nom.'>'.$this->m_prenom.'>'.$this->m_affiliation.'>'."\r\n");    
  }

  public function unserialize($desc) {
    $tab = explode(">", fgets($desc)); // Lire une ligne et la decomposer dans un tableau
    $this->m_nom = $tab[1];
    $this->m_prenom = $tab[2];
    $this->m_affiliation = $tab[3];
  }

  //-- MEMBRES

  private $m_nom;           // string
  private $m_prenom;        // string
  private $m_affiliation;   // string
}

//-- FONCTIONS amies

function membre_afficher_formulaire($i, $nom = '', $prenom = '', $affiliation = '') {
  e('<tr>');
  e('<td class="alignR">'.($i+1).'.</td>');
  e('<td><input class="text_medium" type="text" id="EquipeMembre'.$i.'_prenom" name="EquipeMembre_prenom['.$i.']" value="'.html_entity_decode($prenom).'" /></td>');
  e('<td><input class="text_medium" type="text" id="EquipeMembre'.$i.'_nom" name="EquipeMembre_nom['.$i.']" value="'.html_entity_decode($nom).'" /></td>');
  e('<td><input class="text_medium" type="text" id="EquipeMembre'.$i.'_affiliation" name="EquipeMembre_affiliation['.$i.']" value="'.html_entity_decode($affiliation).'" /></td>');
  e('</tr>');
}


?>
