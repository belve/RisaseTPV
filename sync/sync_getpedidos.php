<?php

if($debug){echo "getpedidos ________________________- \n\n";}

if (!$dbnivelAPP->open()){die($dbnivelAPP->error()); $noconectado=1;};

$getped=array();$pedfin=array();

$queryp= "select id, id_articulo, cantidad, agrupar, tip, (select codbarras from articulos where id=id_articulo) as codbarras, (select stockmin from repartir where repartir.id_articulo=pedidos.id_articulo and id_tienda=$id_tienda order by id desc limit 1) as alm  from pedidos where id_tienda=$id_tienda AND estado='T';";
$dbnivelAPP->query($queryp);
while ($row = $dbnivelAPP->fetchassoc()){
$getped[$row['id']]['ida']=$row['id_articulo'];	
$getped[$row['id']]['qty']=$row['cantidad'];		
$getped[$row['id']]['agr']=$row['agrupar'];
$getped[$row['id']]['cod']=$row['codbarras'];
$getped[$row['id']]['tip']=$row['tip'];
$getped[$row['id']]['alm']=$row['alm'];
}

if($debug){echo "$queryp \n\n";};

if (!$dbnivelAPP->close()){die($dbnivelAPP->error());};





if (!$dbnivel->open()){die($dbnivel->error());};

if(count($getped)>0){
foreach ($getped as $id => $values) {

$ida=$values['ida']; $qty=$values['qty']; $alm=$values['alm']; $agr=$values['agr']; $cod=$values['cod']; $tip=$values['tip'];	

$qty=0; $alm=0;

$idstl="";
$queryp= "select id from stocklocal where cod=$cod ";
$dbnivel->query($queryp);if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){$idstl=$row['id'];};
		
if($idstl){			
$queryp= "update stocklocal set stock=stock+$qty, alarma=$alm where cod=$cod;";
$dbnivel->query($queryp);	$tosync[]=$queryp; if($debug){echo "$queryp \n\n";};
}else{
$queryp= "insert into stocklocal (id_art,cod,stock,alarma) values ('$ida','$cod','$qty','$alm');";
$dbnivel->query($queryp);	$tosync[]=$queryp; if($debug){echo "$queryp \n\n";};
}

$queryp= "delete from pedidos where codbarras=$cod;";
$dbnivel->query($queryp);if($debug){echo "$queryp \n\n";};

echo "Envio a tienda: $id .Recibido \n";

$pedfin[$id]=$agr;




}
}



echo "------ to sync ----- \n";
print_r($tosync);
echo "------ to sync ----- \n";






if (!$dbnivel->close()){die($dbnivel->error());};

if(count($tosync)>0){foreach ($tosync as $point => $sql){
SyncModBD($sql,$id_tienda);
}}$tosync=array();



if (!$dbnivelAPP->open()){die($dbnivelAPP->error()); $noconectado=1;};

if(count($pedfin)>0){
foreach ($pedfin as $idpedi => $idagru) {

$queryp= "UPDATE pedidos set estado='F' where id=$idpedi;";
$dbnivelAPP->query($queryp);if($debug){echo "$queryp \n\n";};

$pendientes=0;
$queryp= "select count(id) as pendientes from pedidos where estado not like 'F' and agrupar=$idagru;";
$dbnivelAPP->query($queryp);if($debug){echo "$queryp \n\n";};
while ($row = $dbnivelAPP->fetchassoc()){$pendientes=$row['pendientes']*1;};

if($pendientes==0){
$queryp= "UPDATE agrupedidos set estado='F' where id=$idagru;";
$dbnivelAPP->query($queryp);if($debug){echo "$queryp \n\n";};	
}

}
}
if (!$dbnivelAPP->close()){die($dbnivelAPP->error());};






?>