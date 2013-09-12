<?php
set_time_limit(0);
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

if(!$ini){$ini=0;};
$fin=$ini+500;
##### datos OLD
$Ntab='Articulos';

$Nid='art_idArticulo';

$camp[1]='art_idProveedor';
$camp[2]='art_idSubgrupo';
$camp[3]='art_idColor';
$camp[4]='art_Codigo';
$camp[5]='art_RefProv';
$camp[6]='art_Foto';
$camp[7]='art_UniStock';
$camp[8]='art_UniMinimas';
$camp[9]='art_CodBarras';
$camp[10]='art_Temporada';
$camp[11]='art_PrecioCosto';
$camp[12]='art_PrecioNeto';
$camp[13]='art_PrecioFran';
$camp[14]='art_PVP';
$camp[15]='art_Congelado';
$camp[16]='art_Stockini';



##### datos NEW
$nNtab="articulos";

$nNid='id';


$ncamp[1]='id_proveedor';
$ncamp[2]='id_subgrupo';
$ncamp[3]='id_color';
$ncamp[4]='codigo';
$ncamp[5]='refprov';
$ncamp[6]='foto';
$ncamp[7]='stock';
$ncamp[8]='uniminimas';
$ncamp[9]='codbarras';
$ncamp[10]='temporada';
$ncamp[11]='preciocosto';
$ncamp[12]='precioneto';
$ncamp[13]='preciofran';
$ncamp[14]='pvp';
$ncamp[15]='congelado';
$ncamp[16]='stockini';


$conn=odbc_connect('risasenew','remoto','azul88');

if (!$conn)
  {exit("Connection Failed: " . $conn);}


$sql="SELECT * FROM $Ntab where $Nid > $ini AND $Nid <= $fin ORDER BY $Nid ASC;";


$rs=odbc_exec($conn,$sql);
if (!$rs)
  {exit("Error in SQL");}




while (odbc_fetch_row($rs))
  {


foreach($camp as $nkey => $nomcampo){
	 $valores[trim(odbc_result($rs,$Nid))][$nkey]=trim(utf8_encode(odbc_result($rs,$nomcampo)));
}


  }

odbc_close($conn);

require_once("../db.php");


$dbnivel=new DB('192.168.1.11','edu','admin','risase');
if (!$dbnivel->open()){die($dbnivel->error());};


$valopi="";
foreach ($valores as $val1 => $val2) {
$nval1=$val2[1];$nval2=$val2[2];$nval3=$val2[3];

$sqlcamps="";$sqlvals="";
foreach ($val2 as $nnkey => $valuecamp)	{
	
	$sqlcamps .= "$ncamp[$nnkey],";
	$sqlvals .= "'$valuecamp',";
}
	
$sqlcamps=substr($sqlcamps, 0,strlen($sqlcamps)-1);	
$sqlvals=substr($sqlvals, 0,strlen($sqlvals)-1);	
	
$valopi .= "('$val1',$sqlvals),";

}

$valopi=substr($valopi, 0,strlen($valopi)-1);
$queryp= "INSERT INTO $nNtab ($nNid,$sqlcamps) values " . $valopi . ";";
$dbnivel->query($queryp);

if (!$dbnivel->close()){die($dbnivel->error());};


?>

<script>
	 window.location.href = "/importadores/articulos.php?ini=<?php echo $fin;?>";
</script>


