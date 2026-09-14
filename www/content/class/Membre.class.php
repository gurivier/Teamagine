<?php

class Membre {

  //-- CONSTRUCTEURS

  public function __construct(?string $nom = '', ?string $prenom = '', ?string $affiliation = '') {
    $this->m_nom = $nom;
    $this->m_prenom = $prenom;
    $this->m_affiliation = $affiliation;
  }

  //-- METHODES

  public function afficher():void {
    echo str_replace('\\\'', "'", $this->m_prenom).' '.str_replace('\\\'', "'", $this->m_nom);
    if ($this->m_affiliation != '') {
      echo ' <span class="italic">('.str_replace('\\\'', "'", $this->m_affiliation).')</span> ';
    }
  }

  public function afficher_formulaire(int $i): void {
    membre_afficher_formulaire($i, str_replace('\\\'', "'", $this->m_nom), str_replace('\\\'', "'", $this->m_prenom), str_replace('\\\'', "'",$this->m_affiliation));
  }

  public function serialize($desc): void {
    fputs($desc, 'MEMBRE>'.$this->m_nom.'>'.$this->m_prenom.'>'.$this->m_affiliation.'>'."\r\n");    
  }

  public function unserialize($desc): void {
    $tab = explode(">", fgets($desc)); // Lire une ligne et la decomposer dans un tableau
    $this->m_nom = $tab[1];
    $this->m_prenom = $tab[2];
    $this->m_affiliation = $tab[3];
  }

  //-- MEMBRES

  private string $m_nom;
  private string $m_prenom;
  private string $m_affiliation;
}

//-- FONCTIONS amies

function membre_afficher_formulaire(int $i, ?string $nom = '', ?string $prenom = '', ?string $affiliation = ''): void {
  echo '<tr>';
  echo '<td class="alignR">'.($i+1).'.</td>';
  echo '<td><input class="text_medium" type="text" id="EquipeMembre'.$i.'_prenom" name="EquipeMembre_prenom['.$i.']" value="'.html_entity_decode($prenom).'" /></td>';
  echo '<td><input class="text_medium" type="text" id="EquipeMembre'.$i.'_nom" name="EquipeMembre_nom['.$i.']" value="'.html_entity_decode($nom).'" /></td>';
  echo '<td><input class="text_medium" type="text" id="EquipeMembre'.$i.'_affiliation" name="EquipeMembre_affiliation['.$i.']" value="'.html_entity_decode($affiliation).'" /></td>';
  echo '</tr>';
}

?>
