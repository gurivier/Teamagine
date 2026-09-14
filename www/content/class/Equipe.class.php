<?php

include_once('Membre.class.php');
include_once('HeureActivite.class.php');
include_once('content/pkg/temps.inc.php'); // $H
include_once('content/pkg/no_accent.inc.php');

class Equipe {

  //-- CONSTRUCTEURS

  public function __construct(string $num) {
    global $ev;
    global $lang;
    
    $this->m_num = $num;

    /* Initialisation des chaines de caracteres */
    $this->m_nom = '';
    $this->m_projet = '';
    $this->m_lieu_etage = '';
    $this->m_lieu_salle = '';
    $this->m_lieu_endroit = '';
    $this->m_commentaire = '';
    
    /* Creation des tableaux */
    $this->m_membres = [];
    $this->m_pauses = array_fill(0, $ev->duree, false);
    $this->m_activites = [];

    /* Initialiser m_activites */
    for ($i = 0 ; $i < $ev->duree ; $i++) {
      $this->ajouter_activite(new HeureActivite());
    }

    /* Initialiser le texte du contenu */
    include('content/class/lang/'.$lang.'/'.$lang.'_Equipe.class.inc.php');
  }

  //-- ACCESSEURS

  public function set_nom(string $nom): void {
    $this->m_nom = $nom;
  }

  public function get_nom(): string {
    return $this->m_nom;
  }

  public function set_projet(string $projet): void {
    $this->m_projet = $projet;
  }

  public function set_commentaire(string $commentaire): void {
    $this->m_commentaire = $commentaire;
  }

  public function set_lieu(string $etage, string $salle, string $endroit): void {
    $this->m_lieu_etage = $etage;
    $this->m_lieu_salle = $salle;
    $this->m_lieu_endroit = $endroit;
  }

  public function set_pause(int $h, bool $en_pause): void {
    $this->m_pauses[$h] = $en_pause;
  }
    
  //-- METHODES

  public function clear_activite(int $h): void {
    $this->m_activites[$h]->clear();
  }

  public function clear_membres(): void {
    unset($this->m_membres);
    $this->m_membres = [];
  }

  public function ajouter_membre(string $nom, string $prenom, string $affiliation): void {
    $membre = new Membre($nom, $prenom, $affiliation);
    $this->m_membres[] = $membre;
  }

  public function ajouter_activite(object $activite): void {
    $this->m_activites[] = $activite;
  }

  protected function generer_js_afficher_colone(int $h): bool {
    $com_etape = $this->m_activites[$h]->get_com_etape();
    $com_quoi = $this->m_activites[$h]->get_com_quoi();
    $com_outils = $this->m_activites[$h]->get_com_outils();
    if ($com_etape != '' || $com_quoi != '' || $com_outils != '') {
      echo 'function afficher_colone_'.$this->m_num.'_'.$h.'() {';
      echo 'document.getElementById(\'ComEtape'.$this->m_num.'\').innerHTML = \'H='.($h+1).' : '.str_replace("'", '\\\'', str_replace('\nl', "<br/>", $com_etape)).'\';';
      echo 'document.getElementById(\'ComQuoi'.$this->m_num.'\').innerHTML = \'H='.($h+1).' : '.str_replace("'", '\\\'', str_replace('\nl', "<br/>", $com_quoi)).'\';';
      echo 'document.getElementById(\'ComOutils'.$this->m_num.'\').innerHTML = \'H='.($h+1).' : '.str_replace("'", '\\\'', str_replace('\nl', "<br/>", $com_outils)).'\';';
      echo '}';
      return true;
    }
    return false;
  }

  protected function generer_js_afficher_colone_vide(): void {
    echo 'function afficher_colone_'.$this->m_num.'_vide() {';
    echo 'document.getElementById(\'ComEtape'.$this->m_num.'\').innerHTML = \'H=\';';
    echo 'document.getElementById(\'ComQuoi'.$this->m_num.'\').innerHTML = \'H=\';';
    echo 'document.getElementById(\'ComOutils'.$this->m_num.'\').innerHTML = \'H=\';';
    echo '}';
  }

  protected function afficher_nom(string $tag): void {
    echo '<'.$tag.'><a name="'.$this->m_num.'"> </a>'.$this->m_num.' - '.str_replace('\\\'', "'", $this->m_nom).'</'.$tag.'>';
  }

  protected function afficher_projet(): void {
    echo '<p class="bold"><span class="upper">'.$this->m_txt_projet_.'</span> '.str_replace('\\\'', "'", $this->m_projet).'</p>';
  }
    
  protected function afficher_membres(): void {
    if (isset($this->m_membres) && count($this->m_membres) > 0) {
      echo '<p class="bold upper">'.$this->m_txt_membres_.'</p>';
      echo '<ol class="membres">';
      foreach ($this->m_membres as $key => $membre) {
        echo '<li>';
        $membre->afficher();
        echo '</li>';
      }
      echo '</ol>';
    }
  }

  public function afficher_pour_palmares(string $txt_prix, ?string $img_prix = ''): void {

    /* Afficher le prix */
    echo '<h2>'.$txt_prix.'</h2>';
    
    /* Afficher le nom de l'equipe */
    $this->afficher_nom('h3');

    /* Afficher le prix */
    if ($img_prix != '') {
      echo '<img class="fluxR totem" src="'.$img_prix.'" alt="Award for '.$txt_prix.'" />';
    }
    
    /* Afficher le projet de l'equipe */
    $this->afficher_projet();

    /* Afficher les membres de l'equipe */
    $this->afficher_membres();

    if ($img_prix != '') {
      echo '<br class="flux" />';
    }
  }

  public function afficher(): void {
    global $ev;
    global $H;
    global $lang;
    
    /* Afficher le nom de l'equipe */
    $this->afficher_nom('h2');
    
    if ($H > 0 && $H <= $ev->duree) {
      echo '<p class="fluxR"><a href="equipe_fiche.php?lang='.$lang.'&amp;e='.$this->m_num.'">'.$this->m_txt_modifier_fiche.'</a></p>';
    }
    
    /* Afficher le projet de l'equipe */
    $this->afficher_projet();
    
    /* Afficher le lieu de travail de l'equipe */
    if (isset($_GET['lieu'])) {
      echo '<p><span class="bold">'.$this->m_txt_lieu.'</span> ';
      echo Equipe::$G_txt_lieu[$this->m_lieu_etage];
      if ($this->m_lieu_salle!='') {
        e(' / '.$this->m_txt_salle.' '.str_replace('\\\'', "'", $this->m_lieu_salle));
      }
      if ($this->m_lieu_endroit!='') {
        echo ' / '.str_replace('\\\'', "'", $this->m_lieu_endroit);
      }
      echo '</p>';
    }

    /* Afficher les membres de l'equipe */
    $this->afficher_membres();
    
    /* Generer le js */
    echo '<script type="text/javascript">';
    $com_col = [];
    $generer_col_vide = true;
    for ($h=0 ; $h < $ev->duree ; $h++) {
      if ($this->generer_js_afficher_colone($h)) {
        $com_col[$h] = 'afficher_colone_'.$this->m_num.'_'.$h.'();';
      }
      else {
        if ($generer_col_vide) {
          $this->generer_js_afficher_colone_vide();
          $generer_col_vide = false;
        }
        $com_col[$h] = 'afficher_colone_'.$this->m_num.'_vide();';
      }
    }
    echo '</script>';

    /*-- Afficher le suivi des activites --*/

    /* Trouver le max */
    $max = 0;
    foreach ($this->m_activites as $key => $heure) {
      if ($heure->get_nbr_activite() > $max) {
        $max = $heure->get_nbr_activite();
      }
    }

    /* Afficher le tableau */
    if ($max > 0) {

      echo '<p class="bold">'.$this->m_txt_processus_creativite_.'</p>';

      /* Afficher les activites par ligne decroissante pour toutes les heures H */

      //--
      echo '<div class="plegende"><a class="legende" href="#'.$this->m_num.'">&nbsp; '.$this->m_txt_legende.' &nbsp;<span class="survol">';
      $activite = new HeureActivite();
      $activite->afficher_legende();
      echo '</span></a></div>';
      //--

      $i = $max-1; // la ligne a afficher
      echo '<table class="activite">';
      while ($i >= 0) {
        echo '<tr>';

        /* Premiere cellule */
        echo '<td class="alignR">'.($i+1).'.</td>';

        for ($h = 0 ; $h < $ev->duree ; $h++) {
          if ($this->m_activites[$h]->get_nbr_activite() > $i) {

            // Afficher la case
            $color = $this->m_activites[$h]->get_color($i, false);
            $colorEtape = $this->m_activites[$h]->get_color($i, true);

            $etape = str_replace("'", '\\\'', $this->m_activites[$h]->get_etape($i));
            $quoi = str_replace("'", '\\\'', $this->m_activites[$h]->get_quoi($i));
            $outils = str_replace("'", '\\\'', $this->m_activites[$h]->get_outils($i));
            $personnes = str_replace("'", '\\\'', $this->m_activites[$h]->get_personnes($i));

            if ($etape == '') {
              $etape = '_';
            }

            if ($quoi == '') {
              $quoi = '_';
            }

            if ($outils == '') {
              $outils = '_';
            }
          }
          else { // Case vide
            $color = 'vi'; /* vide */
            $colorEtape = 'black';
            $etape = '_';
            $quoi = '_';
            $outils = '_';
            $personnes = '';
          }
          
          echo '<td class="'.$color.'" onmouseover="HeadEtape'.$this->m_num.'.style.color = \''.$colorEtape.'\'; ActiviteEtape'.$this->m_num.'.innerHTML = \''.$etape.'\'; ActiviteQuoi'.$this->m_num.'.innerHTML = \''.$quoi.'\'; ActiviteOutils'.$this->m_num.'.innerHTML = \''.$outils.'\' ; '.$com_col[$h].'"><a href="#">'.$personnes.'</a></td>';
        }
        echo '</tr>';
        $i--;
      }

      /* Afficher la ligne des heures H */
      echo '<tr>';
      echo '<td> </td>'; // Premiere cellule : vide
      for ($h = 0 ; $h < $ev->duree ; $h++) {
        echo '<td class="bold heuresH '.(($this->m_pauses[$h]) ? 'gray' : '').'">'.($h+1).'</td>';
      }
      echo '</tr>';

      echo '</table>';

      echo '<p>';
      echo $this->m_txt_passer_souris;
      echo '<span class="italic">'.$this->m_txt_les_pauses.'</span> ';
      echo '</p>';

      /* Zones pour afficher les textes des cases */
      echo '<table class="activite_com">';

      echo '<tr>';
      echo '<td class="head1" id="HeadEtape'.$this->m_num.'">'.$this->m_txt_etape.'</td><td class="com1" id="ActiviteEtape'.$this->m_num.'">_</td>';
      echo '<td class="head2">'.$this->m_txt_commentaires.'<br/> &laquo;'.$this->m_txt_etape.'&raquo;</td>';
      echo '<td class="head2">'.$this->m_txt_commentaires.'<br/> &laquo;'.$this->m_txt_sur_quoi.'&raquo;</td>';
      echo '<td class="head2">'.$this->m_txt_commentaires.'<br/> &laquo;'.$this->m_txt_methode.'&raquo;</td>';
      echo '</tr>';

      echo '<tr>';
      echo '<td class="head1">'.$this->m_txt_sur_quoi.' </td><td class="com1" id="ActiviteQuoi'.$this->m_num.'">_</td>';
      echo '<td class="com2" id="ComEtape'.$this->m_num.'" rowspan="2">H=</td>';
      echo '<td class="com2" id="ComQuoi'.$this->m_num.'" rowspan="2">H=</td>';
      echo '<td class="com2" id="ComOutils'.$this->m_num.'" rowspan="2">H=</td>';
      echo '</tr>';

      echo '<tr>';
      echo '<td class="head1">'.$this->m_txt_methode.' </td><td class="com1" id="ActiviteOutils'.$this->m_num.'">_</td>';
      echo '</tr>';

      echo '</table>';

      /* Generer le js */
      echo '<script type="text/javascript">';
      echo 'var HeadEtape'.$this->m_num.' = document.getElementById(\'HeadEtape'.$this->m_num.'\');';
      echo 'var ActiviteEtape'.$this->m_num.' = document.getElementById(\'ActiviteEtape'.$this->m_num.'\');';
      echo 'var ActiviteQuoi'.$this->m_num.' = document.getElementById(\'ActiviteQuoi'.$this->m_num.'\');';
      echo 'var ActiviteOutils'.$this->m_num.' = document.getElementById(\'ActiviteOutils'.$this->m_num.'\');';
      echo '</script>';
    }

  }

  public function afficher_debrief(): void {
    global $ev;

    /* Afficher le nom de l'equipe */
    echo '<h2><a name="'.$this->m_num.'"> </a>'.$this->m_num.' - '.$this->m_nom.'</h2>';

    /* Afficher le projet de l'equipe */
    echo '<p class="bold">'.$this->m_txt_projet_.' '.$this->m_projet.'</p>';

    /*-- Afficher le suivi des activites --*/

    /* Trouver le max */
    $max = 0;
    foreach ($this->m_activites as $key => $heure) {
      if ($heure->get_nbr_activite() > $max)
        $max = $heure->get_nbr_activite();
    }

    /* Afficher le tableau */
    if ($max > 0) {

      /* Afficher les activites par ligne decroissante pour toutes les heures H */

      //--
      echo '<div class="plegende"><a class="legende" href="#'.$this->m_num.'">&nbsp; '.$this->m_txt_legende.' &nbsp;<span class="survol">';
      $activite = new HeureActivite();
      $activite->afficher_legende();
      echo '</span></a></div>';
      //--

      $i = $max-1; // la ligne a afficher
      echo '<table class="activite">';
      while ($i >= 0) {
        echo '<tr>';

        /* Premiere cellule */
        echo '<td class="alignR">'.($i+1).'.</td>';

        for ($h = 0 ; $h < $ev->duree ; $h++) {
          if ($this->m_activites[$h]->get_nbr_activite() > $i) {
            // Afficher la case
            $color = $this->m_activites[$h]->get_color($i, false);
            $personnes = str_replace("'", '\\\'', $this->m_activites[$h]->get_personnes($i));
          }
          else {
            // Case vide
            $color = 'vi'; /* vide */
            $personnes = '';
          }
          
          echo '<td class="'.$color.'"><a href="#">'.$personnes.'</a></td>';
        }
        echo '</tr>';
        $i--;
      }

      /* Afficher la ligne des heures H */
      echo '<tr>';
      echo '<td> </td>'; // Premiere cellule : vide
      for ($h = 0 ; $h < $ev->duree ; $h++) {
        echo '<td class="bold heuresH '.(($this->m_pauses[$h]) ? 'gray' : '').'">'.($h+1).'</td>';
      }
      echo '</tr>';

      echo '</table>';
    }

    /* Afficher les heures de maniere exhaustive */

    echo '<br/>';

    echo '<table class="debrief">';
    echo '<tr><th class="coin">'.$this->m_num.'</th><th colspan="2">&laquo;'.$this->m_txt_etape.'&raquo;</th><th>&laquo;'.$this->m_txt_sur_quoi.'&raquo;</th><th>&laquo;'.$this->m_txt_methode.'&raquo;</th><th>'.$this->m_txt_nbrpers.'</th></tr>';

    for ($h = 0 ; $h < $ev->duree ; $h++) {

      /* Commentaire de l'heure $h */
      $com_etape = str_replace('\nl', "<br/>", $this->m_activites[$h]->get_com_etape()); 
      $com_quoi = str_replace('\nl', "<br/>", $this->m_activites[$h]->get_com_quoi());
      $com_outils = str_replace('\nl', "<br/>", html_entity_decode($this->m_activites[$h]->get_com_outils()));
      echo '<tr class="H"><td class="bold center">H = '.($h+1).'</td><td class="italic" colspan="2">'.$com_etape.'</td><td class="italic">'.$com_quoi.'</td><td class="italic">'.$com_outils.'</td><td>-</td></tr>';

      /* Commentaires des activites */

      for ($i=0 ; $i < $this->m_activites[$h]->get_nbr_activite() ; $i++) {
        $colorEtape = $this->m_activites[$h]->get_color($i, true);
        $etape = $this->m_activites[$h]->get_etape($i);
        $quoi = $this->m_activites[$h]->get_quoi($i);
        $outils = $this->m_activites[$h]->get_outils($i);
        $personnes = str_replace("'", '\\\'', $this->m_activites[$h]->get_personnes($i));

        echo '<tr><td class="center">'.($i+1).'.</td><td style="background-color:'.$colorEtape.'; width: 15px;"><br/></td><td>'.$etape.'</td><td>'.$quoi.'</td><td>'.$outils.'</td><td>'.$personnes.'</td></tr>';
      }
    }
    echo '</table>';
  }

  public function afficher_formulaire(): void {
    global $ev;
    global $H;
      
    echo '<h3>'.$this->m_txt_projet.'</h3>';

    /* Nom de l'equipe */
    echo '<p><span class="bold">'.$this->m_txt_nom_equipe.'</span> <input class="text" type="text" id="EquipeNom" name="EquipeNom" value="'.html_entity_decode(str_replace('\\\'', "'", $this->m_nom)).'" /></p>';

    /* Projet de l'equipe */
    echo '<p><span class="bold">'.$this->m_txt_titre_projet.' </span><input class="text_large" type="text" id="EquipeProjet" name="EquipeProjet" value="'.html_entity_decode(str_replace('\\\'', "'", $this->m_projet)).'" /></p>';

    /* Commentaire de l'equipe */
    echo '<p>'.$this->m_txt_commentaire.'</p>';
    echo '<p><textarea class="textarea" id="EquipeCommentaire" name="EquipeCommentaire" cols="20" rows="4">'.str_replace('\nl', "\r\n", html_entity_decode($this->m_commentaire)).'</textarea></p>';

    /* Lieu de travail de l'equipe */
    echo '<p><span class="bold">'.$this->m_txt_lieu.' </span></p>';
    echo '<table>';
    echo '<tr><td>'.$this->m_txt_etage.'</td><td>'.str_replace('\\\'', "'", $this->m_txt_salle).'</td><td>'.str_replace('\\\'', "'", $this->m_txt_endroit).'</td></tr>';
    echo '<tr>';
    echo '<td><select id="EquipeLieu_etage" name="EquipeLieu_etage" />';
    echo '<option value="0" '.(($this->m_lieu_etage==0)?'selected="selected"':'').'>'.Equipe::$G_txt_lieu[0].'</option>';
    echo '<option value="1" '.(($this->m_lieu_etage==1)?'selected="selected"':'').'>'.Equipe::$G_txt_lieu[1].'</option>';
    echo '<option value="2" '.(($this->m_lieu_etage==2)?'selected="selected"':'').'>'.Equipe::$G_txt_lieu[2].'</option>';
    echo '</select></td>';
    echo '<td><input class="text_small" type="text" id="EquipeLieu_salle" name="EquipeLieu_salle" value="'.html_entity_decode($this->m_lieu_salle).'" /></td>';
    echo '<td><input class="text_large" type="text" id="EquipeLieu_endroit" name="EquipeLieu_endroit" value="'.html_entity_decode($this->m_lieu_endroit).'" /></td>';
    echo '</tr>';
    echo '</table>';
    echo '<p class="center"><span class="italic">('.$this->m_txt_lieu_rmq.')</span></p>';

    echo '<h3>'.$this->m_txt_membres.'</h3>';

    /* Membres de l'equipe */
    echo '<table>';
    echo '<tr><td> </td><td>'.$this->m_txt_prenom.'</td><td>'.$this->m_txt_nom.'</td><td>'.$this->m_txt_affiliation.'</td></tr>';
    $i = 0;
    foreach ($this->m_membres as $key => $membre) {
      $membre->afficher_formulaire($i);
      $i++;
    }
    while ($i < $ev->max_membres) {
      membre_afficher_formulaire($i);
      $i++;
    }
    echo '</table>';

    echo '<h3>'.$this->m_txt_processus_creativite.'</h3>';
    
    /* Affichage de l'heure */
    echo '<p>'.heure().'</p>';

    /* Pauses */
    echo '<p class="bold center">'.$this->m_txt_pauses.'</p>';
    echo '<table class="pauses">';
    echo '<tr>';
    for ($h = 0 ; $h < $ev->duree ; $h++) {
      if ($h % 12 == 0) {
          echo '</tr><tr>';
      }
      echo '<td><label id="lb_pause'.$h.'" for="EQ_pause'.$h.'">'; 
      echo '<input type="checkbox" id="EQ_pause'.$h.'" name ="EQ_pause['.$h.']" value="1" '.(($this->m_pauses[$h]) ? 'checked="checked"' : '').' /><br/>';
      chrono_afficher_alpha($h+1);
      echo '</label></td>';
    }
    echo '</tr>';
    echo '</table>';

    /* Suivi des activites */
    $h = $H-1;
    if ($H > 0 && $H <= $ev->duree) {
      if ($H < $ev->duree) {
        chrono_afficher($H, 'rouge');
        $this->m_activites[$h]->afficher_formulaire($h, 'rouge');
        echo '<p><input type="hidden" name="h" value="'.$h.'" /></p>';
      }
      if ($H > 1) {
        chrono_afficher($H-1, 'gris');
        $this->m_activites[$h-1]->afficher_formulaire($h-1, 'gris');
        echo '<p><input type="hidden" name="h_1" value="'.($h-1).'" /></p>';
      }
      if ($H > 2) {
        chrono_afficher($H-2, 'gris');
        $this->m_activites[$h-2]->afficher_formulaire($h-2, 'gris');
        echo '<p><input type="hidden" name="h_2" value="'.($h-2).'" /></p>';
      }
    }
  }

  public function enregistrer_formulaire(int $h): void {
    $this->clear_activite($h);
    $this->m_activites[$h]->enregistrer_formulaire($h);
  }

  public function serialize(): void {
    global $ev;
      
    /* Ouverture d'un descripteur en lecture seule */
    $desc = fopen(Equipe::$G_PATH.$this->m_num.'.txt', 'w');

    if (!$desc) {
      die('Erreur ouverture fichier '.$this->m_num.'.txt en ecriture');
    }

    /* Nom de l'equipe */
    fputs($desc, 'NOM>'.$this->m_nom.'>'."\r\n");

    /* Projet de l'equipe */
    fputs($desc, 'PROJET>'.$this->m_projet.'>'."\r\n");

    /* Commentaire de l'equipe */
    fputs($desc, 'COMMENTAIRE>'.$this->m_commentaire.'>'."\r\n");

    /* Lieu de travail de l'equipe */
    fputs($desc, 'LIEU>'.$this->m_lieu_etage.'>'.$this->m_lieu_salle.'>'.$this->m_lieu_endroit.'>'."\r\n");

    /* Nombre de membres */
    fputs($desc, 'NOMBRE>'.count($this->m_membres).'>'."\r\n");

    /* Membres de l'equipe */
    foreach ($this->m_membres as $key => $membre)
      $membre->serialize($desc);

    /* Pauses */
    for ($h = 0 ; $h < $ev->duree ; $h++) {
      fputs($desc, ($this->m_pauses[$h]) ? '1>' : '0>');
    }
    fputs($desc, "\r\n");

    /* Suivi des activites */
    for ($h = 0 ; $h < $ev->duree ; $h++) {
      $this->m_activites[$h]->serialize($h+1, $desc);
    }

    /* Fermeture du descripteur */
    fclose($desc);
  }

  public function unserialize(): void {
    global $ev;

    $file = Equipe::$G_PATH.$this->m_num.'.txt';
    
    if (file_exists($file)) {

      /* Ouverture d'un descripteur en lecture seule */
      $desc = fopen($file, 'r');

      if (!$desc) {
        die('Erreur ouverture fichier '.$this->m_num.'.txt en lecture');
      }

      /* Nom de l'equipe */
      $tab = explode(">", fgets($desc)); // Lire une ligne et la decomposer dans un tableau
      $this->m_nom = $tab[1];

      /* Projet de l'equipe */
      $tab = explode(">", fgets($desc)); // Lire une ligne et la decomposer dans un tableau
      $this->m_projet = $tab[1];

      /* Commentaire de l'equipe */
      $tab = explode(">", fgets($desc)); // Lire une ligne et la decomposer dans un tableau
      $this->m_commentaire = $tab[1];

      /* Lieu de travail de l'equipe */
      $tab = explode(">", fgets($desc)); // Lire une ligne et la decomposer dans un tableau
      $this->m_lieu_etage = $tab[1];
      $this->m_lieu_salle = $tab[2];
      $this->m_lieu_endroit = $tab[3];

      /* Nombre de membres */
      $tab = explode(">", fgets($desc)); // Lire une ligne et la decomposer dans un tableau
      $nbr = $tab[1];

      /* Membres de l'equipe */
      for ($i = 0 ; $i < $nbr ; $i++) {
        $membre = new Membre();
        $membre->unserialize($desc);
        $this->m_membres[] = $membre;
      }

      /* Pauses */
      $tab = explode(">", fgets($desc)); // Lire une ligne et la decomposer dans un tableau
      for ($i = 0 ; $i < $ev->duree ; $i++){
        $this->m_pauses[$i] = (!isset($tab[$i])) ? false : ($tab[$i] == '1'); 
      }
      
      /* Suivi des activites */
      if (!feof($desc)) {
        if (($line = fgets($desc)) != '') {
          $tab = explode(">", $line);
          $H = $tab[0];
        }
      }
      while (!feof($desc)) {
        $this->m_activites[$H-1]->unserialize_com_etape($desc);
        $this->m_activites[$H-1]->unserialize_com_quoi($desc);
        $this->m_activites[$H-1]->unserialize_com_outils($desc);

        $H_read = $H;
        while ($H_read == $H) {
          $H_read = $this->m_activites[$H-1]->unserialize_activite($H, $desc);
        }
        $H = $H_read;
      }

      /* Fermeture du descripteur */
      fclose($desc);
    }
  }
    
  //-- MEMBRES

  private string $m_num;
  private string $m_nom;
  private string $m_projet;
  private string $m_lieu_etage;
  private string $m_lieu_salle;
  private string $m_lieu_endroit;
  private string $m_commentaire;
  private array $m_membres;    // Membre[]
  private array $m_pauses;     // boolean[]
  private array $m_activites;  // HeureActivite[]

  /* Texte du contenu */
  private string $m_txt_modifier_fiche;
  /*--*/
  private string $m_txt_projet_;
  private string $m_txt_membres_;
  private string $m_txt_processus_creativite_;
  private string $m_txt_legende;
  private string $m_txt_passer_souris;
  private string $m_txt_les_pauses;
  private string $m_txt_commentaires;
  private string $m_txt_etape;
  private string $m_txt_sur_quoi;
  private string $m_txt_methode;
  private string $m_txt_nbrpers;
  /*--*/
  private string $m_txt_projet;
  private string $m_txt_nom_equipe;
  private string $m_txt_titre_projet;
  private string $m_txt_lieu;
  private string $m_txt_lieu_rmq;
  private string $m_txt_etage;
  private string $m_txt_salle;
  private string $m_txt_endroit;
  private string $m_txt_commentaire;
  private string $m_txt_membres;
  private string $m_txt_nom;
  private string $m_txt_prenom;
  private string $m_txt_affiliation;
  private string $m_txt_processus_creativite;
  private string $m_txt_pauses;

  //-- MEMBRES private

  private static string $G_PATH = 'data/equipes/';
  public static array $G_txt_lieu;
}

include('content/class/lang/'.$lang.'/'.$lang.'_Equipe.static.class.inc.php');

?>
