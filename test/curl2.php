<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php


function getData($cordenadas){
$c = curl_init("http://maps.googleapis.com/maps/api/geocode/json?latlng=$cordenadas&sensor=false");
curl_setopt($c, CURLOPT_VERBOSE, true);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
$page = curl_exec($c);
curl_close($c);
$geodatos=json_decode($page,TRUE);


$city=$geodatos['results'][1]['formatted_address'];

$vals=explode(',',$city);


print_r($vals);

$num=count($vals)-1;

$data['country']="";$data['state']="";$data['city']="";

$data['country']=trim($vals[$num]);

$num--;

if(array_key_exists($num,$vals)){$data['state']=trim($vals[$num]);$num--;};

if($num>=0){
foreach ($vals as $key => $value) {
if($key<=$num){$data['city'] .=trim($value) . " ";};	
}	

}



return $data;	

}




require_once("../db.php");
$dbnivel=new DB('ideosites.com','root','2010dos','esdive');
if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "select id, gps from dshops where country='' ORDER BY id ASC limit 15;";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){$id[$row['id']]=$row['gps'];};



foreach ($id as $ids => $value) {

$cords=explode(',',$value);$latt=$cords[0];$long=$cords[1];
$data=getData($value);
$country=$data['country'];
if($country==""){$country="-";};
$state=$data['state'];
$city=$data['city'];

$queryp= "UPDATE dshops SET country='$country', state='$state', address='$city', latti='$latt', longi='$long' WHERE id=$ids;";
$dbnivel->query($queryp); 
}


if (!$dbnivel->close()){die($dbnivel->error());};


?>


<script>
	
window.location.href = "curl2.php";  	
	
</script>