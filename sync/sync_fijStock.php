<?php



if($debug){echo "fijStock ________________________- \n\n";};


if (!$dbnivelAPP->open()){die($dbnivelAPP->error());};
$cuales="";$sloc=array();$cbr=array();$pas1=array();$pas2=array();
$fijos=array();
$bds=array();
$almacen=array();

$queryp= "select * from fij_stock WHERE id_tienda=$id_tienda AND bd < 2 limit 300;";
$dbnivelAPP->query($queryp);if($debug){echo "$queryp \n\n";};
while ($row = $dbnivelAPP->fetchassoc()){
$fijos[$row['id']]['ida']=$row['id_articulo'];
$fijos[$row['id']]['fij']=$row['fijo'];	
$fijos[$row['id']]['sum']=$row['suma'];	
$fijos[$row['id']]['alm']=$row['alm'];	
$fijos[$row['id']]['bd']=$row['bd'];		
$cuales.=$row['id_articulo'] . ",";

}
$cuales=substr($cuales, 0,-1);
if (!$dbnivelAPP->close()){die($dbnivelAPP->error());};



if(count($fijos)>0){

if($debug){echo "DATOS IMPORTADOS__ \$fijos __  \n"; print_r($fijos); echo "\n\n";};


if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "select codbarras, id,  (select id_art from stocklocal where id_art=articulos.id) as id_art, (select stock from stocklocal where id_art=articulos.id) as stock
 from articulos WHERE id IN ($cuales);";
$dbnivel->query($queryp);if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){
	
	$idaL=$row['id_art']; $stock=$row['stock'];
	if($idaL){	$sloc[$idaL]=$stock;}
				$cbr[$row['id']]=$row['codbarras'];
	
		
}
if($debug){echo "DATOS LOCALES__ \$sloc __  \n"; print_r($sloc); echo "\n\n"; };
if($debug){echo "DATOS LOCALES__ \$cbr __  \n"; print_r($cbr);  echo "\n\n"; };

$pas1=array();
if(count($fijos)>0){ foreach ($fijos as $idd => $arti) {$fij="";

$ida=$arti['ida']; $fij=$arti['fij']; $sum=$arti['sum']; $alm=$arti['alm']; $bd=$arti['bd'];	$idaL="";

if(!array_key_exists($ida, $sloc)){
$cod=$cbr[$ida];	$sloc[$ida]=0;
$queryp= "INSERT INTO stocklocal (id_art,cod,stock,alarma,pvp) VALUES ($ida,$cod,0,0,0);";
$dbnivel->query($queryp); $tosync[]=$queryp;  if($debug){echo "$queryp \n\n";};
if($debug){echo "DATOS LOCALES__ \$sloc __  \n"; print_r($sloc);  echo "\n\n";};	
}

if($fij!=""){
	
$queryp= "UPDATE stocklocal SET stock=$fij WHERE id_art=$ida;";
$dbnivel->query($queryp);  $tosync[]=$queryp;   if($debug){echo "$queryp \n\n";};	
if(strlen($dbnivel->error())==0){$pas1[$idd]['a']=$ida; $pas1[$idd]['c']=$fij;};
}else{
if($alm){$almacen[$idd][$ida]=$sum;};
if($bd){$bds[$idd]=1;};
$sum=$sloc[$ida] + ($sum*1);	
$queryp= "UPDATE stocklocal SET stock=$sum  WHERE id_art=$ida;";
$dbnivel->query($queryp);  $tosync[]=$queryp;  if($debug){echo "$queryp \n\n";};
if(strlen($dbnivel->error())==0){$pas1[$idd]['a']=$ida; $pas1[$idd]['c']=$sum;};	
}
$pas2[$idd]=1;

}}

if (!$dbnivel->close()){die($dbnivel->error());};

if($debug){echo "DATOS HECHOS LOCALMENTE__ \$pas1 __  \n"; print_r($pas1);  echo "\n\n"; };

if(count($tosync)>0){foreach ($tosync as $point => $sql){
SyncModBD($sql,$id_tienda);
}}$tosync=array();


/*
if (!$dbnivelBAK->open()){die($dbnivelBAK->error());};

if(count($pas1)>0){
foreach ($pas1 as $idd => $todo) {

$ida=$todo['a']; $cant=$todo['c'];$idb="";
	
$queryp= "select id from stocklocal_$id_tienda WHERE id_art=$ida;";
$dbnivelBAK->query($queryp);if($debug){echo "$queryp \n\n";};
while ($row = $dbnivelBAK->fetchassoc()){$idb=$row['id'];};	

if(!$idb){
$cod=$cod=$cbr[$ida];	
$queryp= "INSERT INTO stocklocal_$id_tienda (id_art,cod,stock,alarma,pvp) VALUES ($ida,$cod,$cant,0,0);";
$dbnivelBAK->query($queryp);  if($debug){echo "$queryp \n\n";};	
if(strlen($dbnivel->error())==0){$pas2[$idd]=1;};		
}else{
$queryp= "UPDATE stocklocal_$id_tienda SET stock=$cant WHERE id_art=$ida;";
$dbnivelBAK->query($queryp); if($debug){echo "$queryp \n\n";};		
if(strlen($dbnivel->error())==0){$pas2[$idd]=1;};	
}	
	
	
}}




if (!$dbnivelBAK->close()){die($dbnivelBAK->error());};

if($debug){echo "DATOS HECHOS REMOTAMENTE \$pas2 __  \n"; print_r($pas2);  echo "\n\n"; };

*/











if (!$dbnivelAPP->open()){die($dbnivelAPP->error());};


if(count($almacen)>0){ foreach ($almacen as $idd => $articul) { foreach ($articul as $ida => $value) {
$queryp= "UPDATE articulos SET stock=stock - $value WHERE id=$ida;";
$dbnivelAPP->query($queryp);if($debug){echo "$queryp \n";};		
}}

####aqui deberia resetear stocks menores a 0
############# pongo a 0 stock de almacen roto
$queryp= "UPDATE articulos SET stock=0 WHERE stock < 0;";
$dbnivelAPP->query($queryp);
}


if(count($pas2)>0){ foreach ($pas2 as $idd => $point) {

if(array_key_exists($idd, $bds)){	
$queryp= "UPDATE fij_stock SET bd=2 WHERE id=$idd;";
$dbnivelAPP->query($queryp);if($debug){echo "$queryp \n";};	
}else{
$queryp= "DELETE FROM fij_stock WHERE id=$idd AND bd < 2;";
$dbnivelAPP->query($queryp);if($debug){echo "$queryp \n";};	
	
}

}}



if (!$dbnivelAPP->close()){die($dbnivelAPP->error());};
}




?>