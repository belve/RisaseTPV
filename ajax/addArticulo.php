<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");

$manual=str_replace('-','',$manual);$id=0;$datos=array();

if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "select id, codbarras, refprov, pvp from articulos where codbarras=$cod;";
$codbarras="";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$codbarras=$row['codbarras'];	$refprov=$row['refprov']; $pvp=$row['pvp']; $id=$row['id'];
$datos['console'] ="PVP general: $pvp \n";	
};

$queryp= "select pvp from pvp_fijo where id_articulo=$id;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
if($row['pvp']>0) $pvp=$row['pvp'];	
$datos['console'] .="PVP Fijado: $pvp \n";		
};


$queryp= "select precio from det_rebaja where id_articulo=$id AND fecha_ini <= '$hoy' AND fecha_fin >= '$hoy';";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
if($row['precio']>0) $pvp=$row['precio'];	
$datos['console'] .="PVP Rebaja: $pvp \n";	

};

if($mod==1){$sumo=-1;}else{$sumo=1;};


if($manual>0){$manual=str_replace(',','.',$manual);$pvp=$manual;};

if($codbarras){$datos['d']="<>$codbarras|$refprov|$sumo|$pvp";}else{$datos['error']="error";};



if (!$dbnivel->close()){die($dbnivel->error());};


echo json_encode($datos);

?>

