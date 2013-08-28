<?php

$art="";$restos=array();$tickets=array();$pedir=array();$noconectado=0;$tickdone=array();$articulos=array();

if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "select * from tickets;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$tickets[$row['id_ticket']]['emp']=$row['id_empleado'];
$tickets[$row['id_ticket']]['dat']=$row['fecha'];
$tickets[$row['id_ticket']]['imp']=$row['importe'];	
$tickets[$row['id_ticket']]['idt']=$row['id_tienda'];
$tickets[$row['id_ticket']]['des']=$row['descuento'];	
};

$queryp= "select id_ticket, id_articulo, cantidad, importe FROM ticket_det;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$tickets[$row['id_ticket']]['det'][$row['id_articulo']]['qty']=$row['cantidad'];
$tickets[$row['id_ticket']]['det'][$row['id_articulo']]['imp']=$row['importe'];
$art .=$row['id_articulo'] . ",";

if(!array_key_exists($row['id_articulo'], $restos)){$restos[$row['id_articulo']]=0;};
$restos[$row['id_articulo']]=$restos[$row['id_articulo']] + $row['cantidad'];
};
$art=substr($art,0,strlen($art)-1);

$queryp= "select cod, stock, alarma, (select congelado from articulos where codbarras=cod) as congelado from stocklocal where cod IN ($art);";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$articulos[$row['cod']]['s']=$row['stock'];	
$articulos[$row['cod']]['a']=$row['alarma'];
$articulos[$row['cod']]['c']=$row['congelado'];
}






if (!$dbnivel->close()){die($dbnivel->error());};







#comunicacion con central
if (!$dbnivelAPP->open()){die($dbnivelAPP->error()); $noconectado=1;};

foreach ($tickets as $cticket => $valores){

$id_tienda=$valores['idt']; $id_empleado=$valores['emp']; $fecha=$valores['dat']; $importe=$valores['imp']; $desc=$valores['des'];

$queryp= "insert into tickets (id_tienda, id_ticket, id_empleado, fecha, importe, descuento) values ('$id_tienda', '$cticket', '$id_empleado', '$fecha', '$importe', '$desc');";
$dbnivelAPP->query($queryp);

$queryp="select id_ticket from tickets where id IN(SELECT LAST_INSERT_ID() from tickets);";
$dbnivelAPP->query($queryp);
while ($row = $dbnivelAPP->fetchassoc()){$tickdone[$row['id_ticket']]=1;};
}

if(count($tickdone)>0){
foreach ($tickdone as $idhecho => $point){
foreach ($tickets[$idhecho]['det'] as $codidbar => $datos){

$catidad=$datos['qty'];
$importe=$datos['imp'];
		
$queryp= "insert into ticket_det (id_tienda, id_ticket, id_articulo, cantidad, importe) values ('$id_tienda', '$idhecho', '$codidbar', '$catidad', '$importe');";
$dbnivelAPP->query($queryp);
		
	
}
}}






if (!$dbnivelAPP->close()){die($dbnivelAPP->error());};





if (!$dbnivel->open()){die($dbnivel->error());};


foreach ($restos as $codbar => $resto){

if(!array_key_exists($codbar, $articulos)){$articulos[$codbar]['s']=0;$articulos[$codbar]['a']=0;};	
	
if(($articulos[$codbar]['s'] - $resto <= $articulos[$codbar]['a'])&&($articulos[$codbar]['c']<1)){
$queryp= "insert into pedidos (codbarras) values ('$codbar');";
$dbnivel->query($queryp);		
} #genera pedido

$queryp= "update stocklocal set stock=stock - $resto where cod=$codbar;";
$dbnivel->query($queryp);
}
	

	
foreach ($tickdone as $idhecho => $point){
	
$queryp= "delete from tickets where id_ticket='$idhecho';";
$dbnivel->query($queryp);	

$queryp= "delete from ticket_det where id_ticket='$idhecho';";
$dbnivel->query($queryp);	

echo "Procesado Ticket: $idhecho <br>";
	
}
	
	

if (!$dbnivel->close()){die($dbnivel->error());};
?>