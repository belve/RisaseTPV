<?php



if($debug){echo "fijStock ________________________- \n\n";};


if (!$dbnivelAPP->open()){die($dbnivelAPP->error());};
$cuales="";$sloc=array();$cbr=array();$pas1=array();$pas2=array();
$fijos=array();
$bds=array();
$almacen=array();
$doDEL=0;$idupp="";
$queryp= "select * from fij_stock WHERE id_tienda=$id_tienda AND bd < 2 limit 1000";
$dbnivelAPP->query($queryp);if($debug){echo "$queryp \n\n";};
while ($row = $dbnivelAPP->fetchassoc()){
$fijos[$row['id']]['ida']=$row['id_articulo'];
$fijos[$row['id']]['fij']=$row['fijo'];	
$fijos[$row['id']]['sum']=$row['suma'];	
$fijos[$row['id']]['alm']=$row['alm'];	
$fijos[$row['id']]['bd']=$row['bd'];		
$cuales.=$row['id_articulo'] . ",";
$idupp.=$row['id'] . ",";


}
$cuales=substr($cuales, 0,-1);$idupp=substr($idupp, 0,-1);
if (!$dbnivelAPP->close()){die($dbnivelAPP->error());};



if(count($fijos)>0){

if($debug){echo "DATOS IMPORTADOS__ \$fijos __  \n"; print_r($fijos); echo "\n\n";};


if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "select codbarras, id from articulos WHERE id IN ($cuales);";
$dbnivel->query($queryp);if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){
$cbr[$row['id']]=$row['codbarras'];
}


$queryp= "select id_art, stock from stocklocal where id_art IN ($cuales);";
$dbnivel->query($queryp);if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){
$idaL=$row['id_art']; $stock=$row['stock'];
if($idaL){	$sloc[$idaL]=$stock;}
}



if($debug){echo "DATOS LOCALES__ \$sloc __  \n"; print_r($sloc); echo "\n\n"; };
if($debug){echo "DATOS LOCALES__ \$cbr __  \n"; print_r($cbr);  echo "\n\n"; };

$pas1=array();


if(count($fijos)>0){

$querypI= "INSERT INTO stocklocal (id_art,cod,stock,alarma,pvp) VALUES ";$qpi=0;	
$querySUM1= "UPDATE stocklocal SET stock = CASE ";	
$querySUM2= "UPDATE stocklocal SET stock = CASE ";	
$sum1="";$sum2="";	
foreach ($fijos as $idd => $arti) {$fij="";
$ida=$arti['ida']; $fij=$arti['fij']; $sum=$arti['sum']; $alm=$arti['alm']; $bd=$arti['bd'];	$idaL="";


################################3 creo no existentes ###############################
if(!array_key_exists($ida, $sloc)){
$cod=$cbr[$ida];	$sloc[$ida]=0;
$querypI .= "($ida,$cod,0,0,0),";$qpi++;
}
####################################################################################


################################3 actualizo ###############################
if($fij!=""){
$querySUM1.= "WHEN id_art = $ida THEN $fij
"; 
$sum1 .=$ida . ",";
}else{
	
if($alm){$almacen[$idd][$ida]=$sum;};
if($bd){$bds[$ida][$idd]=1;};
$sum=$sloc[$ida] + ($sum*1);	
$querySUM2.= "WHEN id_art = $ida THEN $sum
";
$sum2 .=$ida . ",";
}
$pas2[$ida]=1;
###############################


}
if($qpi){
$querypI=substr($querypI, 0,-1);
$dbnivel->query($querypI); $tosync[]=$querypI;  if($debug){echo "$querypI \n\n";};
if($debug){echo "DATOS LOCALES__ \$sloc __  \n";  echo "\n\n";};
}

$sum1=substr($sum1, 0,-1);


if($sum1){
$querySUM1.= "
    ELSE id_art
    END
WHERE id_art IN ($sum1);
";
$dbnivel->query($querySUM1);  $tosync[]=$querySUM1;   if($debug){echo "$querySUM1 \n\n";};	
if(strlen($dbnivel->error())==0){$pas1[$idd]['a']=$ida; $pas1[$idd]['c']=$fij;}else{$doDEL++;   echo "dio error --- \n" . $dbnivel->error(); };###ojo
}



$sum2=substr($sum2, 0,-1);

if($sum2){
$querySUM2.= "
    ELSE id_art
    END
WHERE id_art IN ($sum2);
";
$dbnivel->query($querySUM2);  $tosync[]=$querySUM2;  if($debug){echo "$querySUM2 \n\n";};
if(strlen($dbnivel->error())==0){$pas1[$idd]['a']=$ida; $pas1[$idd]['c']=$sum;}else{ $doDEL++;    echo "dio error --- \n" . $dbnivel->error();}; ###ojo	
}

}

if (!$dbnivel->close()){die($dbnivel->error());};





if($debug){echo "DATOS HECHOS LOCALMENTE__ \$pas1 __  \n";  echo "\n\n"; };

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

if($debug){echo "Propagacion ALMACEN_  \n";  echo "\n\n"; };
print_r($almacen);


$sum3="";
$queryp= "UPDATE articulos SET stock = CASE ";
if(count($almacen)>0){ foreach ($almacen as $idd => $articul) { foreach ($articul as $ida => $value) {
$value=$value*1;	
if($value>0){$value="- $value";		
	
$queryp.= "WHEN id = $ida THEN stock $value
";
$sum3.= $ida . ",";	
}

}}

$sum3=substr($sum3, 0,-1);
$queryp.= "
    ELSE id
    END
WHERE id IN ($sum3);
";
$dbnivelAPP->query($queryp);
if($debug){echo "$queryp \n";};	

####aqui deberia resetear stocks menores a 0
############# pongo a 0 stock de almacen roto
$queryp= "UPDATE articulos SET stock=0 WHERE stock < 0;";
$dbnivelAPP->query($queryp);
}


$sum4="";$sum5="";


if($debug){echo "borrado fijstock--- doDEL: $doDEL \n";  echo "\n\n"; };
print_r($pas2);
print_r($bds);

$idupp2="";
if((count($pas2)>0)&&($doDEL==0)){
		foreach ($pas2 as $idd => $point) {
			if(array_key_exists($idd, $bds)){	
			$sum4.= $idd . ",";	 foreach ($bds[$idd] as $iduppi => $value) {$idupp2.=$iduppi . ",";};
			}else{
			$sum5.= $idd . ",";		
			}
		}
	
	
	if($sum4){
	$sum4=substr($sum4, 0,-1);$idupp2=substr($idupp2, 0,-1);
	$queryp= "UPDATE fij_stock SET bd=2 WHERE id_articulo IN ($sum4) AND id IN ($idupp2);";
	$dbnivelAPP->query($queryp);
	if($debug){echo "$queryp \n";};	
	}
	
	if($sum5){
	$sum5=substr($sum5, 0,-1);
	$queryp= "DELETE FROM fij_stock WHERE id_articulo IN ($sum5) AND id IN ($idupp) AND bd < 2;";
	$dbnivelAPP->query($queryp);
	if($debug){echo "$queryp \n";};	
	}
}



if (!$dbnivelAPP->close()){die($dbnivelAPP->error());};
}




?>