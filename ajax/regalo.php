<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");

require_once("../functions/print.php");

if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "select ciudad, direccion from tiendas where id=$id_tienda;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$nt=$row['ciudad']; $dr=$row['direccion'];};


$queryp= "select id_articulo, 
cantidad, 
(select nombre from subgrupos where id_grupo = (substring(id_articulo,1,1)) AND clave=(substring(id_articulo,2,1)) ) as ngru
 from dev_ticket_det where id_ticket='$t' AND cantidad > 0;"; 
$dbnivel->query($queryp);$point=0;
while ($row = $dbnivel->fetchassoc()){$point++;

$idart=$row['id_articulo'];  $ngru=$row['ngru']; $qty=$row['cantidad']; 

if($ngru==""){$ngru="GENERICO";};


$tifprint[$point][$idart]['n']=$ngru;
$tifprint[$point][$idart]['q']=$qty;
$tifprint[$point][$idart]['p']='';
$tifprint[$point][$idart]['t']='';
$tifprint[$point][$idart]['d']='';	
	
	
};







ticketRegalo($tifprint,$nt,$dr,$id_tienda,$t);

if (!$dbnivel->close()){die($dbnivel->error());};

?>
