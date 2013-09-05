<?php

if (!$dbnivelAPP->open()){die($dbnivelAPP->error()); $noconectado=1;}; $hazpedidos=array();$tosync=array();$querys2=array();$querstldone=array();

$querys=array();$queryshechas=array(); $alarmas=array();
$queryp= "select * from syncupdate where id_tiend=$id_tienda;";
$dbnivelAPP->query($queryp);
while ($row = $dbnivelAPP->fetchassoc()){
$querys[$row['id']]=$row['syncSql'];	
}


$queryp= "select id, stockmin, id_articulo, cantidad, (select codbarras from articulos where id=id_articulo) as cod from repartir where id_tienda=$id_tienda AND estado='P';";
$dbnivelAPP->query($queryp);
while ($row = $dbnivelAPP->fetchassoc()){
$alarmas[$row['cod']]=$row['stockmin'];	
$qants[$row['cod']]=$row['cantidad'];	
}

$queryp= "UPDATE repartir SET estado='F' where id_tienda=$id_tienda AND estado='P';";
$dbnivelAPP->query($queryp);


if (!$dbnivelAPP->close()){die($dbnivelAPP->error());};





if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "select * from syncupdate;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$querys2[$row['id']]=$row['syncSql'];	
}



if(count($querys)>0){foreach ($querys as $id => $queryp) {
$dbnivel->query($queryp);
if(strlen($dbnivel->error())==0){$queryshechas[$id]=1;};
}}



if(count($alarmas)>0){foreach ($alarmas as $cod => $alar) {

$id="";
$queryp= "select id from stocklocal where cod=$cod;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$id=$row['id'];};

if($id){
$queryp= "update stocklocal set alarma=$alar where cod=$cod;";
$dbnivel->query($queryp);$tosync[]=$queryp;
}else{
$queryp= "INSERT INTO stocklocal (cod,alarma,stock) VALUES ($cod,$alar,0);";
$dbnivel->query($queryp);	$tosync[]=$queryp;
}

}}


$queryp= "select cod from stocklocal where stock <= alarma and cod not in(select distinct codbarras from pedidos);";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$hazpedidos[$row['cod']]=1;};

if(count($hazpedidos)>0){foreach($hazpedidos as $codapedir => $point){
$queryp= "INSERT INTO pedidos (codbarras) VALUES ($codapedir);";
$dbnivel->query($queryp);	
}}



if (!$dbnivel->close()){die($dbnivel->error());};




if (!$dbnivelBAK->open()){die($dbnivelBAK->error());};
if(count($querys2)>0){foreach($querys2 as $idstl => $quer){
$dbnivelBAK->query($quer);		
if(strlen($dbnivelBAK->error())==0){$querstldone[$idstl]=1;};	
}}

if (!$dbnivelBAK->close()){die($dbnivelBAK->error());};



if (!$dbnivel->open()){die($dbnivel->error());};
if(count($querstldone)>0){foreach($querstldone as $idhecho => $pont){
$queryp= "delete from syncupdate where id=$idhecho;";
$dbnivel->query($queryp);	
}}
if (!$dbnivel->close()){die($dbnivel->error());};




if (!$dbnivelAPP->open()){die($dbnivelAPP->error()); $noconectado=1;};





if(count($queryshechas)>0){foreach ($queryshechas as $idhecho => $nada) {
$queryp= "delete from syncupdate where id=$idhecho;";
$dbnivelAPP->query($queryp);
}}






if (!$dbnivelAPP->close()){die($dbnivelAPP->error());};

if(count($tosync)>0){foreach ($tosync as $point => $sql){
SyncModBD($sql,$id_tienda);
}}


?>