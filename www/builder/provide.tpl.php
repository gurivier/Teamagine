<?php
include('{WD}builder-refresh.inc.php');
$lang=(!isset($_GET['lang']) || !($_GET['lang']=='fr' || $_GET['lang']=='en')) ? (isset($argv[1]) ? $argv[1] : 'fr') : $_GET['lang'];
$__f_stdout__=null;
$__t_content=filemtime('cache/{FILENAME_HTML}');
$__t_dev=filemtime('{FILENAME_DEV_PHP}');
if(isset($_GET['__force']) || $__t_content < $__t_dev){
 function e(string $s):void{
  global $__f_stdout__;
  fputs($__f_stdout__, $s);
 }
 $__f_stdout__=fopen('cache/{FILENAME_HTML}', 'w');
 include('{FILENAME_DEV_PHP}');
 fclose($__f_stdout__);
}
include('cache/{FILENAME_HTML}');
?>
