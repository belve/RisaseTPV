<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");



if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "select codbarras, refprov, pvp from articulos where codbarras=$cod;";
$codbarras="";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$codbarras=$row['codbarras'];	$refprov=$row['refprov']; $pvp=$row['pvp'];
	
};
if($codbarras){$datos[]="<>$codbarras|$refprov|1|$pvp";}else{$datos[]="error";};



if (!$dbnivel->close()){die($dbnivel->error());};


echo json_encode($datos);

?>

