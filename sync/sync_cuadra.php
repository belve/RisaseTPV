<?php
if($debug){echo "cuadra ________________________- \n\n";}
if (!$dbnivelAPP->open()){die($dbnivelAPP->error());}; 
$horr=date('G');
$ip = $_SERVER['REMOTE_ADDR'];

$ldoneP=0;

$existt="";
$queryp= "select ip from tasks where idt=$id_tienda;";
$dbnivelAPP->query($queryp); if($debug){echo "$queryp \n\n";};
while ($row = $dbnivelAPP->fetchassoc()){$existt=$row['ip'];};

if(!$existt){
$queryp= "INSERT INTO tasks (idt,ip) VALUES ($id_tienda,'$ip');";
$dbnivelAPP->query($queryp);if($debug){echo "$queryp \n\n";};	
}

$queryp= "select ldoneP from tasks where idt=$id_tienda AND ldoneF='$hoy';";
$dbnivelAPP->query($queryp); if($debug){echo "$queryp \n\n";};
while ($row = $dbnivelAPP->fetchassoc()){
$ldoneP=$row['ldoneP'];	
}
if (!$dbnivelAPP->close()){die($dbnivelAPP->error());};



$doitC=0;
if(($horr >= 7)&&($horr < 15)){$ldonePN=1;}
if(($horr >= 15)&&($horr < 21)){$ldonePN=2;}
if(($horr >= 21)&&($horr < 24)){$ldonePN=3;}

if($ldoneP<$ldonePN){$ldoneP=$ldonePN;$doitC=1;}

if($doitC){
	



################# sumo stocks
if (!$dbnivelBAK->open()){die($dbnivelBAK->error());};
$queryp= "select sum(stock) as S from stocklocal_$id_tienda;";
$dbnivelBAK->query($queryp);if($debug){echo "$queryp <br>\n\n";};
while ($row = $dbnivelBAK->fetchassoc()){$tpvB=$row['S'];};
if (!$dbnivelBAK->close()){die($dbnivelBAK->error());};


if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "select sum(stock) as S from stocklocal;";
$dbnivel->query($queryp);if($debug){echo "$queryp <br>\n\n";};
while ($row = $dbnivel->fetchassoc()){$tpv=$row['S'];};

echo " <br>\n ____________________________________  <br>\n ";
echo "$id_nom_tienda: $id_tienda <br>\n ";
echo "STL TPV: $tpv  <br>\n ";
echo "STL BAK: $tpvB  <br>\n ";
echo " <br>\n ____________________________________  <br>\n ";




######## si descuadran

if(($tpv!=$tpvB)&&($doitC)){
$distintos=array();

$queryp= "select id_art, stock, alarma from stocklocal;";
$dbnivel->query($queryp);if($debug){echo "$queryp <br>\n\n";};
while ($row = $dbnivel->fetchassoc()){$TTtpv[$row['id_art']]=$row['stock']; $alarma[$row['id_art']]=$row['alarma'];};	

if (!$dbnivel->close()){die($dbnivel->error());};

if (!$dbnivelBAK->open()){die($dbnivelBAK->error());};
$queryp= "select id_art, stock from stocklocal_$id_tienda;";
$dbnivelBAK->query($queryp);if($debug){echo "$queryp <br>\n\n";};
while ($row = $dbnivelBAK->fetchassoc()){$TTtpvB[$row['id_art']]=$row['stock'];};



foreach ($TTtpv as $ida => $stl) {

	if(array_key_exists($ida, $TTtpvB))	{
	if($TTtpvB[$ida]!=$stl){
		
	$al=$alarma[$ida];	
	$queryp= "UPDATE stocklocal_$id_tienda SET stock=$stl, alarma=$al WHERE id_art=$ida;";
	$dbnivelBAK->query($queryp); if($debug){echo "$queryp <br>\n\n";};	
	
	$distintos[$ida]="$stl | " . $TTtpvB[$ida];	
	}}else{
		
	$al=$alarma[$ida];	
	$queryp= "INSERT INTO stocklocal_$id_tienda (id_art,stock,alarma) VALUES ($ida,$stl,$al);";
	$dbnivelBAK->query($queryp); if($debug){echo "$queryp <br>\n\n";};	
		
	}}	


if (!$dbnivelBAK->close()){die($dbnivelBAK->error());};


	
}
########################################################################33


if (!$dbnivelAPP->open()){die($dbnivelAPP->error());}; 
$queryp= "UPDATE tasks SET sumL=$tpv, sumB=$tpvB  WHERE idt=$id_tienda;";
$dbnivelAPP->query($queryp);	if($debug){echo "$queryp <br>\n\n";};	
if (!$dbnivelAPP->close()){die($dbnivelAPP->error());};
	
		
}#####fin doit



if (!$dbnivelAPP->open()){die($dbnivelAPP->error());}; 
$queryp= "UPDATE tasks set ip='$ip', ldoneF='$hoy', ldoneP='$ldoneP'  WHERE idt=$id_tienda;";
$dbnivelAPP->query($queryp);	if($debug){echo "$queryp <br>\n\n";};	
if (!$dbnivelAPP->close()){die($dbnivelAPP->error());};




if($debug){echo "cuadra ________________________- \n\n";}