<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");
require_once("../functions/sync.php");
require_once("../functions/print.php");

$valores=array();$caj=array();
$fecha=date('Y') . "-" . date('m') . "-" . date('d');

if (!$dbnivel->open()){die($dbnivel->error());};$detcaja="";$tot=0;
$queryp= "select (select CONCAT_WS(' ',nombre, apellido1,apellido2) from empleados where id=id_empleado) as nom, sum(importe) as sum from caja where fecha='$fecha' group by id_empleado;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$nom=$row['nom'];$sum=$row['sum']*1; $tot=$tot+$sum;	
$caj[$nom]=$sum;

$sum=number_format($sum,2);
$detcaja.="<div style='position:relative; float:left;'>$nom:</div> <div style='position:relative;float:right; text-align:right;'>$sum</div> <div style='clear:both'></div> ";
};

$tot=number_format($tot,2);	

$detcaja.="<div style='clear:both; border-top:1px solid; width:100%; height: 5px;'></div> ";
$detcaja.="<div style='position:relative; float:left;'>Total:</div> <div style='position:relative;float:right; text-align:right;'>$tot</div>  ";

if($a=='v'){
$valores['c']=substr($detcaja, 0, strlen($detcaja)-1);
}else{
caja($caj);	
}

if (!$dbnivel->close()){die($dbnivel->error());};



echo json_encode($valores);

?>