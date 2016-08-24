<?php
set_time_limit(0);
ini_set("memory_limit", "-1");

require_once("../db.php");
//require_once("../variables.php");
require_once("../functions/sync.php");

$debug=1;

###### a quitar 
$ip='192.168.1.166';
$doit=1;
###############


$noestan=array();

$dbnivel=new DB('192.168.1.113','tpv','tpv','RisaseTPV');
$dbnivelAPP=new DB('192.168.1.11','tpv','pepito','risase');

if (!$dbnivelAPP->open()){die($dbnivelAPP->error());};
if (!$dbnivelAPP->close()){die($dbnivelAPP->error());};

if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "select id, codbarras from articulos where id >= 90000;";
$dbnivel->query($queryp); if($debug){echo "$queryp <br>\n\n";};

while ($row = $dbnivel->fetchassoc()){
$cods[$row['id']]=$row['codbarras'];	
}

if (!$dbnivel->close()){die($dbnivel->error());};




if (!$dbnivelAPP->open()){die($dbnivelAPP->error());};

$queryp="UPDATE articulos 
SET codbarras = CASE id 
";

$idd="";
foreach ($cods as $id => $cod) {$idd.=$id . ",";
$queryp .= "WHEN $id THEN $cod 
";

}

$idd=substr($idd, 0,-1);
$queryp .= "END 
WHERE id IN ($idd)
";

$dbnivelAPP->query($queryp); if($debug){echo "$queryp <br>\n\n";};
if (!$dbnivelAPP->close()){die($dbnivelAPP->error());};





	
	
	
?>