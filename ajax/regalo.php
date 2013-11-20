<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");

require_once("../functions/print.php");

if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "select ciudad, direccion from tiendas where id=$id_tienda;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$nt=$row['ciudad']; $dr=$row['direccion'];};

ticketRegalo($nt,$dr,$id_tienda,$t);

if (!$dbnivel->close()){die($dbnivel->error());};

?>
