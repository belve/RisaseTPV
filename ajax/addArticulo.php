<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");



if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "select id, codbarras, refprov, pvp from articulos where codbarras=$cod;";
$codbarras="";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$codbarras=$row['codbarras'];	$refprov=$row['refprov']; $pvp=$row['pvp']; $id=$row['id'];
	
};

$queryp= "select pvp from stocklocal where cod=$cod;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
if($row['pvp']>0) $pvp=$row['pvp'];	
};


$queryp= "select pvp from rebajas where id_articulo=$id AND fecha_ini <= '$hoy' AND fecha_fin >= '$hoy';";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
if($row['pvp']>0) $pvp=$row['pvp'];	
};



if($codbarras){$datos[]="<>$codbarras|$refprov|1|$pvp";}else{$datos[]="error";};



if (!$dbnivel->close()){die($dbnivel->error());};


echo json_encode($datos);

?>

