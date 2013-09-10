<?php
$querys2=array();$queryshechas=array();
$fecha=date('Y') . "-" . date('m') . "-" . date('d');

if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "select * from roturas;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$querys2[$row['id']]['c']=$row['codbarras'];
$querys2[$row['id']]['q']=$row['qty'];	
$querys2[$row['id']]['m']=$row['modo'];
}

if (!$dbnivel->close()){die($dbnivel->error());};




if (!$dbnivelAPP->open()){die($dbnivelAPP->error());};

if(count($querys2)>0){foreach($querys2 as $idq => $valores){
$codbarras=$valores['c'];
$qty=$valores['q'];
$modo=$valores['m'];		

$queryp= "INSERT INTO roturas (id_tienda,codbarras,modo,qty,fecha) VALUES ('$id_tienda', '$codbarras', '$modo', '$qty','$fecha');";
$dbnivelAPP->query($queryp);	
if(strlen($dbnivelAPP->error())==0){$queryshechas[$idq]=1;};	

}}
if (!$dbnivelAPP->close()){die($dbnivelAPP->error());};






if (!$dbnivel->open()){die($dbnivel->error());};

if(count($queryshechas)>0){foreach($queryshechas as $idh => $uno){
$queryp= "delete from roturas where id=$idh;";
$dbnivel->query($queryp);

}}
if (!$dbnivel->close()){die($dbnivel->error());};





?>