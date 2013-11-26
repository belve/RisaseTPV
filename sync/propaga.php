<?php
set_time_limit(0);
ini_set("memory_limit", "-1");

require_once("../db.php");
require_once("../variables.php");

$debug=1;


$dbnivelAPP=new DB('192.168.1.11','tpv','tpv','risase');

if (!$dbnivelAPP->open()){die($dbnivelAPP->error());};
$queryp= "select id from tiendas where activa=1;";
$dbnivelAPP->query($queryp);if($debug){echo "$queryp <br>\n\n";};
while ($row = $dbnivelAPP->fetchassoc()){$itt[$row['id']]=1;};



print_r($itt);

$apropagar="UPDATE articulos SET codigo = substring(codbarras,5,4) where id <= 99297 AND id >=99283;";

echo "_______________________________________________\n";
echo $apropagar;
echo "_______________________________________________\n";

$apropagar=addslashes($apropagar);
foreach ($itt as $idt => $po) {
$queryp= "INSERT INTO syncupdate (id_tiend,syncSql) VALUES ($idt,'$apropagar')";
$dbnivelAPP->query($queryp);
if($debug){
echo "\n_______________________________________________\n";
	echo "$queryp \n";
echo "_______________________________________________\n";	
	};
	
}


if (!$dbnivelAPP->close()){die($dbnivelAPP->error());};


?>