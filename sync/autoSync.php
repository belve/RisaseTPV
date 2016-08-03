<?php
set_time_limit(0);
ini_set("memory_limit", "-1");

require_once("../db.php");
require_once("../variables.php");
require_once("../functions/sync.php");

$tosync=array();

$dbnivelAPP=new DB('2.139.164.215','tpv','tpv','risase');
$dbnivelBAK=new DB('2.139.164.215','tpv','tpv','tpv_backup');



$debug=1;

$hoy=date('Y') . "-" . date('m') . '-' . date('d');
$fecha = new DateTime($hoy);
$fecha->sub(new DateInterval('P90D'));
$bttDEV= $fecha->format('Y-m-d');


include('sync_general.php');      echo "__________________________________________________ 2 \n ";
include('sync_getpedidos.php');
include('sync_ticket.php');  
include('sync_pedidos.php');
include('sync_roturas.php');
include('sync_fijStock.php');  echo "__________________________________________________ 3 \n ";
include('sync_fijPVP.php');

include('sync_cuadra.php');       echo "__________________________________________________ 1 \n ";

echo "------ to sync FINAL ----- \n";
print_r($tosync);
echo "------ to sync FINAL ----- \n";


if(count($tosync)>0){foreach ($tosync as $point => $sql){
SyncModBD($sql,$id_tienda);
}}$tosync=array();


?>


