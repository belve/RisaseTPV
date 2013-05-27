<?php

$iva=21;


$equiEST['P']="ACTIVO";
$equiEST['F']="FINALIZADO";
$equiEST['A']="EN ALMACÉN";
$equiEST['T']="ENVIADO A TIENDAS";

global $dbnivel; global $tiendas; global $dbnivelCR; global $dbnivelAPP;

$dbnivelAPP=new DB('192.168.1.11','tpv','tpv','risase');
$dbnivel=new DB('localhost','root','2010dos','RisaseTPV');




?>