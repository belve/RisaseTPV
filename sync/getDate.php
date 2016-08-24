<?php 
ini_set( 'display_errors','0');

$date=date('Y') . date('m') . date('d');

$file="";

$file = fopen ("http://192.168.1.11/ajax/getdate.php", "r");
if($file){
while (!feof ($file)) { $remotedate = fgets ($file, 1024);};
fclose($file);

}else{
$remotedate=$date;	
}



if ($date!=$remotedate){$val[1]="REVISE LA FECHA ->" . date('d') . "/" . date('m') . "/" . date('Y');;}else{$val[2]=date('d') . "/" . date('m') . "/" . date('Y');;}

echo json_encode($val);
?>