<?php
set_time_limit(0);
ini_set("memory_limit", "-1");

require_once("../db.php");
//require_once("../variables.php");
require_once("../functions/sync.php");

$debug=1;

###### a quitar 
$ip='192.168.1.202';
$doit=1;
###############


$noestan=array();

$dbnivel=new DB($ip,'tpv','tpv','RisaseTPV');
$dbnivelAPP=new DB('192.168.1.11','tpv','tpv','risase');
$dbnivelBAK=new DB('192.168.1.11','tpv','tpv','tpv_backup');



if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "select var, value from config";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$config = "\$" . $row['var'] . "='" . $row['value'] . "';";
eval($config);
}




$listahago="";
$cc=0;
$queryp= "select id_art, cod, count(id_art) as C from stocklocal GROUP by id_art ORDER BY C DESC limit 2000;";
$dbnivel->query($queryp); if($debug){echo "$queryp <br>\n\n";};

while ($row = $dbnivel->fetchassoc()){if($row['C'] > 1) {$cc++;
	$listahago.=$row['id_art'] . ",";};	
};
$listahago=substr($listahago, 0,-1);




$queryp= "select id from stocklocal WHERE id_art IN ($listahago) GROUP BY id_art;";$listahago="";
$dbnivel->query($queryp);if($debug){echo "$queryp <br>\n\n";};
while ($row = $dbnivel->fetchassoc()){
$listahago.=$row['id'] . ",";	
}

$listahago=substr($listahago, 0,-1);


$queryp= "DELETE from stocklocal WHERE id IN ($listahago);";
$dbnivel->query($queryp);if($debug){echo "$queryp <br>\n\n";};


if (!$dbnivel->close()){die($dbnivel->error());};


echo " <br>\n ____________________________________  <br>\n ";


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
if (!$dbnivel->close()){die($dbnivel->error());};








if(($tpv!=$tpvB)&&($doit)){
$distintos=array();
if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "select id_art, stock, alarma from stocklocal;";
$dbnivel->query($queryp);if($debug){echo "$queryp <br>\n\n";};
while ($row = $dbnivel->fetchassoc()){$TTtpv[$row['id_art']]=$row['stock']; $alarma[$row['id_art']]=$row['alarma'];};	
if (!$dbnivel->close()){die($dbnivel->error());};


if (!$dbnivelBAK->open()){die($dbnivelBAK->error());};
$queryp= "select id_art, stock from stocklocal_$id_tienda;";
$dbnivelBAK->query($queryp);if($debug){echo "$queryp <br>\n\n";};
while ($row = $dbnivelBAK->fetchassoc()){$TTtpvB[$row['id_art']]=$row['stock'];};



foreach ($TTtpv as $ida => $stl) {
	
if($TTtpvB[$ida]!=$stl){
$al=$alarma[$ida];	
$queryp= "UPDATE stocklocal_$id_tienda SET stock=$stl, alarma=$al WHERE id_art=$ida;";
$dbnivelBAK->query($queryp); if($debug){echo "$queryp <br>\n\n";};	

$distintos[$ida]="$stl | " . $TTtpvB[$ida];	
}

}	


if (!$dbnivelBAK->close()){die($dbnivelBAK->error());};

print_r($distintos);
	
}



?>