<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>


<title>importador</title>







</head>

<body>

<?php
require_once("../db.php");
require_once("../variables.php");


$lineas=file("../sql/createDB.sql");


$content="";
foreach ($lineas as $nl => $value) {$content.=$value;};
$lines=explode(';',$content);

$conDB=mysqli_connect("localhost","root","");
foreach ($lines as $l => $queryp) {
mysqli_query($conDB,$queryp . ";");	
}

$tienda="";
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

if($tienda!=""){

if (!$dbnivelAPP->open()){die($dbnivelAPP->error());};


$queryp= "select id from tiendas where id_tienda = '$tienda';";
$dbnivelAPP->query($queryp);
while ($row = $dbnivelAPP->fetchassoc()){$idt=$row['id'];};

$queryp= "select * from colores;";
$dbnivelAPP->query($queryp);$colstr="";
while ($row = $dbnivelAPP->fetchassoc()){
$cid=$row['id'];$cnom=$row['nombre'];	
$colstr .= "('$cid','$cnom'),";};
$colstr=substr($colstr, 0,strlen($colstr)-1);	

$queryp= "select * from grupos;";
$dbnivelAPP->query($queryp);$grustr="";
while ($row = $dbnivelAPP->fetchassoc()){
$cid=$row['id'];$cnom=$row['nombre'];	
$grustr .= "('$cid','$cnom'),";};
$grustr=substr($grustr, 0,strlen($grustr)-1);	

$queryp= "select * from subgrupos;";
$dbnivelAPP->query($queryp);$sgrustr="";
while ($row = $dbnivelAPP->fetchassoc()){
$cid=$row['id'];$cnom=$row['nombre'];$cids=$row['id_grupo'];$ccla=$row['clave'];	
$sgrustr .= "('$cid','$cids','$cnom','$ccla'),";};
$sgrustr=substr($sgrustr, 0,strlen($sgrustr)-1);



$queryp= "select * from empleados where id_tienda='$tienda';";
$dbnivelAPP->query($queryp);$empstr="";
while ($row = $dbnivelAPP->fetchassoc()){
$eid=$row['id'];$enom=$row['nombre'];$eap1=$row['apellido1'];$eap2=$row['apellido2'];$etrab=$row['trabajando'];$eord=$row['orden'];	
$empstr .= "('$eid','$tienda','$enom','$eap1','$eap2','$etrab','$eord'),";};
$empstr=substr($empstr, 0,strlen($empstr)-1);



$queryp= "select * from proveedores;";
$dbnivelAPP->query($queryp);$prov="";
while ($row = $dbnivelAPP->fetchassoc()){
$eid=$row['id'];$enom=$row['nombre'];$cif=$row['cif'];
$direccion=$row['direccion'];$cp=$row['cp'];
$poblacion=$row['poblacion'];
	
$provincia=$row['provincia'];	
$contacto=$row['contacto'];	
$telefono=$row['telefono'];	
$fax=$row['fax'];	
$email=$row['email'];	
$dto1=$row['dto1'];	
$dto2=$row['dto2'];	
$iva=$row['iva'];	
$nomcorto=$row['nomcorto'];	


$prov .= "('$eid','$enom','$cif','$direccion','$cp','$poblacion','$provincia','$contacto','$telefono','$fax','$email','$dto1','$dto2','$iva','$nomcorto'),";};
$prov=substr($prov, 0,strlen($prov)-1);




if (!$dbnivelAPP->close()){die($dbnivelAPP->error());};


echo "<div>idt: $idt </div>";

if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "INSERT INTO colores (id,nombre) VALUES $colstr;";
$dbnivel->query($queryp);
echo "<div>Tabla:\t\t Colores \t\t 100%</div>";

$queryp= "INSERT INTO grupos (id,nombre) VALUES $grustr;";
$dbnivel->query($queryp);
echo "<div>Tabla:\t\t Grupos \t\t 100%</div>";

$queryp= "INSERT INTO subgrupos (id,id_grupo,nombre,clave) VALUES $sgrustr;";
$dbnivel->query($queryp);
echo "<div>Tabla:\t\t Subgrupos \t\t 100%</div>";

$queryp= "INSERT INTO empleados (id,id_tienda,nombre,apellido1,apellido2,trabajando,orden) VALUES $empstr;";
$dbnivel->query($queryp);
echo "<div>Tabla:\t\t Empleados \t\t 100%</div>";


$queryp= "INSERT INTO proveedores (id,nombre,cif,direccion,cp,poblacion,provincia,contacto,telefono,fax,email,dto1,dto2,iva,nomcorto) VALUES $prov;";
$dbnivel->query($queryp);
echo "<div>Tabla:\t\t Proveedores \t\t 100%</div>";



if (!$dbnivel->close()){die($dbnivel->error());};


include ('impstock.php');

}



?>


<div>Tabla: Articulos <div id="art"></div></div>




<script>





function artic(){
var func='artic();'
$.ajaxSetup({'async': false});
$.getJSON('importart.php', function(data) {
$.each(data, function(key, val) {
if(key==1){
document.getElementById('art').innerHTML=val;
}	
if(key==2){var tot=val; tot++;};

if(key==4){if(val=='fin'){
var func='mdb();'
	}
}

});
});

setTimeout(func, 3000); 	
}



function mdb(){
	
}


artic();

	
</script>


</body>
</html>
