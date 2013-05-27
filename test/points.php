<?php


function getZones($url){
$c = curl_init($url);
curl_setopt($c, CURLOPT_VERBOSE, true);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
$page = curl_exec($c);
curl_close($c);
$filas=explode("\n",$page);if(strlen($page)<=2000){echo $page;};
$haz=0;

foreach ($filas as $key => $fila) {$fila=trim($fila);
if(($haz==1)&&($fila=="</table>")){$haz=0;};	
if($fila=='<table id="wanna-table" class="wanna-tablesorter">'){$haz=1;};
if($haz){$nfil[]=$fila;};
}


$borros[]='<td><a href="';
$borros[]='<td nowrap="nowrap">';
$borros[]='<td nowrap="nowrap" align="right" style="padding-right:10px;">';

$borros2[]="</b>";
$borros2[]="</a></td>";
$borros2[]=" m</td>";
$borros2[]="><b>";
$borros2[]='<td nowrap="nowrap" align="right" style="padding-right:10px;">';
$borros3[]='<td nowrap="nowrap">';
$borros3[]="</td>";

$count=0;
foreach ($nfil as $key => $fila) {
$borrado=str_replace('<td><a href="', '', $fila);	
if(strlen($fila)>strlen($borrado)){$count++;
$vals=explode('"',$borrado);
if(count($vals)==4){
$url=$vals[0];

$name=str_replace($borros2,'',$vals[3]);


}


echo "$name  -- $url  \n";

$zonas[$count]['n']=trim($name);
$zonas[$count]['u']=trim($url);

};	
	
}
print_r($zonas);
return $zonas;
}



require_once("../db.php");
$dbnivel=new DB('ideosites.com','root','2010dos','esdive');
if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "select id, url from dpoints where subs=0 AND done < 2 ORDER BY id ASC limit 10;";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){$ids[$row['id']]=$row['url'];};

foreach ($ids as $id => $url) {


$url='http://wannadive.net' . $url;
$zonas=getZones($url);

foreach ($zonas as $key => $vals) {
$name=$vals['n'];$surl=$vals['u'];
$queryp= "INSERT into dpoints2 (name,url,zone) VALUES ('$name','$surl',$id);";
$dbnivel->query($queryp); 
}

$queryp= "UPDATE dpoints set done=2 where id=$id;";
$dbnivel->query($queryp); 	
}





if (!$dbnivel->close()){die($dbnivel->error());};

print_r($zonas);



?>


<script>
	
window.location.href = "points.php";  	
	
</script>

