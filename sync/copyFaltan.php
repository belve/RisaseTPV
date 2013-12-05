<?php
set_time_limit(0);
ini_set("memory_limit", "-1");

require_once("../db.php");
//require_once("../variables.php");
require_once("../functions/sync.php");

$debug=1;

###### a quitar 
$ip='192.168.1.210';
$doit=1;
###############


$noestan=array();

$dbnivel=new DB($ip,'tpv','tpv','RisaseTPV');
$dbnivelAPP=new DB('192.168.1.11','tpv','tpv','risase');
$dbnivelBAK=new DB('192.168.1.11','tpv','tpv','tpv_backup');



if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "select var, value from config";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$config = "\$" . $row['var'] . "='" . $row['value'] . "';";
eval($config);
}






if (!$dbnivel->close()){die($dbnivel->error());};

$distintos=array(); $ids="";
if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "select id_art, stock, alarma from stocklocal;";
$dbnivel->query($queryp);if($debug){echo "$queryp <br>\n\n";};
while ($row = $dbnivel->fetchassoc()){ $ids.=$row['id_art'] . ",";};	
if (!$dbnivel->close()){die($dbnivel->error());};

$ids=substr($ids, 0,-1);

if (!$dbnivelBAK->open()){die($dbnivelBAK->error());};
$queryp= "select id_art, stock, alarma, cod from stocklocal_$id_tienda WHERE id_art NOT IN ($ids);";
$dbnivelBAK->query($queryp);if($debug){echo "$queryp <br>\n\n";};
while ($row = $dbnivelBAK->fetchassoc()){

$TTtpv[$row['id_art']]=$row['stock']; $alarma[$row['id_art']]=$row['alarma']; $cods[$row['id_art']]=$row['cod'];	
	
};


if (!$dbnivelBAK->close()){die($dbnivelBAK->error());};


echo count($TTtpv);
$creo="INSERT INTO stocklocal (id_art,cod,stock,alarma) VALUES ";
foreach ($TTtpv as $iddaa => $stockk) {
$alm=$alarma[$iddaa];$cod=$cods[$iddaa];

$creo.="($iddaa,$cod,$stockk,$alm),";
	
}

$creo=substr($creo, 0,-1);

echo "\n";




if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= $creo;
$dbnivel->query($queryp);
if($debug){echo "$queryp <br>\n\n";};

if (!$dbnivel->close()){die($dbnivel->error());};

?>