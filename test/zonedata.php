<?php


function getZones($url){

$c = curl_init($url);
curl_setopt($c, CURLOPT_VERBOSE, true);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
$page = curl_exec($c);
curl_close($c);
$filas=explode("\n",$page);if(strlen($page)<=2000){echo $page;};
$haz=0;

echo $url;



foreach ($filas as $key => $fila) {$fila=trim($fila);
$nfil[]=$fila;
}


$rem=array('&amp;lt;','&deg;','&amp;','&gt;','&lt;');
$rem2=array('<','','&','>','<');
$borr=array('<p>','- ','</p>');
$borr2=array('<p>','- ','</p>','<br />');

$count=0;
foreach ($nfil as $key => $fila) {
	


$mult=1;	
$borrado=str_replace('<p><span class="wanna-item-label-gps">Latitude:</span> ', '', $fila);	
if(strlen($fila)>strlen($borrado)){
	 $lat=str_replace($rem,$rem2,str_replace($borr2, '', $borrado));
	 $lattemp=explode(' ',$lat); $decimal=str_replace("'",'',$lattemp[1]); $decimal=$decimal/60; 
	 
	 if($lattemp[2]=="S"){$mult=-1;};
	 if($lattemp[2]=="N"){$mult=1;};
	 
	 $vals['lati']=$mult * ($lattemp[0] + $decimal);
};	


$borrado=str_replace('<span class="wanna-item-label-gps">Longitude:</span> ', '', $fila);	
if(strlen($fila)>strlen($borrado)){
	 $lat=str_replace($rem,$rem2,str_replace($borr2, '', $borrado));
	 $lattemp=explode(' ',$lat); $decimal=str_replace("'",'',$lattemp[1]); $decimal=$decimal/60; 
	 
	 if($lattemp[2]=="W"){$mult=-1;};
	 if($lattemp[2]=="E"){$mult=1;};
	 
	 $vals['long']=$mult * ($lattemp[0] + $decimal);
};	

	
	
$borrado=str_replace('<p><span class="wanna-item-label">How?</span>&nbsp;', '', $fila);	
if(strlen($fila)>strlen($borrado)){ $vals['how']=str_replace($rem,$rem2,str_replace('</p>', '', $borrado));};	

$borrado=str_replace('<p><span class="wanna-item-label">Distance</span>&nbsp;', '', $fila);	
if(strlen($fila)>strlen($borrado)){ $vals['Distance']=str_replace($rem,$rem2,str_replace('</p>', '', $borrado));};	

$borrado=str_replace('<p><span class="wanna-item-label">Easy to find?</span>&nbsp;', '', $fila);	
if(strlen($fila)>strlen($borrado)){ $vals['find']=str_replace($rem,$rem2,str_replace('</p>', '', $borrado));};	

$borrado=str_replace('<p><span class="wanna-item-label">Average depth</span>&nbsp;', '', $fila);	
if(strlen($fila)>strlen($borrado)){ $temp=explode(' m / ',str_replace($rem,$rem2,str_replace('</p>', '', $borrado)));$vals['ad']=$temp[0];};	
	
$borrado=str_replace('<p><span class="wanna-item-label">max depth</span>&nbsp;', '', $fila);	
if(strlen($fila)>strlen($borrado)){ $temp=explode(' m / ',str_replace($rem,$rem2,str_replace('</p>', '', $borrado)));$vals['md']=$temp[0];};	
	

$borrado=str_replace('<p><span class="wanna-item-label">Current</span>&nbsp;', '', $fila);	
if(strlen($fila)>strlen($borrado)){ $vals['current']=str_replace($rem,$rem2,str_replace('</p>', '', $borrado));};		
	
$borrado=str_replace('<p><span class="wanna-item-label">Visibility</span>&nbsp;', '', $fila);	
if(strlen($fila)>strlen($borrado)){ $vals['visibility']=str_replace($rem,$rem2,str_replace('</p>', '', $borrado));};		

$borrado=str_replace('<p><span class="wanna-item-label">Dive site quality</span>&nbsp;', '', $fila);	
if(strlen($fila)>strlen($borrado)){ $vals['quality']=str_replace($rem,$rem2,str_replace('</p>', '', $borrado));};		

$borrado=str_replace('<p><span class="wanna-item-label">Experience</span>&nbsp;', '', $fila);	
if(strlen($fila)>strlen($borrado)){ $vals['level']=str_replace($rem,$rem2,str_replace('</p>', '', $borrado));};		


$borrado=str_replace('<p><span class="wanna-item-label">Bio interest</span>&nbsp;', '', $fila);	
if(strlen($fila)>strlen($borrado)){ $vals['bio']=str_replace($rem,$rem2,str_replace('</p>', '', $borrado));};		

$borrado=str_replace('<h5>Dive type</h5>', '', $fila);	
if(strlen($fila)>strlen($borrado)){
$key++;	
$temp=$nfil[$key];$temp=str_replace($borr, '', $temp);
$vals['tip']=explode('<br />',$temp);		 
};	



$borrado=str_replace('<h5>Dive site activities</h5>', '', $fila);	
if(strlen($fila)>strlen($borrado)){
$key++;	
$temp=$nfil[$key];$temp=str_replace($borr, '', $temp);
$vals['act']=explode('<br />',$temp);		 
};


$borrado=str_replace('<h5>Dangers</h5>', '', $fila);	
if(strlen($fila)>strlen($borrado)){
$key++;	
$temp=$nfil[$key];$temp=str_replace($borr, '', $temp);
$vals['dang']=explode('<br />',$temp);		 
};
	
}


#print_r($nfil);

return $vals;
}



require_once("../db.php");
$dbnivel=new DB('ideosites.com','root','2010dos','esdive');
if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "select id, url from dpoints2 where done=0 ORDER BY id ASC limit 1;";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){$ids[$row['id']]=$row['url'];};

foreach ($ids as $id => $url) {

#$url="/spot/Australia_Pacific/Australia/QLD/Far_Northern/Star_Reef/index.html";
$url='http://wannadive.net' . $url;
$vals=getZones($url);


$lati="";if(array_key_exists('lati', $vals)){$lati=$vals['lati'];};
$long="";if(array_key_exists('long', $vals)){$long=$vals['long'];};

$lati2="";$long2="";
if($lati){$lati2="lati='$lati', ";};
if($long){$long2="longi='$long', ";};

$a_Depth="";if(array_key_exists('ad', $vals)){$a_Depth=$vals['ad'];};
$m_Depth="";if(array_key_exists('md', $vals)){$m_Depth=$vals['md'];};

if(array_key_exists('how', $vals)){
$how=$vals['how'];
$id_how="";	
$queryp= "select id from vals_how where name='$how';";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){$id_how=$row['id'];};

if($id_how){$how=$id_how;}else{
$queryp= "insert into vals_how (name) values ('$how');";
$dbnivel->query($queryp); 	
$queryp= "SELECT LAST_INSERT_ID() as id;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$how=$row['id'];};	
}

}else{$how=0;}







if(array_key_exists('Distance', $vals)){
$distan=$vals['Distance'];
$id_Distan="";	
$queryp= "select id from vals_distan where name='$distan';";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){$id_Distan=$row['id'];};

if($id_Distan){$distan=$id_Distan;}else{
$queryp= "insert into vals_distan (name) values ('$distan');";
$dbnivel->query($queryp); 	
$queryp= "SELECT LAST_INSERT_ID() as id;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$distan=$row['id'];};	
}

}else{$distan=0;}




if(array_key_exists('find', $vals)){
$find=$vals['find'];
$id_find="";	
$queryp= "select id from vals_find where name='$find';";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){$id_find=$row['id'];};

if($id_find){$find=$id_find;}else{
$queryp= "insert into vals_find (name) values ('$find');";
$dbnivel->query($queryp); 	
$queryp= "SELECT LAST_INSERT_ID() as id;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$find=$row['id'];};	
}

}else{$find=0;}






if(array_key_exists('current', $vals)){
$current=$vals['current'];
$id_current="";	
$queryp= "select id from vals_current where name='$current';";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){$id_current=$row['id'];};

if($id_current){$current=$id_current;}else{
$queryp= "insert into vals_current (name) values ('$current');";
$dbnivel->query($queryp); 	
$queryp= "SELECT LAST_INSERT_ID() as id;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$current=$row['id'];};	
}

}else{$current=0;}






if(array_key_exists('visibility', $vals)){
$visibility=$vals['visibility'];
$id_visibility="";	
$queryp= "select id from vals_visibility where name='$visibility';";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){$id_visibility=$row['id'];};

if($id_visibility){$visibility=$id_visibility;}else{
$queryp= "insert into vals_visibility (name) values ('$visibility');";
$dbnivel->query($queryp); 	
$queryp= "SELECT LAST_INSERT_ID() as id;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$visibility=$row['id'];};	
}

}else{$visibility=0;}





if(array_key_exists('quality', $vals)){
$quality=$vals['quality'];
$id_quality="";	
$queryp= "select id from vals_quality where name='$quality';";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){$id_quality=$row['id'];};

if($id_quality){$quality=$id_quality;}else{
$queryp= "insert into vals_quality (name) values ('$quality');";
$dbnivel->query($queryp); 	
$queryp= "SELECT LAST_INSERT_ID() as id;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$quality=$row['id'];};	
}

}else{$quality=0;}



if(array_key_exists('level', $vals)){
$level=$vals['level'];
$id_level="";	
$queryp= "select id from vals_experience where name='$level';";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){$id_level=$row['id'];};

if($id_level){$level=$id_level;}else{
$queryp= "insert into vals_experience (name) values ('$level');";
$dbnivel->query($queryp); 	
$queryp= "SELECT LAST_INSERT_ID() as id;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$level=$row['id'];};	
}

}else{$level=0;}




if(array_key_exists('bio', $vals)){
$bio=$vals['bio'];
$id_bio="";	
$queryp= "select id from vals_bio where name='$bio';";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){$id_bio=$row['id'];};

if($id_bio){$bio=$id_bio;}else{
$queryp= "insert into vals_bio (name) values ('$bio');";
$dbnivel->query($queryp); 	
$queryp= "SELECT LAST_INSERT_ID() as id;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$bio=$row['id'];};	
}

}else{$bio=0;}





if(array_key_exists('tip', $vals)){
$tip="";	
foreach ($vals['tip'] as $key => $value) {if(trim($value)){
	

$nom=trim($value);
$id_nom="";	
$queryp= "select id from vals_tip where name='$nom';";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){$id_nom=$row['id'];};

if($id_nom){$nom=$id_nom;}else{
$queryp= "insert into vals_tip (name) values ('$nom');";
$dbnivel->query($queryp); 	
$queryp= "SELECT LAST_INSERT_ID() as id;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$nom=$row['id'];};	
}


$tip .="$nom|";
}}	

}else{$tip="";};








if(array_key_exists('act', $vals)){
$act="";	
foreach ($vals['act'] as $key => $value) {if(trim($value)){
	

$nom=trim($value);
$id_nom="";	
$queryp= "select id from vals_act where name='$nom';";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){$id_nom=$row['id'];};

if($id_nom){$nom=$id_nom;}else{
$queryp= "insert into vals_act (name) values ('$nom');";
$dbnivel->query($queryp); 	
$queryp= "SELECT LAST_INSERT_ID() as id;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$nom=$row['id'];};	
}


$act .="$nom|";
}}	

}else{$act="";};




if(array_key_exists('dang', $vals)){
$dang="";	
foreach ($vals['dang'] as $key => $value) {if(trim($value)){
	

$nom=trim($value);
$id_nom="";	
$queryp= "select id from vals_dang where name='$nom';";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){$id_nom=$row['id'];};

if($id_nom){$nom=$id_nom;}else{
$queryp= "insert into vals_dang (name) values ('$nom');";
$dbnivel->query($queryp); 	
$queryp= "SELECT LAST_INSERT_ID() as id;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$nom=$row['id'];};	
}


$dang .="$nom|";
}}	

}else{$dang="";};


#$queryp= "INSERT into dpoints2 (name,url,zone) VALUES ('$name','$surl',$id);";
#$dbnivel->query($queryp); 


$queryp= "UPDATE dpoints2 set done=1, $lati2 $long2 a_Depth='$a_Depth', m_Depth='$m_Depth', distan=$distan, how=$how, hfind=$find, current=$current, 
visibility=$visibility, quality=$quality, experience=$level, bio=$bio, tip='$tip', act='$act', dang='$dang' where id=$id;";
$dbnivel->query($queryp); echo $queryp;	
}





if (!$dbnivel->close()){die($dbnivel->error());};

print_r($vals);



?>



<script>
	
window.location.href = "zonedata.php";  	
	
</script>

