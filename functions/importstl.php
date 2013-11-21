<?php


$debug=0;
$point=0;
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

require_once("../db.php");
require_once("../variables.php");

$dbnivelAPP=new DB('192.168.1.11','tpv','tpv','risase');
$dbnivelBAK=new DB('192.168.1.11','tpv','tpv','tpv_backup');


if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "SELECT max(id) as point from stocklocal;";
$dbnivel->query($queryp);
if($debug){echo "$queryp \n\n"; echo $dbnivel->error();};
while ($row = $dbnivel->fetchassoc()){$point=$row['point'];};
if (!$dbnivel->close()){die($dbnivel->error());};
$point++;



if (!$dbnivelBAK->open()){die($dbnivelBAK->error());};




$queryp= "select max(id) as total from stocklocal_$idt;";
$dbnivelBAK->query($queryp);if($debug){echo "$queryp \n\n"; echo $dbnivelBAK->error();};
while ($row = $dbnivelBAK->fetchassoc()){$total=$row['total'];};


if($point < $total){
	
$values="";
$queryp= "select * from stocklocal_$idt where id >= $point limit 1000;";
$dbnivelBAK->query($queryp);if($debug){echo "$queryp \n\n"; echo $dbnivelBAK->error();};
while ($row = $dbnivelBAK->fetchassoc()){


$cod=addslashes($row['cod']); 
$id_art=addslashes($row['id_art']); 	                    
$stock=addslashes($row['stock']);           
$alarma=addslashes($row['alarma']);            
$pvp=addslashes($row['pvp']);


$values .="('$cod','$id_art','$stock','$alarma','$pvp'),";
	
}
}
$values=substr($values, 0,strlen($values)-1);

if (!$dbnivelBAK->close()){die($dbnivelBAK->error());};



if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "INSERT INTO stocklocal (cod,id_art,stock,alarma,pvp) VALUES $values;";
$dbnivel->query($queryp);if($debug){echo "$queryp \n\n"; echo $dbnivel->error();};


$queryp= "SELECT max(id) as point from stocklocal;";
$dbnivel->query($queryp); if($debug){echo "$queryp \n\n"; echo $dbnivel->error();};
while ($row = $dbnivel->fetchassoc()){$point=$row['point'];};

if (!$dbnivel->close()){die($dbnivel->error());};


$valores[1]="$point de $total";
$valores[2]=$total;
$valores[3]=$point;
$valores[4]=$total - $point;

echo json_encode($valores);
?>