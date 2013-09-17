<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");
require_once("../functions/sync.php");
require_once("../functions/print.php");

if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "select var, value from config";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$config = "\$" . $row['var'] . "='" . $row['value'] . "';";   eval($config);};


$detalle=$_GET['detROT'];



if(count($detalle)>0){
foreach ($detalle as $key => $values) {foreach ($values as $codbarras => $val){
$qty=$val['q'];$mod=$val['m'];
	
$print[$mod][substr($codbarras, 0,1)][substr($codbarras, 1,1)][substr($codbarras, 3,strlen($codbarras)-4)]['q']=$qty;	
$print[$mod][substr($codbarras, 0,1)][substr($codbarras, 1,1)][substr($codbarras, 3,strlen($codbarras)-4)]['c']=$codbarras;
	
$queryp= "INSERT INTO roturas (codbarras,qty,modo) values ('$codbarras','$qty','$mod');";
$dbnivel->query($queryp);	

$queryp= "UPDATE stocklocal SET stock=stock - $qty where cod=$codbarras;";
$dbnivel->query($queryp);	$tosync[]=$queryp;
	

		
}}}

p_roturas($print,$id_nom_tienda);


if (!$dbnivel->close()){die($dbnivel->error());};

if(count($tosync)>0){foreach ($tosync as $point => $sql){
SyncModBD($sql,$id_tienda);
}}
#echo json_encode($datos);

?>

