
<?php

set_time_limit(0);
require_once("../db.php");
require_once("../variables.php");
require_once("../functions/sync.php");

$debug=1;
include('sync_general.php');
include('sync_getpedidos.php');
include('sync_ticket.php');
include('sync_pedidos.php');
include('sync_roturas.php');
include('sync_fijStock.php');
include('sync_fijPVP.php');

?>


