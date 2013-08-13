<?php

require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};

$count=0;
$borros=array();
$queryp= "select * from empleados where trabajando='S' order by orden asc;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$empleados[$row['id']]=$row['nombre'] . " " . $row['apellido1'] . " " . $row['apellido2'];$count++;};



if (!$dbnivel->close()){die($dbnivel->error());};

$empleados['count']=$count;

echo json_encode($empleados);