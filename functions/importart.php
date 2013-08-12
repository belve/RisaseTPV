<?php

$point=0;
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

require_once("../db.php");
require_once("../variables.php");

if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "SELECT max(id) as point from articulos;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$point=$row['point'];};
if (!$dbnivel->close()){die($dbnivel->error());};
$point++;



if (!$dbnivelAPP->open()){die($dbnivelAPP->error());};




$queryp= "select count(id) as total from articulos;";
$dbnivelAPP->query($queryp);
while ($row = $dbnivelAPP->fetchassoc()){$total=$row['total'];};


if($point < $total){
	
$values="";
$queryp= "select * from articulos where id >= $point limit 500;";
$dbnivelAPP->query($queryp);
while ($row = $dbnivelAPP->fetchassoc()){


$id=addslashes($row['id']);                     
$id_proveedor=addslashes($row['id_proveedor']);           
$id_subgrupo=addslashes($row['id_subgrupo']);            
$id_color=addslashes($row['id_color']);               
$codigo=addslashes($row['codigo']);                 
$refprov=addslashes($row['refprov']);                
$foto=addslashes($row['foto']);                   
$stock=addslashes($row['stock']);                  
$uniminimas=addslashes($row['uniminimas']);             
$codbarras=addslashes($row['codbarras']);              
$temporada=addslashes($row['temporada']);         
$preciocosto=addslashes($row['preciocosto']);         
$precioneto=addslashes($row['precioneto']);         
$preciofran=addslashes($row['preciofran']);         
$detalles=addslashes($row['detalles']);           
$comentarios=addslashes($row['comentarios']);         
$pvp=addslashes($row['pvp']);                 
$congelado=addslashes($row['congelado']);           
$stockini=addslashes($row['stockini']);  	

$values .="('$id','$id_proveedor','$id_subgrupo','$id_color','$codigo','$refprov','$foto','$stock','$uniminimas','$codbarras','$temporada','$preciocosto','$precioneto','$preciofran','$detalles','$comentarios','$pvp','$congelado','$stockini'),";
	
}
}
$values=substr($values, 0,strlen($values)-1);


if (!$dbnivelAPP->close()){die($dbnivelAPP->error());};



if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "INSERT INTO articulos (id,id_proveedor,id_subgrupo,id_color,codigo,refprov,foto,stock,uniminimas,codbarras,temporada,preciocosto,precioneto,preciofran,detalles,comentarios,pvp,congelado,stockini) VALUES $values;";
$dbnivel->query($queryp);

$queryp= "SELECT max(id) as point from articulos;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$point=$row['point'];};

if (!$dbnivel->close()){die($dbnivel->error());};


$valores[1]="$point de $total";
$valores[2]=$total;
$valores[3]=$point;

echo json_encode($valores);
?>