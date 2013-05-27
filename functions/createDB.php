<?php
require_once("../db.php");
require_once("../variables.php");


$lineas=file("../sql/createDB.sql");


$content="";
foreach ($lineas as $nl => $value) {$content.=$value;};
$lines=explode(';',$content);

$conDB=mysqli_connect("localhost","root","2010dos");
foreach ($lines as $l => $queryp) {
mysqli_query($conDB,$queryp . ";");	
}




?>