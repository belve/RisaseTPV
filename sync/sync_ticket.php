<?php

if($debug){echo "ticket ________________________- \n\n";};

$art="";$restos=array();$tickets=array();$pedir=array();$noconectado=0;$tickdone=array();$articulos=array();$tosync=array();

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

if($debug){echo "$queryp \n Tickets:\n"; print_r($tickets);};

$queryp= "select id_ticket, id_articulo, cantidad, importe, (select id from articulos where codbarras=id_articulo) as idart FROM ticket_det;";
$dbnivel->query($queryp);$count=0;if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){$count++;
$tickets[$row['id_ticket']]['det'][$count][$row['id_articulo']]['qty']=$row['cantidad'];
$tickets[$row['id_ticket']]['det'][$count][$row['id_articulo']]['imp']=$row['importe'];
$art .=$row['id_articulo'] . ",";

$idartis2[$row['id_articulo']]=$row['idart'];

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
if($debug){echo "$queryp \n Tickets:\n"; print_r($tickets); echo "\n Articulos:\n";print_r($articulos);};





if (!$dbnivel->close()){die($dbnivel->error());};







#comunicacion con central
if (!$dbnivelAPP->open()){die($dbnivelAPP->error()); $noconectado=1;};

foreach ($tickets as $cticket => $valores){

$id_tienda=$valores['idt']; $id_empleado=$valores['emp']; $fecha=$valores['dat']; $importe=$valores['imp']; $desc=$valores['des'];

if(is_numeric(substr($cticket,3,1))){$spos=0;}else{$spos=1;};
$hora=substr($cticket, (9+$spos), 2);

$queryp= "insert into tickets (id_tienda, id_ticket, id_empleado, fecha, hora, importe, descuento) values ('$id_tienda', '$cticket', '$id_empleado', '$fecha', '$hora', '$importe', '$desc');";
$dbnivelAPP->query($queryp);if($debug){echo "$queryp \n\n";};
$queryp="SELECT LAST_INSERT_ID() as lid;";
$dbnivelAPP->query($queryp);
while ($row = $dbnivelAPP->fetchassoc()){$lastid=$row['lid'];};
if($debug){echo "$queryp \n lastid: $lastid\n";};

$queryp="select id_ticket from tickets where id = $lastid;";
$dbnivelAPP->query($queryp);
while ($row = $dbnivelAPP->fetchassoc()){$tickdone[$row['id_ticket']]=$lastid;};
}
if($debug){echo "$queryp \n $tickdone:\n"; print_r($tickdone);};



if(count($tickdone)>0){
foreach ($tickdone as $idhecho => $idti){
foreach ($tickets[$idhecho]['det'] as $pint => $detallin){foreach($detallin as $codidbar => $datos){

$catidad=$datos['qty'];
$importe=$datos['imp'];

if(is_numeric(substr($idhecho,3,1))){$spos=0;}else{$spos=1;};
$hora=substr($idhecho, (9+$spos), 2);
$g=substr($codidbar, 0,1);
$sg=substr($codidbar, 1,1);
		
$queryp= "insert into ticket_det (id_tienda, idt, id_ticket, id_articulo, g, sg, cantidad, importe, fecha, hora) values ('$id_tienda', $idti, '$idhecho', '$codidbar', $g, $sg, '$catidad', '$importe', '$fecha', '$hora');";
$dbnivelAPP->query($queryp);if($debug){echo "$queryp \n\n";};
		
	
}}

}}






if (!$dbnivelAPP->close()){die($dbnivelAPP->error());};





if (!$dbnivel->open()){die($dbnivel->error());};


foreach ($restos as $codbar => $resto){

if(!array_key_exists($codbar, $articulos)){$articulos[$codbar]['s']=0;$articulos[$codbar]['a']=0;};	
	
if(($articulos[$codbar]['s'] - $resto <= $articulos[$codbar]['a'])&&($articulos[$codbar]['c']<1)){
$queryp= "insert into pedidos (codbarras) values ('$codbar');";
$dbnivel->query($queryp);	if($debug){echo "mete en tabla pedidos:$codbar  \n";}; if($debug){echo "$queryp \n";};	
} #genera pedido



$idstl="";
$queryp= "select id from stocklocal where cod=$codbar ";
$dbnivel->query($queryp);if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){$idstl=$row['id'];};

$idart2=$idartis2[$codbar];
		
if($idstl){			
$queryp= "update stocklocal set stock=stock - $resto where cod=$codbar;";
$dbnivel->query($queryp);	$tosync[]=$queryp;if($debug){echo "$queryp \n\n";};
}else{
$resto=$resto * (-1);
$queryp= "insert into stocklocal (id_art,cod,stock,alarma) values ('$idart2','$codbar','$resto','0');";
$dbnivel->query($queryp);	$tosync[]=$queryp;if($debug){echo "$queryp \n\n";};
}



}
	

	
foreach ($tickdone as $idhecho => $point){
	
$queryp= "delete from tickets where id_ticket='$idhecho';";
$dbnivel->query($queryp);	if($debug){echo "$queryp \n\n";};

$queryp= "delete from ticket_det where id_ticket='$idhecho';";
$dbnivel->query($queryp);	if($debug){echo "$queryp \n\n";};

echo "Procesado Ticket: $idhecho \n";
	
}
	
	

if (!$dbnivel->close()){die($dbnivel->error());};


if(count($tosync)>0){foreach ($tosync as $point => $sql){
SyncModBD($sql,$id_tienda);
}}


?>