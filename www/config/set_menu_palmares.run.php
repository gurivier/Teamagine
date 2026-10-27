<?php

function set_menu_palmares(bool $state):void {
  if($state){
    touch('runtime/palmares');
  }
  else{
    unlink('runtime/palmares');
  }
  include('../builder/builder.inc.php');
  clean_cache_files();
  touch('../builder/cache/last_refresh');
}

if (isset($_GET['state'])) {
  $state = ($_GET['state'] == '1');
  set_menu_palmares($state);
}
else if (isset($argv[1])) {
  $state = ($argv[1] == '1');
  set_menu_palmares($state);
}

?>
