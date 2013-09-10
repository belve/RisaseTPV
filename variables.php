<?php

$iva=21;


$equiEST['P']="ACTIVO";
$equiEST['F']="FINALIZADO";
$equiEST['A']="EN ALMACÉN";
$equiEST['T']="ENVIADO A TIENDAS";

$pathimages="c:/D/fotos/";
$urlimages="http://192.168.1.11/photos/";

global $dbnivel; global $tiendas; global $dbnivelCR; global $dbnivelAPP;

$dbnivelAPP=new DB('192.168.1.11','tpv','tpv','risase');
$dbnivelBAK=new DB('192.168.1.11','tpv','tpv','tpv_backup');
$dbnivel=new DB('localhost','tpv','tpv','RisaseTPV');


if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "select var, value from config";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$config = "\$" . $row['var'] . "='" . $row['value'] . "';";
eval($config);
}
if (!$dbnivel->close()){die($dbnivel->error());};


$hoy=date('Y') . "-" . date('m') . "-" . date('d');

?>