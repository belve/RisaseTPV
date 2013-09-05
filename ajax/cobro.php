<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");
require_once("../functions/sync.php");

if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "select var, value from config";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$config = "\$" . $row['var'] . "='" . $row['value'] . "';";   eval($config);};


$detalle=$_GET['detTick'];
$idemp=$_GET['emp'];
$total=$_GET['total'];
$desc=$_GET['desc'];
$tosync=array();

$fecha=date('Y') . "-" . date('m') . "-" . date('d');




$idt=$id_nom_tienda . date('d') . date('m') . date('y') . date('G') . date('i') . date('s');

$queryp= "INSERT INTO tickets (id_ticket,id_tienda,id_empleado,fecha,importe,descuento) values ('$idt', '$id_tienda', '$idemp', '$fecha', '$total','$desc');";
$dbnivel->query($queryp);

foreach ($detalle as $point => $dets){foreach($dets as $idart => $values) {
	
$check="";$codba="";



$queryp= "select cod from stocklocal where cod = $idart;";
$dbnivel->query($queryp); echo $queryp;
while ($row = $dbnivel->fetchassoc()){$check=$row['cod'];};

if(!$check){
$queryp= "INSERT INTO stocklocal (cod,stock,alarma) values ($idart,0,0);";
$dbnivel->query($queryp); echo $queryp;	$tosync[]=$queryp;
}
	
$qty=$values['q']; $pvp=$values['p'];	
$queryp= "INSERT INTO ticket_det (id_ticket,id_tienda,id_articulo,cantidad,importe) values ('$idt', '$id_tienda', '$idart', '$qty', '$pvp');";
$dbnivel->query($queryp);
	
}}





if (!$dbnivel->close()){die($dbnivel->error());};

if(count($tosync)>0){foreach ($tosync as $point => $sql){
SyncModBD($sql,$id_tienda);
}}
#echo json_encode($datos);

?>

