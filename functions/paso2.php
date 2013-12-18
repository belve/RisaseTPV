<?php
require_once("../db.php");

$dbnivelAPP=new DB('192.168.1.11','tpv','tpv','risase');
$dbnivelBAK=new DB('192.168.1.11','tpv','tpv','tpv_backup');
$dbnivel=new DB('localhost','tpv','tpv','RisaseTPV');



if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "select var, value from config";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$config = "\$" . $row['var'] . "='" . $row['value'] . "';";
eval($config);
}
if (!$dbnivel->close()){die($dbnivel->error());};


$hoy=date('Y') . "-" . date('m') . "-" . date('d');



if (!$dbnivelAPP->open()){die($dbnivelAPP->error());};
$queryp= "select max(fecha) as f from tickets where id_tienda=$id_tienda;";
$dbnivelAPP->query($queryp);
while ($row = $dbnivelAPP->fetchassoc()){$mf=$row['f'];};



$fecha = new DateTime($mf);
$fecha->sub(new DateInterval('P35D'));
$topf= $fecha->format('Y-m-d');

$queryp= "select min(id) as m from tickets where id_tienda=$id_tienda and fecha > '$topf';";
$dbnivelAPP->query($queryp);
while ($row = $dbnivelAPP->fetchassoc()){$minid=$row['m'];};

echo "importando desde ticket id: " . $minid;

$insT="INSERT INTO dev_tickets (id_tienda,id_ticket,id_empleado,fecha,importe,descuento) VALUES "; $cc=0;
$queryp= "select * from tickets where id_tienda=$id_tienda and id >= $minid;";
$dbnivelAPP->query($queryp);
while ($row = $dbnivelAPP->fetchassoc()){
$id_ticket=$row['id_ticket'];	
$id_empleado=$row['id_empleado'];
$fecha=$row['fecha'];
$importe=$row['importe'];
$descuento=$row['descuento'];

$insT.="($id_tienda,'$id_ticket',$id_empleado,'$fecha','$importe','$descuento'),";
$cc++;	
};
$insT=substr($insT, 0,-1) . ";";



$insTD="INSERT INTO dev_ticket_det (id_tienda,id_ticket,id_articulo,cantidad,importe) VALUES "; $ccD=0;
$queryp= "select * from ticket_det where id_tienda=$id_tienda and idt >= $minid;";
$dbnivelAPP->query($queryp);
while ($row = $dbnivelAPP->fetchassoc()){
$id_ticket=$row['id_ticket'];	
$id_articulo=$row['id_articulo'];
$cantidad=$row['cantidad'];
$importe=$row['importe'];


$insTD.="($id_tienda,'$id_ticket',$id_articulo,'$cantidad','$importe'),";
$ccD++;	
};
$insTD=substr($insTD, 0,-1) . ";";


$qreb="";
$queryp= "select id, tiendas from rebajas;";
$dbnivelAPP->query($queryp);
while ($row = $dbnivelAPP->fetchassoc()){
$id=$row['id']; $tiends=$row['tiendas']; $ati=explode(' ',$tiends);
foreach ($ati as $key => $itt) {if($itt==$id_tienda){$qreb.=$id . ",";}};		
}

$qreb=substr($qreb, 0,-1);
echo "<br>___________________<br>";
echo "importo rebajas: $qreb";

$ccRE=0;
if($qreb){
$insRE="INSERT INTO det_rebaja (id_rebaja,id_articulo,precio,fecha_ini,fecha_fin) VALUES "; $ccD=0;	
$queryp= "select * from det_rebaja where id_rebaja IN ($qreb);";
$dbnivelAPP->query($queryp);
while ($row = $dbnivelAPP->fetchassoc()){
$id_rebaja=$row['id_rebaja'];	
$id_articulo=$row['id_articulo'];
$precio=$row['precio'];
$fecha_ini=$row['fecha_ini'];
$fecha_fin=$row['fecha_fin'];

$insRE.="($id_rebaja,'$id_articulo','$precio','$fecha_ini','$fecha_fin'),";
$ccRE++;	

}	
$insRE=substr($insRE, 0,-1) . ";";	
}




if (!$dbnivelAPP->close()){die($dbnivelAPP->error());};







if (!$dbnivel->open()){die($dbnivel->error());};


echo "<br>___________________<br>";
$dbnivel->query($insT); echo "Insertados $cc tickets. <br>";

$dbnivel->query($insTD); echo "Insertados $ccD Detalles de ticket. <br>";

if($qreb){$dbnivel->query($insRE); echo "Insertados $ccRE Detalles de rebajas. <br>";}

if (!$dbnivel->close()){die($dbnivel->error());};





echo "<br>___________________<br>";
echo "PVP fijo se importa en la proxima sincro";
?>