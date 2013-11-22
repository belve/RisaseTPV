<?php

require_once("../db.php");
require_once("../variables.php");
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$html="";
if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "select id_ticket from dev_tickets WHERE id_empleado=$idemp order by id DESC limit 4;";
$dbnivel->query($queryp);$first=0;
while ($row = $dbnivel->fetchassoc()){ if(!$first){$col="orange";}else{$col="white";};
$id_ticket=$row['id_ticket'];

$html.="<div class='tforREL' id='$id_ticket' style='background-color: $col;' >$id_ticket</div>	";
$first++;

$v[$first]=$id_ticket;
};

$v['html']=$html;

if (!$dbnivel->close()){die($dbnivel->error());};

echo json_encode($v);

?>

