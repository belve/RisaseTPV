<?php

if (!$dbnivelAPP->open()){die($dbnivelAPP->error()); $noconectado=1;};

$querys=array();$queryshechas=array();
$queryp= "select * from syncupdate where id_tiend=$id_tienda;";
$dbnivelAPP->query($queryp);
while ($row = $dbnivelAPP->fetchassoc()){
$querys[$row['id']]=$row['syncSql'];	
}

if (!$dbnivelAPP->close()){die($dbnivelAPP->error());};





if (!$dbnivel->open()){die($dbnivel->error());};
if(count($querys)>0){foreach ($querys as $id => $queryp) {
$dbnivel->query($queryp);
if(strlen($dbnivel->error())==0){$queryshechas[$id]=1;};
}}
if (!$dbnivel->close()){die($dbnivel->error());};






if (!$dbnivelAPP->open()){die($dbnivelAPP->error()); $noconectado=1;};

if(count($queryshechas)>0){foreach ($queryshechas as $idhecho => $nada) {
$queryp= "delete from syncupdate where id=$idhecho;";
$dbnivelAPP->query($queryp);
}}

if (!$dbnivelAPP->close()){die($dbnivelAPP->error());};



?>