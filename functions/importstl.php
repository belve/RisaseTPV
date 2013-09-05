<?php



$point=0;
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

require_once("../db.php");
require_once("../variables.php");




if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "SELECT max(id) as point from stocklocal;";
$dbnivel->query($queryp);echo $dbnivel->error();
while ($row = $dbnivel->fetchassoc()){$point=$row['point'];};
if (!$dbnivel->close()){die($dbnivel->error());};
$point++;



if (!$dbnivelBAK->open()){die($dbnivelBAK->error());};




$queryp= "select count(id) as total from stocklocal_$idt;";
$dbnivelBAK->query($queryp);
while ($row = $dbnivelBAK->fetchassoc()){$total=$row['total'];};


if($point < $total){
	
$values="";
$queryp= "select * from stocklocal_$idt where id >= $point limit 500;";
$dbnivelBAK->query($queryp);
while ($row = $dbnivelBAK->fetchassoc()){


$cod=addslashes($row['cod']);                     
$stock=addslashes($row['stock']);           
$alarma=addslashes($row['alarma']);            
$pvp=addslashes($row['pvp']);


$values .="('$cod','$stock','$alarma','$pvp'),";
	
}
}
$values=substr($values, 0,strlen($values)-1);

if (!$dbnivelBAK->close()){die($dbnivelBAK->error());};



if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "INSERT INTO stocklocal (cod,stock,alarma,pvp) VALUES $values;";
$dbnivel->query($queryp);


$queryp= "SELECT max(id) as point from stocklocal;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$point=$row['point'];};

if (!$dbnivel->close()){die($dbnivel->error());};


$valores[1]="$point de $total";
$valores[2]=$total;
$valores[3]=$point;
$valores[4]=$total - $point;

echo json_encode($valores);
?>