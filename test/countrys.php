<?php



function getZones($url){
$c = curl_init($url);
curl_setopt($c, CURLOPT_VERBOSE, true);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
$page = curl_exec($c);
curl_close($c);
$nfil=explode("\n",$page);

#print_r($nfil);

$count=0;

$borros[]='<table class="wanna-main-menu-static-country-table"><tr><td>    ';
$borros[]='<p class="wanna-main-menu-static-country-line"><a href="';



foreach ($nfil as $key => $fila) {$count++;
$fila=trim($fila);

$borrado=str_replace($borros, '', $fila);	
if(strlen($fila)>strlen($borrado)){

#echo $borrado . "\n";	
	
$vals=explode('"',$borrado); 
$url=trim($vals[0]);

$name=str_replace('</a></p>','',$vals[3]);
$name=str_replace('&amp;','/',$name);		
$name=str_replace('>','',$name);	
$name=str_replace('</td<td','',$name);

$url=trim($url);
$contis=explode('/',$url);$conty=$contis[2];
$zonas[$count]['n']=trim($name);
$zonas[$count]['c']=trim($conty);
$zonas[$count]['u']=$url;


};	
	
}
return $zonas;
}

$url="/spot/Europe/Spain/";
$url='http://wannadive.net' . $url;
$zonas=getZones($url);


require_once("../db.php");
$dbnivel=new DB('ideosites.com','root','2010dos','esdive');
if (!$dbnivel->open()){die($dbnivel->error());};


foreach ($zonas as $key => $vals) {
$name=$vals['n'];$surl=$vals['u'] . "/";$c=$vals['c'];
$queryp= "INSERT into dpoints (name,url,sup_zone,subs,done,conty) VALUES ('$name','$surl',0,1,0,'$c');";
$dbnivel->query($queryp); 
}

if (!$dbnivel->close()){die($dbnivel->error());};


print_r($zonas);
?>