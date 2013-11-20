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


$detalle=$_GET['detTick'];
$idemp=$_GET['emp'];
$total=$_GET['total'];
$desc=$_GET['desc'];
$tosync=array();

$fecha=date('Y') . "-" . date('m') . "-" . date('d');




$idt=$id_nom_tienda . date('d') . date('m') . date('y') . date('G') . date('i') . date('s');

$queryp= "INSERT INTO tickets (id_ticket,id_tienda,id_empleado,fecha,importe,descuento) values ('$idt', '$id_tienda', '$idemp', '$fecha', '$total','$desc');";
$dbnivel->query($queryp);

$queryp= "INSERT INTO caja (id_empleado,fecha,importe) values ('$idemp', '$fecha', '$total');";
$dbnivel->query($queryp);


foreach ($detalle as $point => $dets){foreach($dets as $idart => $values) {
	
$check="";$codba="";



$queryp= "select cod from stocklocal where cod = $idart;";
$dbnivel->query($queryp); echo $queryp;
while ($row = $dbnivel->fetchassoc()){$check=$row['cod'];};

if(!$check){
	
$queryp= "select id, codbarras from articulos where codbarras = $idart;";
$dbnivel->query($queryp); echo $queryp;
while ($row = $dbnivel->fetchassoc()){$cbc=$row['codbarras'];$idc=$row['id'];};		
	
$queryp= "INSERT INTO stocklocal (id_art,cod,stock,alarma) values ($idc,$cbc,0,0);";
$dbnivel->query($queryp); echo $queryp;	$tosync[]=$queryp;
}
	
$qty=$values['q']; $pvp=$values['p'];	
$queryp= "INSERT INTO ticket_det (id_ticket,id_tienda,id_articulo,cantidad,importe) values ('$idt', '$id_tienda', '$idart', '$qty', '$pvp');";
$dbnivel->query($queryp);

$grup=substr($idart, 0,1);
$subgru=substr($idart, 1,1);

$queryp= "select nombre from subgrupos where id_grupo = $grup AND clave=$subgru;";
$dbnivel->query($queryp); echo $queryp;
while ($row = $dbnivel->fetchassoc()){$ngru=$row['nombre'];};

global $id_tienda;
$tifprint[$point][$idart]['n']=$ngru;
$tifprint[$point][$idart]['q']=$qty;
$tifprint[$point][$idart]['p']=$pvp;
$tifprint[$point][$idart]['t']=$total;
$tifprint[$point][$idart]['d']=$desc;
}}




$queryp= "select ciudad, direccion from tiendas where id=$id_tienda;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$nt=$row['ciudad']; $dr=$row['direccion'];};

ticket($tifprint,$nt,$dr,$id_tienda,$idt);

if (!$dbnivel->close()){die($dbnivel->error());};

if(count($tosync)>0){foreach ($tosync as $point => $sql){
SyncModBD($sql,$id_tienda);
}}




?>

