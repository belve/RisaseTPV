<?php

require_once("../db.php");
require_once("../variables.php");
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$id="";
if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "select id_ticket from dev_tickets WHERE id_ticket='$idt';";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$id=$row['id_ticket'];	
}

if($id){
$v['ok']=$id;
}else{
$v['no']=1;	
}

if (!$dbnivel->close()){die($dbnivel->error());};

echo json_encode($v);

?>
