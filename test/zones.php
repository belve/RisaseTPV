<?php


function getZones($url){
$c = curl_init($url);
curl_setopt($c, CURLOPT_VERBOSE, true);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
$page = curl_exec($c);
curl_close($c);
$filas=explode("\n",$page);if(strlen($page)<=2000){echo $page;};
$haz=0;
foreach ($filas as $key => $fila) {
if(($haz==1)&&($fila=="</tbody>")){$haz=0;};	
if($fila=='<table id="wanna-table" class="wanna-tablesorter">'){$haz=1;};
if($haz){$nfil[]=$fila;};
}

$borros[]='<td nowrap="nowrap">';
$borros[]='</td>';
$count=0;
foreach ($nfil as $key => $fila) {$count++;
$borrado=str_replace('<td nowrap="nowrap"><a href="', '', $fila);	
if(strlen($fila)>strlen($borrado)){
$vals=explode('" class="wanna-tabzonespot-item-title">',$borrado);
$url=trim($vals[0]);

$name=str_replace('</a></td>','',$vals[1]);
$name=str_replace('&amp;','/',$name);		

$dsites=str_replace($borros, '', $nfil[$key+1]);
$subzones=str_replace($borros, '', $nfil[$key+2]);

$zonas[$count]['n']=trim($name);
$zonas[$count]['u']=trim($url);
$zonas[$count]['p']=trim($dsites);
$zonas[$count]['z']=trim($subzones);

};	
	
}
return $zonas;
}



require_once("../db.php");
$dbnivel=new DB('ideosites.com','root','2010dos','esdive');
if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "select id, url from dpoints where subs=1 AND done=0 ORDER BY id ASC limit 5;";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){$ids[$row['id']]=$row['url'];};

foreach ($ids as $id => $url) {

$url='http://wannadive.net' . $url;
$zonas=getZones($url);

foreach ($zonas as $key => $vals) {
$name=$vals['n'];$surl=$vals['u'];$z=$vals['z'];
if($z>0){$z=1;};
$queryp= "INSERT into dpoints (name,url,sup_zone,subs,done) VALUES ('$name','$surl',$id,$z,0);";
$dbnivel->query($queryp); 
}

$queryp= "UPDATE dpoints set done=1 where id=$id;";
$dbnivel->query($queryp); 	
}





if (!$dbnivel->close()){die($dbnivel->error());};

print_r($zonas);



?>


<script>
	
window.location.href = "zones.php";  	
	
</script>
