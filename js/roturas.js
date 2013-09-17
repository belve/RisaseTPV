
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




function DintroD(){
DaddART();
}



function DaddART(){$.ajaxSetup({'async': false});
var rot="";	
if(getCookieT('roturas')){var rot=getCookieT('roturas');};

var cod=document.getElementById('impCodD').value;
var mod=document.getElementById('mod').value;
	
var det="";
var code="";
var repe=0;

if(rot.length>0){var det=rot.split('<>');}


if(det){

for (var i = 1; i < det.length; i++) {
var deti=det[i];	
var datos=deti.split('|');


if((datos[0]==cod)&&(datos[2]==mod)){var QTY=(datos[1]*1)+1;var repe=1;}else{var QTY=datos[1]*1;};

code=code + '<>' + datos[0] + '|' + QTY + '|' + datos[2];

}

}



if(repe==0){
var url='/ajax/addArticuloD.php?cod=' + cod + '&mod=' + mod;


$.getJSON(url, function(data) {
$.each(data, function(key, val) {

if(val=="error"){
alert("Código no encontrado");
document.getElementById("impCodD").value="";
document.getElementById("impCodD").select();		
}else{
rot=rot + val;	
}			
	
});
});
}else{
rot=code;	
}


setCookieT('roturas',rot,1);	
showRoturas();
document.getElementById("impCodD").select();



}



function putDev(){
document.getElementById('Dev').setAttribute("class", "botDev bdNara");
document.getElementById('Rot').setAttribute("class", "botDev bdGris");
document.getElementById('mod').value="D";	
}


function putRot(){
document.getElementById('Rot').setAttribute("class", "botDev bdNara");
document.getElementById('Dev').setAttribute("class", "botDev bdGris");
document.getElementById('mod').value="R";
}




function showRoturas(){
var rot="";	
var rot=getCookieT('roturas');



var iframe = document.getElementById('detRotura');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
innerDoc.getElementById('tiqcode').innerHTML='';

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

innerDoc.getElementById('tiqcode').innerHTML=code;

}





function do_rotura(){
var rot="";	
if(getCookieT('roturas')){var rot=getCookieT('roturas');};



if(rot.length>0){var det=rot.split('<>');

var total=0;
var code="";
if(det){
for (var i = 1; i < det.length; i++) {var check=1;
var deti=det[i];	
var datos=deti.split('|');
code=code + '&detROT[' + i + '][' + datos[0] + '][q]=' + datos[1] +
			'&detROT[' + i + '][' + datos[0] + '][m]=' + datos[2]; 
			
}}



if(check){
var url='/ajax/doROT.php?emp=' + code;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
});
});

setCookieT('roturas','',1);	
showRoturas();
document.getElementById("impCodD").value="";
document.getElementById("impCodD").select();
}

}	


}

