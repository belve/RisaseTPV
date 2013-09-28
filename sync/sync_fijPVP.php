<?php



if($debug){echo "fijPVP ________________________- \n\n";};


if (!$dbnivelAPP->open()){die($dbnivelAPP->error());};
$cuales="";



$queryp= "select id_articulo,pvp from fij_pvp WHERE id_tienda=$id_tienda;";
$dbnivelAPP->query($queryp);if($debug){echo "$queryp \n\n";};
while ($row = $dbnivelAPP->fetchassoc()){

$ida=$row['id_articulo'];
$pvp=$row['pvp'];

$cuales.="($ida,'$pvp'),";


}
$cuales=substr($cuales, 0,-1);
if (!$dbnivelAPP->close()){die($dbnivelAPP->error());};


if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "DELETE FROM pvp_fijo";
$dbnivel->query($queryp);if($debug){echo "$queryp \n\n";};

$queryp= "INSERT INTO pvp_fijo (id_articulo,pvp) VALUES $cuales;";
$dbnivel->query($queryp);if($debug){echo "$queryp \n\n";};


if (!$dbnivel->close()){die($dbnivel->error());};

?>