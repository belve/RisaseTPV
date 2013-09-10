<?php
$valores=array();$id="";$valores['opciones']="";

foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "select 
(select nombre from proveedores where proveedores.id=articulos.id_proveedor) as proveedor, 
refprov, 
(select stock from stocklocal where cod=articulos.codbarras) as stock, 
(select alarma from stocklocal where cod=articulos.codbarras) as uniminimas, 
temporada, 
preciocosto, 
precioneto, 
preciofran, 
pvp,
detalles,
comentarios, 
congelado, 
codbarras, 
id, 
(select dto1 from proveedores where proveedores.id=articulos.id_proveedor) as dto1, 
(select dto2 from proveedores where proveedores.id=articulos.id_proveedor) as dto2, 
(select nombre from subgrupos where subgrupos.id=articulos.id_subgrupo) as subgru, 
(select nombre from colores where colores.id=articulos.id_color) as color, 
(select nombre from grupos where grupos.id = (select id_grupo from subgrupos where subgrupos.id=articulos.id_subgrupo)) as gru 
 from articulos where codbarras=$codbarras";



$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
	
	$valores[1]=$row['id'];$id=$row['id'];
	$valores[2]=$row['proveedor'];
	$valores[3]=$row['gru'];
	$valores[4]=$row['subgru'];
	$valores[5]=$row['color'];
	$valores[6]=$row['dto1'];
	$valores[7]=$row['dto2'];
	
	$valores[8]=$row['congelado'];
	
	$valores[9]=$row['refprov'];
	$valores[10]=$row['stock'];
	$valores[11]=$row['uniminimas'];
	$valores[12]=$row['temporada'];
	$valores[13]=$row['preciocosto'];
	$valores[14]=$row['precioneto'];
	$valores[15]=$row['preciofran'];
	$valores[16]=$row['pvp'];
	$valores[18]=$row['detalles'];
	$valores[19]=$row['comentarios'];
	
};


$queryp= "select pvp from stocklocal where cod=$codbarras;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
if($row['pvp']>0) $valores[16]=$row['pvp'];	
};

if($id){
	
$queryp= "select pvp from rebajas where id_articulo=$id AND fecha_ini <= '$hoy' AND fecha_fin >= '$hoy';";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
if($row['pvp']>0) $valores[16]=$row['pvp'];	
}






$file = fopen ("http://192.168.1.11/ajax/getimage.php?codbarras=$codbarras", "r");
while (!feof ($file)) { $fotos = fgets ($file, 1024);};
fclose($file);

$afotos=json_decode($fotos);

if(array_key_exists(0, $afotos)){
$valores['foto']=str_replace($pathimages, $urlimages, $afotos[0]);
}else{
$valores['foto']= $urlimages . "nodisp.jpg";	
}


if(count($afotos)>0){foreach($afotos as $noot => $fot){
$valores['opciones'].="$fot <br>";
	
}}

}else{
$valores['error']=1;
}

if (!$dbnivel->close()){die($dbnivel->error());};



echo json_encode($valores);

?>