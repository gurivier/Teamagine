<?php

include_once('content/pkg/no_accent.inc.php');

class HeureActivite {

  //-- CONSTRUCTEURS

  public function __construct() {
    global $lang;
      
    /* Creation des tableaux */
    $this->m_activite_etape = array();
    $this->m_activite_quoi = array();
    $this->m_activite_outils = array();
    $this->m_activite_personnes = array();

    /* Initialisation des chaines de caracteres */
    $this->m_commentaire_etape = '';
    $this->m_commentaire_quoi = '';
    $this->m_commentaire_outils = '';
    
    /* Initialiser le texte du contenu */
    include('content/class/lang/'.$lang.'/'.$lang.'_HeureActivite.class.inc.php');
  }

  //-- ACCESSEURS

  public function get_nbr_activite() {
    return count($this->m_activite_etape);
  }

  public function get_etape($i) {
    $val = $this->m_activite_etape[$i];
    if ($this->is_key_etape($val)) {
      return HeureActivite::$G_ETAPE[$val];
    }
    else {
      return htmlentities(no_accent($val)); // Autre
    }
  }

  public function get_quoi($i) {
    $val=$this->m_activite_quoi[$i];

    if ($this->is_key_quoi($val)) {
      return HeureActivite::$G_QUOI[$val];
    }
    else {
      return htmlentities(no_accent($val)); // Autre
    }
  }

  public function get_outils($i) {
    $val=$this->m_activite_outils[$i];

    if ($this->is_key_outils($val)) {
      return HeureActivite::$G_OUTILS[$val];
    }
    else {
      return htmlentities(no_accent($val)); // Autre
    }
  }

  public function get_personnes($i) {
    return htmlentities(no_accent($this->m_activite_personnes[$i]));
  }

  public function get_com_etape() {
    return $this->m_commentaire_etape;
  }

  public function get_com_quoi() {
    return $this->m_commentaire_quoi;
  }

  public function get_com_outils() {
    return $this->m_commentaire_outils;
  }

  public function get_color($i, $html) {
    return $this->get_color_etape($this->m_activite_etape[$i], $html);
  }

  /** 
   * Calcule le code couleur associe a la valeur d'une etape.
   *
   * Retourne le code couleur HTML si $html vaut vrai, le nom de la classe CSS sinon.
   */
  public function get_color_etape($etape, $html) {
    if ($this->is_key_etape($etape)) {
      return ($html) ? HeureActivite::$G_ETAPE_COLOR_HTML[$etape] : HeureActivite::$G_ETAPE_COLOR_CSS[$etape];
    }
    else {
      return ($html) ? HeureActivite::$G_ETAPE_COLOR_HTML['aut'] : HeureActivite::$G_ETAPE_COLOR_CSS['aut'];
    }
  }

  //-- METHODES

  public function clear() {

    unset($this->m_activite_etape);
    unset($this->m_activite_quoi);
    unset($this->m_activite_outils);
    unset($this->m_activite_personnes);

    $this->m_activite_etape = array();
    $this->m_activite_quoi = array();
    $this->m_activite_outils = array();
    $this->m_activite_personnes = array();
  }

  public function ajouter_activite($etape, $quoi, $outils, $nombre) {
    
    array_push($this->m_activite_etape, $etape);
    array_push($this->m_activite_quoi, $quoi);
    array_push($this->m_activite_outils, $outils);
    array_push($this->m_activite_personnes, $nombre);
  }

  public function afficher_legende() {
    e('<table class="activite">');
    e('<tr><th> </th><th>'.$this->m_txt_etape.'</th></tr>');
    
    /* Groupes d'options (Un seul groupe ETAPE a l'heure actuelle) */
    foreach (HeureActivite::$G_OPTGROUP_ETAPE[1] as $key => $val) {
      e('<tr><td class="'.$this->get_color_etape($val, false).'"> </td><td class="legende"><span class="italic">'.HeureActivite::$G_OPTGROUP_ETAPE[0].'</span> : '.HeureActivite::$G_ETAPE[$val].'</td></tr>');
    }

    /* Options */
    foreach (HeureActivite::$G_OPTIONS_ETAPE as $key => $val) {
      e('<tr><td class="'.$this->get_color_etape($val, false).'"> </td><td class="legende">'.HeureActivite::$G_ETAPE[$val].'</td></tr>');
    }

    /* Autre */
    e('<tr><td class="'.$this->get_color_etape('aut', false).'"> </td><td class="legende"><span class="italic">'.HeureActivite::$G_ETAPE['aut'].'</span></td></tr>');

    /* Nombre de personnne*/
    e('<tr><td class="legendenpers">N</td><th class="legende">'.HeureActivite::$G_txt['personnes'].'</th></tr>');

    e('</table>');
  }

  public function afficher_formulaire($h, $couleur) {

    e('<table class="form_activite">');
    e('<tr><td> </td>');
    e('<th>'.HeureActivite::$G_txt['etape'].'</th><td>'.HeureActivite::$G_txt['precisez'].'</td>');
    e('<th>'.HeureActivite::$G_txt['personnes'].'</th>');
    e('<th>'.HeureActivite::$G_txt['quoi'].'</th><td>'.HeureActivite::$G_txt['precisez'].'</td>');
    e('<th>'.HeureActivite::$G_txt['outils'].'</th><td>'.HeureActivite::$G_txt['precisez'].'</td>');
    e('</tr>');

    /* Les options */

    for ($i = 0 ; $i < HeureActivite::$G_NBR_MAX ; $i++) {
      e('<tr class="bg_'.$couleur.'">');

      /* Premiere cellule */
      e('<td class="alignR">'.($i+1).'.</td>');

      if ($i < count($this->m_activite_etape)) {
        $this->afficher_formulaire_activite($h, $i,
                                             'etape', HeureActivite::$G_ETAPE, HeureActivite::$G_OPTIONS_ETAPE, HeureActivite::$G_OPTGROUP_ETAPE,
                                             $this->m_activite_etape[$i]);
      }
      else {
        $this->afficher_formulaire_activite($h, $i,
                                             'etape', HeureActivite::$G_ETAPE, HeureActivite::$G_OPTIONS_ETAPE, HeureActivite::$G_OPTGROUP_ETAPE);
      }

      if ($i < count($this->m_activite_personnes)) {
        $nbr_personnes=$this->m_activite_personnes[$i];
      }
      else {
        $nbr_personnes='';
      }
      e('<td><input class="text_verysmall" type="text" id="EQ_personnes'.$h.'_'.$i.'" name="EQ_personnes['.$h.']['.$i.']" value="'.$nbr_personnes.'" /></td>');


      if ($i < count($this->m_activite_quoi)) {
        $this->afficher_formulaire_activite($h, $i,
                                             'quoi', HeureActivite::$G_QUOI, HeureActivite::$G_OPTIONS_QUOI, HeureActivite::$G_OPTGROUP_QUOI,
                                             $this->m_activite_quoi[$i]);
      }
      else {
        $this->afficher_formulaire_activite($h, $i,
                                             'quoi', HeureActivite::$G_QUOI, HeureActivite::$G_OPTIONS_QUOI, HeureActivite::$G_OPTGROUP_QUOI);
      }
      
      if ($i < count($this->m_activite_outils)) {
        $this->afficher_formulaire_activite($h, $i,
                                             'outils', HeureActivite::$G_OUTILS, HeureActivite::$G_OPTIONS_OUTILS, HeureActivite::$G_OPTGROUP_OUTILS,
                                             $this->m_activite_outils[$i]);
      }
      else {
        $this->afficher_formulaire_activite($h, $i,
                                             'outils', HeureActivite::$G_OUTILS, HeureActivite::$G_OPTIONS_OUTILS, HeureActivite::$G_OPTGROUP_OUTILS);
      }
      
      e('</tr>');
    }

    /* Les commentaires */

    e('<tr>');
    e('<td> </td>');
    e('<td colspan="3"><textarea class="textarea" id="EQ_etape_com'.$h.'" name="EQ_etape_com'.$h.'" cols="20" rows="4">'.str_replace('\nl', "\r\n", html_entity_decode($this->m_commentaire_etape)).'</textarea></td>');
    e('<td colspan="2"><textarea class="textarea" id="EQ_quoi_com'.$h.'" name="EQ_quoi_com'.$h.'" cols="20" rows="4">'.str_replace('\nl', "\r\n", html_entity_decode($this->m_commentaire_quoi)).'</textarea></td>');
    e('<td colspan="2"><textarea class="textarea" id="EQ_outils_com'.$h.'" name="EQ_outils_com'.$h.'" cols="20" rows="4">'.str_replace('\nl', "\r\n", html_entity_decode($this->m_commentaire_outils)).'</textarea></td>');
    e('</tr>');  

    e('<tr>');
    e('<td> </td>');
    e('<th colspan="3">'.HeureActivite::$G_txt['com'].'</th>');
    e('<th colspan="2">'.HeureActivite::$G_txt['com'].'</th>');
    e('<th colspan="2">'.HeureActivite::$G_txt['com'].'</th>');
    e('</tr>');  

    e('</table>');

    e('<p class="italic">(<span class="bold">'.HeureActivite::$G_txt['personnes'].'</span> = '.HeureActivite::$G_txt['rmq_nbr_pers'].'.)</p>');
  }

  protected function afficher_formulaire_activite($h, $i, $label, &$OPTION_NAME, &$options, &$optgroup, $type = '') {

    /* Debut du champ select */
      e('<td><select id="EQ_'.$label.'_'.$h.'_'.$i.'" name="EQ_'.$label.'['.$h.']['.$i.']" onchange="document.getElementById(\'EQ_'.$label.'Autre'.$h.'_'.$i.'\').disabled=(this.options[this.selectedIndex].value != \'aut\'); ">');

    $autre = $this->afficher_formulaire_option($h, $i, $OPTION_NAME, $options, html_entity_decode($type));

    if (count($optgroup)> 0) {
      $tmp = $this->afficher_formulaire_optgroup($h, $i, $OPTION_NAME, $optgroup, html_entity_decode($type));
      $autre = $tmp && $autre;
    }
    
    /* La valeur Autre */

    e('<optgroup label="Autres">');
    if ($autre) {
        e('<option value="aut" selected="selected">'.$OPTION_NAME['aut'].'</option>');
    }
    else {
        e('<option value="aut">'.$OPTION_NAME['aut'].'</option>');
    }
    e('</optgroup>');

    /* Fin du champ select */
    e('</select></td>');

    /* Champ texte pour specifier dans le cas Autre */
    if ($autre) {
      $autre_val = html_entity_decode($type);
      $disabled = '';
    }
    else {
      $autre_val = '';
      $disabled = 'disabled="disabled"';
    }
    e('<td><input class="text" type="text" id="EQ_'.$label.'Autre'.$h.'_'.$i.'" name="EQ_'.$label.'Autre['.$h.']['.$i.']" value="'.$autre_val.'" '.$disabled.' /></td>');
  }

  protected function afficher_formulaire_option($h, $i, &$OPTION_NAME, &$options, $type) {

    /* Liste de choix pour le type */
    $autre = true;

    /* La valeur Vide */
    if ($type == '') {
      $autre = false;
      e('<option value="" selected="selected"> </option>');
    }
    else {
      e('<option value=""> </option>');
    }

    /* Les options */
    foreach ($options as $n => $option) {
      if ($type == $option) {
        $autre = false;
        e('<option value="'.$option.'" selected="selected">'.$OPTION_NAME[$option].'</option>');
      }
      else {
        e('<option value="'.$option.'">'.$OPTION_NAME[$option].'</option>');
      }
    }
    
    return $autre;
  }
  
  protected function afficher_formulaire_optgroup($h, $i, &$OPTION_NAME, &$optgroup, $type) {

    /* Liste de choix pour le type */
    $autre = true;

    e('<optgroup label="'.$optgroup[0].'">');

    /* Les options des groupes */
    foreach ($optgroup[1] as $n => $option) {
      if ($type == $option) {
        $autre = false;
        e('<option value="'.$option.'" selected="selected">'.$OPTION_NAME[$option].'</option>');
      }
      else {
        e('<option value="'.$option.'">'.$OPTION_NAME[$option].'</option>');
      }
    }

    e('</optgroup>');

    return $autre;
  }

  public function enregistrer_formulaire($h) {

    for ($i = 0 ; $i < HeureActivite::$G_NBR_MAX ; $i++) {

      $etape = $_POST['EQ_etape'][$h][$i] ?? '';
      $etape = htmlentities(no_accent($etape));
      
      $quoi = $_POST['EQ_quoi'][$h][$i] ?? '';
      $quoi = htmlentities(no_accent($quoi));

      $outils = $_POST['EQ_outils'][$h][$i] ?? '';
      $outils = htmlentities(no_accent($outils));

      $personnes = $_POST['EQ_personnes'][$h][$i] ?? '';
      $personnes = htmlentities(no_accent($personnes));
      $personnes = ($personnes == '') ? 0 : intval($personnes);
      
      if ($etape != '' || $quoi != '' || $outils != '') {

        if ($etape == 'aut') {
          $etape = $_POST['EQ_etapeAutre'][$h][$i] ?? '';
          $etape = htmlentities(no_accent($etape));
        }
        
        if ($quoi == 'aut') {
          $quoi = $_POST['EQ_quoiAutre'][$h][$i] ?? '';
          $quoi = htmlentities(no_accent($quoi));
        }
        
        if ($outils == 'aut') {            
          $outils = $_POST['EQ_outilsAutre'][$h][$i] ?? '';
          $outils = htmlentities(no_accent($outils));
        }
        
        $this->ajouter_activite($etape, $quoi, $outils, $personnes);
      }
    }

    $etape_com = $_POST['EQ_etape_com'.$h];
    $etape_com = htmlentities(no_accent($etape_com));

    $this->m_commentaire_etape = str_replace(array("\r\n", "\n", "\r"), '\nl', $etape_com);

    $quoi_com = $_POST['EQ_quoi_com'.$h];
    $quoi_com = htmlentities(no_accent($quoi_com));

    $this->m_commentaire_quoi = str_replace(array("\r\n", "\n", "\r"), '\nl', $quoi_com);

    $outils_com = $_POST['EQ_outils_com'.$h];
    $outils_com = htmlentities(no_accent($outils_com));

    $this->m_commentaire_outils = str_replace(array("\r\n", "\n", "\r"), '\nl', $outils_com);
  }

  public function serialize($h, $desc) {

    fputs($desc, $h.'>'."\r\n");
    fputs($desc, $h.'>'.$this->m_commentaire_etape.'>'."\r\n");
    fputs($desc, $h.'>'.$this->m_commentaire_quoi.'>'."\r\n");
    fputs($desc, $h.'>'.$this->m_commentaire_outils.'>'."\r\n");

    for ($i = 0 ; $i < count($this->m_activite_etape) ; $i++) {
      fputs($desc, $h.'>'.$this->m_activite_etape[$i].'>'.$this->m_activite_quoi[$i].'>'.$this->m_activite_outils[$i].'>'.$this->m_activite_personnes[$i].'>'."\r\n");
    }
  }

  public function unserialize_activite($h, $desc) {
    $line = fgets($desc);
    $tab = explode(">", $line);

    if ($tab[0] != $h) {
      return $tab[0];
    }
    
    $this->ajouter_activite($tab[1], $tab[2], $tab[3], $tab[4]);

    return $h;
  }

  public function unserialize_com_etape($desc) {
    $line = fgets($desc);
    $tab = explode(">", $line);
    $this->m_commentaire_etape = $tab[1];
  }

  public function unserialize_com_quoi($desc) {
    $line = fgets($desc);
    $tab = explode(">", $line);
    $this->m_commentaire_quoi = $tab[1];
  }

  public function unserialize_com_outils($desc) {
    $line = fgets($desc);
    $tab = explode(">", $line);
    $this->m_commentaire_outils = $tab[1];
  }

  protected function find_key_etape($etape) {
    foreach (HeureActivite::$G_ETAPE as $key => $val) {
      if ($val == $etape) {
        return $key;
      }
    }
    return 'aut';
  }

  protected function find_key_quoi($quoi) {
    foreach (HeureActivite::$G_QUOI as $key => $val) {
      if ($val == $quoi) {
        return $key;
      }
    }
    return 'aut';
  }

  protected function find_key_outils($outils) {
    foreach (HeureActivite::$G_OUTILS as $key => $val) {
      if ($val == $outils) {
        return $key;
      }
    }
    return 'aut';
  }

  protected function is_key_etape($etape) {
    foreach (HeureActivite::$G_ETAPE as $key => $val)  {
      if ($key == $etape) {
        return true;
      }
    }
    return false;
  }

  protected function is_key_quoi($quoi) {
    foreach (HeureActivite::$G_QUOI as $key => $val) {
      if ($key == $quoi) {
        return true;
      }
    }
    return false;
  }

  protected function is_key_outils($outils) {
    foreach (HeureActivite::$G_OUTILS as $key => $val) {
      if ($key == $outils) {
        return true;
      }
    }
    return false;
  }

  //-- MEMBRES

  private $m_txt_etape;          // string
    
  private $m_activite_etape;     // string[]
  private $m_activite_quoi;      // string[]
  private $m_activite_outils;    // string[]
  private $m_activite_personnes; // string[]

  private $m_commentaire_etape;  // string
  private $m_commentaire_quoi;   // string
  private $m_commentaire_outils; // string
    
  //-- MEMBRES static

  private static $G_NBR_MAX = 10; // Nombre maximum d'activites

  public static $G_txt;

  public static $G_ETAPE;
  public static $G_GROUP_ETAPE;
  public static $G_OPTIONS_ETAPE;
  public static $G_OPTGROUP_ETAPE; // Titre de l'optgroup, suivi des options

  public static $G_QUOI;
  public static $G_GROUP_QUOI;
  public static $G_OPTIONS_QUOI;
  public static $G_OPTGROUP_QUOI; // Titre de l'optgroup, suivi des options

  public static $G_OUTILS;
  public static $G_GROUP_OUTILS;
  public static $G_OPTIONS_OUTILS;
  public static $G_OPTGROUP_OUTILS; // Titre de l'optgroup, suivi des options
    
  private static $G_ETAPE_COLOR_HTML=array(
    'ana' => '#A52A2A',  /* Rouge */
    'con' => '#D2691E',  /* Rouge orange */
    'sol' => '#FC0',     /* Jaune */
    'dim' => '#4169E1',  /* Bleu */
    'prot' => '#228B22', /* Rentre dans le vert */
    'chi' => '#98FB98',  /* Vert clair */
    'proj' => '#800080', /* Violet 1 */
    'tac' => '#9400D3',  /* Violet 2 */
    'pre' => '#222',     /* Gris fonce */
    'aut' => '#000'      /* (couleur qui se distange, beige, marron clair, ...) */
  );
    
  private static $G_ETAPE_COLOR_CSS=array(
    'ana' => 'rge',   /* Rouge */
    'con' => 'org',   /* Rouge orange */
    'sol' => 'jau',   /* Jaune */
    'dim' => 'ble',   /* Bleu */
    'prot' => 'ver1', /* Rentre dans le vert */
    'chi' => 'ver2',  /* Vert clair */
    'proj' => 'vio1', /* Violet 1 */
    'tac' => 'vio2',  /* Violet 2 */
    'pre' => 'gri',   /* Gris fonce */
    'aut' => 'aut'    /* (couleur qui se distange, beige, marron clair, ...) */
  );
}

include_once('content/class/lang/'.$lang.'/'.$lang.'_HeureActivite.static.class.inc.php');

HeureActivite::$G_OPTIONS_ETAPE=array('ana', 'con', 'sol', 'dim', 'prot', 'chi', 'pre');
HeureActivite::$G_OPTGROUP_ETAPE=array(HeureActivite::$G_GROUP_ETAPE[0], array('proj', 'tac')); // Titre de l'optgroup, suivi des options

HeureActivite::$G_OPTIONS_QUOI=array('pro', 'arc');
HeureActivite::$G_OPTGROUP_QUOI=array(HeureActivite::$G_GROUP_QUOI[0], array('fon', 'asp', 'com', 'mat', 'usa', 'sen', 'erg')); // Titre de l'optgroup, suivi des options

HeureActivite::$G_OPTIONS_OUTILS=array('web', 'rdv', 'bra', 'ref', 'cro', 'met', 'cat', 'sel', 'sch', 'xao', 'bur', 'maq', 'tes', 'exp');
HeureActivite::$G_OPTGROUP_OUTILS=array(); // Titre de l'optgroup, suivi des options

?>
