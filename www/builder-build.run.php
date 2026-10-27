<?php
include('builder/builder.inc.php');
clean();
build('builder/provide.tpl.php');
touch('builder/cache/last_refresh');
?>
