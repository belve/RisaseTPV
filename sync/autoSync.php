<?php
set_time_limit(0);
ini_set("memory_limit", "-1");

require_once("../db.php");
require_once("../variables.php");
require_once("../functions/sync.php");


$dbnivelAPP=new DB('192.168.1.11','tpv','tpv','risase');
$dbnivelBAK=new DB('192.168.1.11','tpv','tpv','tpv_backup');


$debug=1;
include('sync_general.php');
include('sync_getpedidos.php');
include('sync_ticket.php');
include('sync_pedidos.php');
include('sync_roturas.php');
include('sync_fijStock.php');
include('sync_fijPVP.php');




if(count($tosync)>0){foreach ($tosync as $point => $sql){
SyncModBD($sql,$id_tienda);
}}


?>


