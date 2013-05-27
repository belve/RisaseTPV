<?php

require_once("db.php");
require_once("variables.php");


$link = mysql_connect('localhost', 'root', '2010dos');
if (!$link) {
  die('Not connected : ' . mysql_error());
}

$db_selected = mysql_select_db('RisaseTPV', $link);
if (!$db_selected) {
  die ('Cannot use foo : ' . mysql_error());
}else{
	
echo "creada";	
	
	
}



?>