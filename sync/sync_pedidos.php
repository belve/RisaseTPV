<?php
$listahago="";$idcapedir="";$yahechos=array();$pedidone=array();$artapedir=array();

if (!$dbnivel->open()){die($dbnivel->error());};



$idt=$id_tienda;

$queryp= "select codbarras from pedidos;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$pedidoshago[$row['codbarras']]=1;$listahago.=$row['codbarras'] . ",";	
};


if (!$dbnivel->close()){die($dbnivel->error());};



if (!$dbnivelAPP->open()){die($dbnivelAPP->error()); $noconectado=1;};


$listahago=substr($listahago,0,strlen($listahago)-1);$fecha=date('Y') . "-" . date('m') . "-" . date('d');

$queryp= "select id, id_proveedor, id_subgrupo, (select id_grupo from subgrupos where id=id_subgrupo) as id_grupo, codigo, id_color from articulos where codbarras IN ($listahago);";
$dbnivelAPP->query($queryp);
while ($row = $dbnivelAPP->fetchassoc()){
	
$artapedir[$row['id']]['idp']=$row['id_proveedor'];
$artapedir[$row['id']]['isg']=$row['id_subgrupo'];
$artapedir[$row['id']]['idg']=$row['id_grupo'];
$artapedir[$row['id']]['cod']=$row['codigo'];		

$idcapedir .=$row['id'] . ",";				
};

$idcapedir=substr($idcapedir,0,strlen($idcapedir)-1);

$queryp= "select id_articulo from pedidos where id_tienda=$idt AND estado NOT LIKE 'F' AND id_articulo IN($idcapedir);";
$dbnivelAPP->query($queryp);
while ($row = $dbnivelAPP->fetchassoc()){$yahechos[$row['id_articulo']]=1;};

if(count($artapedir)>0){
foreach ($artapedir as $idar => $values) {if(!array_key_exists($idar, $yahechos)){

$queryp= "select cantidad from repartir where id_tienda=$idt AND id_articulo='$idar';";
$dbnivelAPP->query($queryp);
while ($row = $dbnivelAPP->fetchassoc()){$cantidad=$row['cantidad'];};

$prov=$artapedir[$idar]['idp'];
$grupo=$artapedir[$idar]['idg'];
$subgrupo=$artapedir[$idar]['isg'];
$codigo=$artapedir[$idar]['cod'];



$queryp= "insert into pedidos (id_articulo,id_tienda,cantidad,tip,fecha,prov,grupo,subgrupo,codigo)
 values 
('$idar','$idt','$cantidad','2','$fecha','$prov','$grupo','$subgrupo','$codigo');";

echo "Pedido articulo: $idar <br>";
$dbnivelAPP->query($queryp);

}}}


if (!$dbnivelAPP->close()){die($dbnivelAPP->error());};








?>