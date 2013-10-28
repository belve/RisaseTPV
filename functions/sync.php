<?php

function SyncModBD($sync_sql,$idt){global $dbnivel; 

echo "function SyncModBD__________________ \n\n";


if (!$dbnivel->open()){die($dbnivel->error());};

$sync_sql=str_replace(' stocklocal ', " stocklocal_$idt ", $sync_sql);
$sync_sql=addslashes($sync_sql);

$sql="INSERT INTO syncupdate (syncSql) VALUES ('$sync_sql');";




$queryp= $sql; echo $queryp;
$dbnivel->query($queryp);

echo "$queryp \n\n";
echo $dbnivel->error() . " \n\n";


if (!$dbnivel->close()){die($dbnivel->error());};


}






?>