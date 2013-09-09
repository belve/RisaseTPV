<?php




?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


</head>

<style>
.body {margin:0px;font-family: Arial;}
.DCod {width:95px; height:20px;  border-right: 1px solid #888888; font-size: 12px; float:left; border-bottom: 1px solid #888888;border-left: 1px solid #888888; padding-left: 5px; background-color: white; }
.DArt {width:37px; height:20px; border-right: 1px solid #888888; font-size: 12px; float:left;  border-bottom: 1px solid #888888;padding-left: 3px; background-color: white;}
.DCan {width:38px; height:20px;  border-right: 1px solid #888888; font-size: 12px; float:left;text-align: right; border-bottom: 1px solid #888888;padding-right: 3px; background-color: white;}
.Dpre {width:30px; height:20px; float:left; }
.menos {height:20px;width:14px; background-image:url('/iconos/menos.png'); position: relative; float: left; margin-left: 3px; cursor:pointer;}
.mas {height:20px;width:14px; background-image:url('/iconos/mas.png'); position: relative; float: left;  margin-left: 3px; cursor:pointer;}
}
</style>

<script>
	
	
function sumR(sum,cod,que){
var sum=sum*1;
var rot="";	
if(getCookieT('roturas')){var rot=getCookieT('roturas');};	
	
var det="";
var code="";
var repe=0;

if(rot.length>0){var det=rot.split('<>');}


if(det){

for (var i = 1; i < det.length; i++) {
var deti=det[i];	
var datos=deti.split('|');


if((datos[0]==cod)&&(datos[2]==que)){var QTY=(datos[1]*1)+sum;var repe=1;}else{var QTY=datos[1]*1;};

if(QTY>0){
code=code + '<>' + datos[0] + '|' + QTY + '|' + datos[2];
}
}

}	



setCookieT('roturas',code,1);	
showRoturas();
parent.document.getElementById("impCodD").select();




}



function showRoturas(){
var rot="";	
var rot=getCookieT('roturas');


document.getElementById('tiqcode').innerHTML='';

if(rot.length>0){var det=rot.split('<>');}


var code="";
if(det){
for (var i = 1; i < det.length; i++) {
var deti=det[i];	
var datos=deti.split('|');
code=code + '<div class="DCod">' + datos[0] + '</div>' +
'<div class="DArt">' + datos[1] + '</div>' + 
'<div class="DCan">' + datos[2] + '</div> <div class="menos" onclick="javascript:sumR(\'-1\',' + datos[0] + ', \'' + datos[2] + '\')"></div> <div class="mas" onclick="javascript:sumR(\'1\',' + datos[0] + ', \'' + datos[2] + '\')"></div>';


}
}else{
code='<div class="DCod"></div><div class="DArt"></div><div class="DCan"></div><div style="clear:both;"></div>';
}

document.getElementById('tiqcode').innerHTML=code;

}

function getCookieT(c_name)
{
var i,x,y,ARRcookies=document.cookie.split(";");
for (i=0;i<ARRcookies.length;i++)
{
  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
  x=x.replace(/^\s+|\s+$/g,"");
  if (x==c_name)
    {
    return unescape(y);
    }
  }
}
	
function setCookieT(c_name,value,exdays)
{
var exdate=new Date();
exdate.setDate(exdate.getDate() + exdays);
var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString()) + "; path=/";
document.cookie=c_name + "=" + c_value;
}


</script>


<body class="body">
<html>

<div id="tiqcode">

<div class="DCod"></div>
<div class="DArt"></div>
<div class="DCan"></div>
<div class="Dpre"></div>
<div style="clear:both;"></div>

	
</div>	
	
</html>
</body>