<?php
set_time_limit(0);$cents=array();

$al=0;$an=0;

foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$al2=$al+2;$an2=$an+2;



function sacadatos($gps){
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://www.scubaearth.com/dive-shop/dive-shop-profile-search.aspx");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, true);

$data = array(
    'subgurim_Id' => 'subgurim_GMap1',
    'subgurim_Args' => "23|subgurim_GMap1;$gps;10;m|"
    );

curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$output = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

$prefilas=explode("tabs-0').innerHTML = '",$output);

$filas=explode(">",$prefilas[1]);


foreach ($filas as $key => $string) {

$string=str_replace('</a>','',$string);	
$string=str_replace('<br /',"",$string);
$string=str_replace('<a href=mailto:',"",$string);
$string=str_replace('</a',"",$string);
$string=str_replace('<a href=\\',"",$string);
$string=str_replace('/\ target=_blank',"",$string);


if(strlen($string)>strlen(str_replace('S-', '', $string)) ){$newval=explode(' S-', $string); $point=$newval[1]; $filas2[$point][]=$newval[0]; }else{
			
	$filas2[$point][]= $string;	
}

}




$datos2=explode(';',$prefilas[0]);
foreach ($datos2 as $key => $value) {
	
if(strlen($value) > strlen(str_replace('var marker_subgurim_', '', $value))){
$value=str_replace('var marker_subgurim_', '', $value);
$data3=explode('_ = new GMarker(new GLatLng(', $value);
$id=$data3[0];
$data4=explode('),{',$data3[1]);
$gps=$data4[0];
$vals[$id]=$gps;	
}

if(strlen($value) > strlen(str_replace('GEvent.addListener(marker_subgurim_', '', $value))){
$value=str_replace('GEvent.addListener(marker_subgurim_', '', $value);
	
$data3=explode("_, 'click', function(){ marker_subgurim_", $value);
$id=$data3[0];

$value=str_replace("_.openInfoWindowHtml('<div class=\"post-content\"><p>", '', $data3[1]);


$data4=explode('<br />',$value);
$name=str_replace($id, '', $data4[0]);
$names[$name]=$id;	
}

	
}


$count=0;
foreach ($filas2 as $npadi => $valls) {$count++;
$nom=$valls[0];
$cents[$count]['nom']=$valls[0];

$tel=str_replace(' ', '', $valls[1]);
$tel=str_replace('+', '', $tel);
$tel=str_replace('(', '', $tel);
$tel=str_replace(')', '', $tel);
$tel=str_replace('-', '', $tel);
$tel=trim($tel);
$cents[$count]['tel']=$tel;
$cents[$count]['mail']=$valls[2];

if( strlen($valls[5]) > strlen(str_replace('http:', '', $valls[5])) ){$cents[$count]['web']=$valls[5];}else{$cents[$count]['web']='';};

$nom2=str_replace('&', '-', $nom);
$nom2=str_replace('\\\\', '*', $nom2);

$id2=$names[$nom2];
$gps=$vals[$id2];

$cents[$count]['gps']=$gps;
$cents[$count]['npadi']=$npadi;	
}
return $cents;
}

$gps="($al.0000000000000, $an.0000000000000);($al.0000000000000, $an.0000000000000);($al2.0000000000000, $an2.0000000000000)";






$cents=sacadatos($gps);



require_once("../db.php");
$dbnivel=new DB('ideosites.com','root','2010dos','esdive');
if (!$dbnivel->open()){die($dbnivel->error());};



if(count($cents)>0){
foreach ($cents as $key => $vals) {
$name=$vals['nom'];$phone=$vals['tel'];$email=$vals['mail'];$web=$vals['web'];$gps=$vals['gps'];$npadi=$vals['npadi'];
$id="";
$queryp= "select id from dshops where npadi='$npadi' AND email='$email';";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){$id=$row['id'];};

if(!$id){
$queryp= "INSERT INTO dshops (name,phone,email,web,gps,npadi) values ('$name','$phone','$email','$web','$gps','$npadi');";
$dbnivel->query($queryp);
}
}
}





if (!$dbnivel->close()){die($dbnivel->error());};


$posAn=$an+180;
$posAl=90-$al-4;


if($an < 180){
$al=$al;$an=$an+2;	
}else{
$al=$al-2;$an=-180;		
}



?>


<div style="border:1px solid #333333; width:178px; height: 88px; position:absolute; top:0px; left:0px; background-color: white;"></div>
<div style="border:1px solid #333333; width:178px; height: 88px; position:absolute; top:0px; left:180px; background-color: white;"></div>
<div style="border:1px solid #333333; width:178px; height: 88px; position:absolute; top:90px; left:0px;background-color: white; "></div>
<div style="border:1px solid #333333; width:178px; height: 88px; position:absolute; top:90px; left:180px;background-color: white; "></div>

<div style="border:1px solid red; width:3px; height: 3px; position:absolute; top:<?php echo $posAl;?>px; left:<?php echo $posAn;?>px; "></div>
<script>
	
window.location.href = "curl.php?an=<?php echo $an;?>&al=<?php echo $al;?>";  	
	
</script>

