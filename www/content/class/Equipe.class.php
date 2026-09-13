<?php

include_once('Membre.class.php');
include_once('HeureActivite.class.php');
include_once('content/pkg/temps.inc.php'); // $H
include_once('content/pkg/no_accent.inc.php');

class Equipe {

  //-- CONSTRUCTEURS

  public function __construct($num) {
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
    $this->m_membres = array();
    $this->m_pauses = array_fill(0, $ev->duree, false);
    $this->m_activites = array();

    /* Initialiser m_activites */
    for ($i = 0 ; $i < $ev->duree ; $i++) {
      $this->ajouter_activite(new HeureActivite());
    }

    /* Initialiser le texte du contenu */
    include('content/class/lang/'.$lang.'/'.$lang.'_Equipe.class.inc.php');
  }

  //-- ACCESSEURS

  public function set_nom($nom) {
    $this->m_nom = $nom;
  }

  public function get_nom() {
    return $this->m_nom;
  }

  public function set_projet($projet) {
    $this->m_projet = $projet;
  }

  public function set_commentaire($commentaire) {
    $this->m_commentaire = $commentaire;
  }

  public function set_lieu($etage, $salle, $endroit) {
    $this->m_lieu_etage = $etage;
    $this->m_lieu_salle = $salle;
    $this->m_lieu_endroit = $endroit;
  }

  public function set_pause($h, $en_pause) {
    $this->m_pauses[$h] = $en_pause;
  }
    
  public function set_activite($h, $type, $description) {
    return $this->m_activites[$h]->add_activite($type, $description);
  }

  //-- METHODES

  public function clear_activite($h) {
    $this->m_activites[$h]->clear();
  }

  public function clear_membres() {
    unset($this->m_membres);
    $this->m_membres = array();
  }

  public function ajouter_membre($nom, $prenom, $affiliation) {
    $membre = new Membre($nom, $prenom, $affiliation);
    array_push($this->m_membres, $membre);
  }

  public function ajouter_activite($activite) {
    array_push($this->m_activites, $activite);
  }

  protected function generer_js_afficher_colone($h) {
    $com_etape = $this->m_activites[$h]->get_com_etape();
    $com_quoi = $this->m_activites[$h]->get_com_quoi();
    $com_outils = $this->m_activites[$h]->get_com_outils();
    if ($com_etape != '' || $com_quoi != '' || $com_outils != '') {
      e('function afficher_colone_'.$this->m_num.'_'.$h.'() {');
      e('document.getElementById(\'ComEtape'.$this->m_num.'\').innerHTML = \'H='.($h+1).' : '.str_replace("'", '\\\'', str_replace('\nl', "<br/>", $com_etape)).'\';');
      e('document.getElementById(\'ComQuoi'.$this->m_num.'\').innerHTML = \'H='.($h+1).' : '.str_replace("'", '\\\'', str_replace('\nl', "<br/>", $com_quoi)).'\';');
      e('document.getElementById(\'ComOutils'.$this->m_num.'\').innerHTML = \'H='.($h+1).' : '.str_replace("'", '\\\'', str_replace('\nl', "<br/>", $com_outils)).'\';');
      e('}');
      return true;
    }
    return false;
  }

  protected function generer_js_afficher_colone_vide() {
    e('function afficher_colone_'.$this->m_num.'_vide() {');
    e('document.getElementById(\'ComEtape'.$this->m_num.'\').innerHTML = \'H=\';');
    e('document.getElementById(\'ComQuoi'.$this->m_num.'\').innerHTML = \'H=\';');
    e('document.getElementById(\'ComOutils'.$this->m_num.'\').innerHTML = \'H=\';');
    e('}');
  }

  protected function afficher_nom($tag) {
    e('<'.$tag.'><a name="'.$this->m_num.'"> </a>'.$this->m_num.' - '.str_replace('\\\'', "'", $this->m_nom).'</'.$tag.'>');
  }

  protected function afficher_projet() {
    e('<p class="bold"><span class="upper">'.$this->m_txt_projet_.'</span> '.str_replace('\\\'', "'", $this->m_projet).'</p>');
  }
    
  protected function afficher_membres() {
    if (isset($this->m_membres) && count($this->m_membres) > 0) {
      e('<p class="bold upper">'.$this->m_txt_membres_.'</p>');
      e('<ol class="membres">');
      foreach ($this->m_membres as $key => $membre) {
        e('<li>');
        $membre->afficher();
        e('</li>');
      }
      e('</ol>');
    }
  }

  public function afficher_pour_palmares($txt_prix, $img_prix='') {

    /* Afficher le prix */
    e('<h2>'.$txt_prix.'</h2>');
    
    /* Afficher le nom de l'equipe */
    $this->afficher_nom('h3');

    /* Afficher le prix */
    if ($img_prix != '') {
      e('<img class="fluxR totem" src="'.$img_prix.'" alt="Award for '.$txt_prix.'" />');
    }
    
    /* Afficher le projet de l'equipe */
    $this->afficher_projet();

    /* Afficher les membres de l'equipe */
    $this->afficher_membres();

    if ($img_prix != '') {
      e('<br class="flux" />');
    }
  }

  public function afficher() {
    global $ev;
    global $H;
    global $lang;
    
    /* Afficher le nom de l'equipe */
    $this->afficher_nom('h2');
    
    if ($H > 0 && $H <= $ev->duree) {
      e('<p class="fluxR"><a href="equipe_fiche.php?lang='.$lang.'&amp;e='.$this->m_num.'">'.$this->m_txt_modifier_fiche.'</a></p>');
    }
    
    /* Afficher le projet de l'equipe */
    $this->afficher_projet();
    
    /* Afficher le lieu de travail de l'equipe */
    if (isset($_GET['lieu'])) {
      e('<p><span class="bold">'.$this->m_txt_lieu.'</span> ');
      e(Equipe::$G_txt_lieu[$this->m_lieu_etage]);
      if ($this->m_lieu_salle!='') {
        e(' / '.$this->m_txt_salle.' '.str_replace('\\\'', "'", $this->m_lieu_salle));
      }
      if ($this->m_lieu_endroit!='') {
        e(' / '.str_replace('\\\'', "'", $this->m_lieu_endroit));
      }
      e('</p>');
    }

    /* Afficher les membres de l'equipe */
    $this->afficher_membres();
    
    /* Generer le js */
    e('<script type="text/javascript">');
    $com_col = array();
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
    e('</script>');

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

      e('<p class="bold">'.$this->m_txt_processus_creativite_.'</p>');

      /* Afficher les activites par ligne decroissante pour toutes les heures H */

      //--
      e('<div class="plegende"><a class="legende" href="#'.$this->m_num.'">&nbsp; '.$this->m_txt_legende.' &nbsp;<span class="survol">');
      $activite = new HeureActivite();
      $activite->afficher_legende();
      e('</span></a></div>');
      //--

      $i = $max-1; // la ligne a afficher
      e('<table class="activite">');
      while ($i>=0) {
        e('<tr>');

        /* Premiere cellule */
        e('<td class="alignR">'.($i+1).'.</td>');

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
          
          e('<td class="'.$color.'" onmouseover="HeadEtape'.$this->m_num.'.style.color = \''.$colorEtape.'\'; ActiviteEtape'.$this->m_num.'.innerHTML = \''.$etape.'\'; ActiviteQuoi'.$this->m_num.'.innerHTML = \''.$quoi.'\'; ActiviteOutils'.$this->m_num.'.innerHTML = \''.$outils.'\' ; '.$com_col[$h].'"><a href="#">'.$personnes.'</a></td>');
        }
        e('</tr>');
        $i--;
      }

      /* Afficher la ligne des heures H */
      e('<tr>');
      e('<td> </td>'); // Premiere cellule : vide
      for ($h = 0 ; $h < $ev->duree ; $h++) {
        e('<td class="bold heuresH '.(($this->m_pauses[$h]) ? 'gray' : '').'">'.($h+1).'</td>');
      }
      e('</tr>');

      e('</table>');

      e('<p>');
      e($this->m_txt_passer_souris);
      e('<span class="italic">'.$this->m_txt_les_pauses.'</span> ');
      e('</p>');

      /* Zones pour afficher les textes des cases */
      e('<table class="activite_com">');

      e('<tr>');
      e('<td class="head1" id="HeadEtape'.$this->m_num.'">'.$this->m_txt_etape.'</td><td class="com1" id="ActiviteEtape'.$this->m_num.'">_</td>');
      e('<td class="head2">'.$this->m_txt_commentaires.'<br/> &laquo;'.$this->m_txt_etape.'&raquo;</td>');
      e('<td class="head2">'.$this->m_txt_commentaires.'<br/> &laquo;'.$this->m_txt_sur_quoi.'&raquo;</td>');
      e('<td class="head2">'.$this->m_txt_commentaires.'<br/> &laquo;'.$this->m_txt_methode.'&raquo;</td>');
      e('</tr>');

      e('<tr>');
      e('<td class="head1">'.$this->m_txt_sur_quoi.' </td><td class="com1" id="ActiviteQuoi'.$this->m_num.'">_</td>');
      e('<td class="com2" id="ComEtape'.$this->m_num.'" rowspan="2">H=</td>');
      e('<td class="com2" id="ComQuoi'.$this->m_num.'" rowspan="2">H=</td>');
      e('<td class="com2" id="ComOutils'.$this->m_num.'" rowspan="2">H=</td>');
      e('</tr>');

      e('<tr>');
      e('<td class="head1">'.$this->m_txt_methode.' </td><td class="com1" id="ActiviteOutils'.$this->m_num.'">_</td>');
      e('</tr>');

      e('</table>');

      /* Generer le js */
      e('<script type="text/javascript">');
      e('var HeadEtape'.$this->m_num.' = document.getElementById(\'HeadEtape'.$this->m_num.'\');');
      e('var ActiviteEtape'.$this->m_num.' = document.getElementById(\'ActiviteEtape'.$this->m_num.'\');');
      e('var ActiviteQuoi'.$this->m_num.' = document.getElementById(\'ActiviteQuoi'.$this->m_num.'\');');
      e('var ActiviteOutils'.$this->m_num.' = document.getElementById(\'ActiviteOutils'.$this->m_num.'\');');
      e('</script>');
    }

  }

  public function afficher_debrief() {
    global $ev;

    /* Afficher le nom de l'equipe */
    e('<h2><a name="'.$this->m_num.'"> </a>'.$this->m_num.' - '.$this->m_nom.'</h2>');

    /* Afficher le projet de l'equipe */
    e('<p class="bold">'.$this->m_txt_projet_.' '.$this->m_projet.'</p>');

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
      e('<div class="plegende"><a class="legende" href="#'.$this->m_num.'">&nbsp; '.$this->m_txt_legende.' &nbsp;<span class="survol">');
      $activite = new HeureActivite();
      $activite->afficher_legende();
      e('</span></a></div>');
      //--

      $i = $max-1; // la ligne a afficher
      e('<table class="activite">');
      while ($i>=0) {
        e('<tr>');

        /* Premiere cellule */
        e('<td class="alignR">'.($i+1).'.</td>');

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
          
          e('<td class="'.$color.'"><a href="#">'.$personnes.'</a></td>');
        }
        e('</tr>');
        $i--;
      }

      /* Afficher la ligne des heures H */
      e('<tr>');
      e('<td> </td>'); // Premiere cellule : vide
      for ($h = 0 ; $h < $ev->duree ; $h++) {
        e('<td class="bold heuresH '.(($this->m_pauses[$h]) ? 'gray' : '').'">'.($h+1).'</td>');
      }
      e('</tr>');

      e('</table>');
    }

    /* Afficher les heures de maniere exhaustive */

    e('<br/>');

    e('<table class="debrief">');
    e('<tr><th class="coin">'.$this->m_num.'</th><th colspan="2">&laquo;'.$this->m_txt_etape.'&raquo;</th><th>&laquo;'.$this->m_txt_sur_quoi.'&raquo;</th><th>&laquo;'.$this->m_txt_methode.'&raquo;</th><th>'.$this->m_txt_nbrpers.'</th></tr>');

    for ($h = 0 ; $h < $ev->duree ; $h++) {

      /* Commentaire de l'heure $h */
      $com_etape = str_replace('\nl', "<br/>", $this->m_activites[$h]->get_com_etape()); 
      $com_quoi = str_replace('\nl', "<br/>", $this->m_activites[$h]->get_com_quoi());
      $com_outils = str_replace('\nl', "<br/>", html_entity_decode($this->m_activites[$h]->get_com_outils()));
      e('<tr class="H"><td class="bold center">H = '.($h+1).'</td><td class="italic" colspan="2">'.$com_etape.'</td><td class="italic">'.$com_quoi.'</td><td class="italic">'.$com_outils.'</td><td>-</td></tr>');

      /* Commentaires des activites */

      for ($i=0 ; $i < $this->m_activites[$h]->get_nbr_activite() ; $i++) {
        $colorEtape = $this->m_activites[$h]->get_color($i, true);
        $etape = $this->m_activites[$h]->get_etape($i);
        $quoi = $this->m_activites[$h]->get_quoi($i);
        $outils = $this->m_activites[$h]->get_outils($i);
        $personnes = str_replace("'", '\\\'', $this->m_activites[$h]->get_personnes($i));

        e('<tr><td class="center">'.($i+1).'.</td><td style="background-color:'.$colorEtape.'; width: 15px;"><br/></td><td>'.$etape.'</td><td>'.$quoi.'</td><td>'.$outils.'</td><td>'.$personnes.'</td></tr>');
      }
    }
    e('</table>');
  }

  public function afficher_formulaire() {
    global $ev;
    global $H;
      
    e('<h3>'.$this->m_txt_projet.'</h3>');

    /* Nom de l'equipe */
    e('<p><span class="bold">'.$this->m_txt_nom_equipe.'</span> <input class="text" type="text" id="EquipeNom" name="EquipeNom" value="'.html_entity_decode(str_replace('\\\'', "'", $this->m_nom)).'" /></p>');

    /* Projet de l'equipe */
    e('<p><span class="bold">'.$this->m_txt_titre_projet.' </span><input class="text_large" type="text" id="EquipeProjet" name="EquipeProjet" value="'.html_entity_decode(str_replace('\\\'', "'", $this->m_projet)).'" /></p>');

    /* Commentaire de l'equipe */
    e('<p>'.$this->m_txt_commentaire.'</p>');
    e('<p><textarea class="textarea" id="EquipeCommentaire" name="EquipeCommentaire" cols="20" rows="4">'.str_replace('\nl', "\r\n", html_entity_decode($this->m_commentaire)).'</textarea></p>');

    /* Lieu de travail de l'equipe */
    e('<p><span class="bold">'.$this->m_txt_lieu.' </span></p>');
    e('<table>');
    e('<tr><td>'.$this->m_txt_etage.'</td><td>'.str_replace('\\\'', "'", $this->m_txt_salle).'</td><td>'.str_replace('\\\'', "'", $this->m_txt_endroit).'</td></tr>');
    e('<tr>');
    e('<td><select id="EquipeLieu_etage" name="EquipeLieu_etage" />');
    e('<option value="0" '.(($this->m_lieu_etage==0)?'selected="selected"':'').'>'.Equipe::$G_txt_lieu[0].'</option>');
    e('<option value="1" '.(($this->m_lieu_etage==1)?'selected="selected"':'').'>'.Equipe::$G_txt_lieu[1].'</option>');
    e('<option value="2" '.(($this->m_lieu_etage==2)?'selected="selected"':'').'>'.Equipe::$G_txt_lieu[2].'</option>');
    e('</select></td>');
    e('<td><input class="text_small" type="text" id="EquipeLieu_salle" name="EquipeLieu_salle" value="'.html_entity_decode($this->m_lieu_salle).'" /></td>');
    e('<td><input class="text_large" type="text" id="EquipeLieu_endroit" name="EquipeLieu_endroit" value="'.html_entity_decode($this->m_lieu_endroit).'" /></td>');
    e('</tr>');
    e('</table>');
    e('<p class="center"><span class="italic">('.$this->m_txt_lieu_rmq.')</span></p>');

    e('<h3>'.$this->m_txt_membres.'</h3>');

    /* Membres de l'equipe */
    e('<table>');
    e('<tr><td> </td><td>'.$this->m_txt_prenom.'</td><td>'.$this->m_txt_nom.'</td><td>'.$this->m_txt_affiliation.'</td></tr>');
    $i = 0;
    foreach ($this->m_membres as $key => $membre) {
      $membre->afficher_formulaire($i);
      $i++;
    }
    while ($i < $ev->max_membres) {
      membre_afficher_formulaire($i);
      $i++;
    }
    e('</table>');

    e('<h3>'.$this->m_txt_processus_creativite.'</h3>');
    
    /* Affichage de l'heure */
    e('<p>'.heure().'</p>');

    /* Pauses */
    e('<p class="bold center">'.$this->m_txt_pauses.'</p>');
    e('<table class="pauses">');
    e('<tr>');
    for ($h = 0 ; $h < $ev->duree ; $h++) {
      if ($h % 12 == 0) {
          e('</tr><tr>');
      }
      e('<td><label id="lb_pause'.$h.'" for="EQ_pause'.$h.'">'); 
      e('<input type="checkbox" id="EQ_pause'.$h.'" name ="EQ_pause['.$h.']" value="1" '.(($this->m_pauses[$h]) ? 'checked="checked"' : '').' /><br/>');
      chrono_afficher_alpha($h+1);
      e('</label></td>');
    }
    e('</tr>');
    e('</table>');

    /* Suivi des activites */
    $h = $H-1;
    if ($H > 0 && $H <= $ev->duree) {
      if ($H < $ev->duree) {
        chrono_afficher($H, 'rouge');
        $this->m_activites[$h]->afficher_formulaire($h, 'rouge');
        e('<p><input type="hidden" name="h" value="'.$h.'" /></p>');
      }
      if ($H > 1) {
        chrono_afficher($H-1, 'gris');
        $this->m_activites[$h-1]->afficher_formulaire($h-1, 'gris');
        e('<p><input type="hidden" name="h_1" value="'.($h-1).'" /></p>');
      }
      if ($H > 2) {
        chrono_afficher($H-2, 'gris');
        $this->m_activites[$h-2]->afficher_formulaire($h-2, 'gris');
        e('<p><input type="hidden" name="h_2" value="'.($h-2).'" /></p>');
      }
    }
  }

  public function enregistrer_formulaire($h) {
    $this->clear_activite($h);
    $this->m_activites[$h]->enregistrer_formulaire($h);
  }

  public function serialize() {
    global $ev;
      
    /* Ouverture d'un descripteur en lecture seule */
    $desc = fopen(Equipe::$G_PATH.$this->m_num.'.txt', 'w');

    if (!$desc) {
      die('Erreur ouverture fichier '.$this->m_num.'.txt en ecriture');
    }

    /* Nom de l'equipe */
    fputs($desc, 'NOM>'.$this->m_nom.'>');

    /* Projet de l'equipe */
    fputs($desc, 'PROJET>'.$this->m_projet.'>');

    /* Commentaire de l'equipe */
    fputs($desc, 'COMMENTAIRE>'.$this->m_commentaire.'>');

    /* Lieu de travail de l'equipe */
    fputs($desc, 'LIEU>'.$this->m_lieu_etage.'>'.$this->m_lieu_salle.'>'.$this->m_lieu_endroit.'>');

    /* Nombre de membres */
    fputs($desc, 'NOMBRE>'.count($this->m_membres).'>');

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

  public function unserialize() {
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
        array_push($this->m_membres, $membre);
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

  private $m_num;        // string
  private $m_nom;        // string
  private $m_projet;     // string
  private $m_lieu_etage; // string
  private $m_lieu_salle; // string
  private $m_lieu_endroit; // string
  private $m_commentaire; // string
  private $m_membres;    // Membre[]
  private $m_pauses;     // boolean[]
  private $m_activites;  // HeureActivite[]

  private $m_lang;

  /* Texte du contenu */
  private $m_txt_modifier_fiche;
  /*--*/
  private $m_txt_projet_;
  private $m_txt_membres_;
  private $m_txt_processus_creativite_;
  private $m_txt_legende;
  private $m_txt_passer_souris;
  private $m_txt_les_pauses;
  private $m_txt_commentaires;
  private $m_txt_etape;
  private $m_txt_sur_quoi;
  private $m_txt_methode;
  private $m_txt_nbrpers;
  /*--*/
  private $m_txt_projet;
  private $m_txt_nom_equipe;
  private $m_txt_titre_projet;
  private $m_txt_lieu;
  private $m_txt_lieu_rmq;
  private $m_txt_etage;
  private $m_txt_salle;
  private $m_txt_endroit;
  private $m_txt_commentaire;
  private $m_txt_membres;
  private $m_txt_nom;
  private $m_txt_prenom;
  private $m_txt_affiliation;
  private $m_txt_processus_creativite;
  private $m_txt_pauses;

  //-- MEMBRES private

  private static $G_PATH = 'data/equipes/';
  public static $G_txt_lieu;
}

include('content/class/lang/'.$lang.'/'.$lang.'_Equipe.static.class.inc.php');

?>
