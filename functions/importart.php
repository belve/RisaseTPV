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
$queryp= "select * from articulos where id >= $point limit 100;";
$dbnivelAPP->query($queryp);
while ($row = $dbnivelAPP->fetchassoc()){


$id=$row['id'];                     
$id_proveedor=$row['id_proveedor'];           
$id_subgrupo=$row['id_subgrupo'];            
$id_color=$row['id_color'];               
$codigo=$row['codigo'];                 
$refprov=$row['refprov'];                
$foto=$row['foto'];                   
$stock=$row['stock'];                  
$uniminimas=$row['uniminimas'];             
$codbarras=$row['codbarras'];              
$temporada=$row['temporada'];         
$preciocosto=$row['preciocosto'];         
$precioneto=$row['precioneto'];         
$preciofran=$row['preciofran'];         
$detalles=$row['detalles'];           
$comentarios=$row['comentarios'];         
$pvp=$row['pvp'];                 
$congelado=$row['congelado'];           
$stockini=$row['stockini'];  	

$values .="('$id','$id_proveedor','$id_subgrupo','$id_color','$codigo','$refprov','$foto','$stock','$uniminimas','$codbarras','$temporada','$preciocosto','$precioneto','$preciofran','$detalles','$comentarios','$pvp','$congelado','$stockini'),";
	
}
}
$values=substr($values, 0,strlen($values)-1);


if (!$dbnivelAPP->close()){die($dbnivelAPP->error());};



if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "INSERT INTO articulos (id,id_proveedor,id_subgrupo,id_color,codigo,refprov,foto,stock,uniminimas,codbarras,temporada,preciocosto,precioneto,preciofran,detalles,comentarios,pvp,congelado,stockini) VALUES $values;";
$dbnivel->query($queryp);echo $queryp;

$queryp= "SELECT max(id) as point from articulos;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$point=$row['point'];};

if (!$dbnivel->close()){die($dbnivel->error());};


$valores[1]="$point de $total";
$valores[2]=$total;
$valores[3]=$point;

echo json_encode($valores);
?>