<?php

if (!$dbnivelAPP->open()){die($dbnivelAPP->error()); $noconectado=1;};

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
$dbnivel->query($queryp);
}else{
$queryp= "INSERT INTO stocklocal (cod,alarma,stock) VALUES ($cod,$alar,0);";
$dbnivel->query($queryp);	
}

}}

if (!$dbnivel->close()){die($dbnivel->error());};






if (!$dbnivelAPP->open()){die($dbnivelAPP->error()); $noconectado=1;};

if(count($queryshechas)>0){foreach ($queryshechas as $idhecho => $nada) {
$queryp= "delete from syncupdate where id=$idhecho;";
$dbnivelAPP->query($queryp);
}}






if (!$dbnivelAPP->close()){die($dbnivelAPP->error());};



?>