<?php


$conn=odbc_connect('mdb','local','admin');

if (!$conn)
  {exit("Connection Failed: " . $conn);}


$sql="SELECT * FROM Articulos;";


$rs=odbc_exec($conn,$sql);
if (!$rs)
  {exit("Error in SQL");}



$count=1;$values="";
while (odbc_fetch_row($rs))
 {

	$art_idArticulo=trim(utf8_encode(odbc_result($rs,'art_idArticulo')));
	$art_UniStock=trim(utf8_encode(odbc_result($rs,'art_UniStock')));
	$art_UniMini=trim(utf8_encode(odbc_result($rs,'art_UniMinimas')));
	
	$values .="('$art_idArticulo','$art_UniStock','$art_UniMini'),";
  }

odbc_close($conn);

$values=substr($values, 0,strlen($values)-1);	

$values="('44','-536','0'),('46','-5','0'),('47','4','0')";

if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "INSERT INTO stocklocal (id,stock,alarma) VALUES $values;";
$dbnivel->query($queryp);
echo "<div>Tabla:\t\t Stocklocal \t\t 100%</div>";

if (!$dbnivel->close()){die($dbnivel->error());};
?>