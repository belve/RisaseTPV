<?php

function SyncModBD($sync_sql,$idt){global $dbnivel; 



$sync_sql=str_replace(' stocklocal ', " stocklocal_$idt ", $sync_sql);
$sync_sql=addslashes($sync_sql);

$sql="INSERT INTO syncupdate (syncSql) VALUES ('$sync_sql');";


if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= $sql; #echo $queryp;
$dbnivel->query($queryp);

if (!$dbnivel->close()){die($dbnivel->error());};


}






?>