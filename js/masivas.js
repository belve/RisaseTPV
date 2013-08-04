
$.ajaxSetup({'async': false});

function limpiar(){
document.getElementById('altasmas').src='/ajax/altasmas.php';
document.getElementById('codgenerados').src='/ajax/codgenerados.php';	
}

function prov_grid(idpro){

url = "/ajax/proveedores.php?pointer=" + idpro;

$.getJSON(url, function(data) {
$.each(data, function(key, val) {
   if(key == 13){document.getElementById('3').value=val;};
   if(key == 14){document.getElementById('4').value=val;};
    
});
});
}

function generar_altas(){
	
var iframe = document.getElementById('altasmas');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;	

var iframe2 = document.getElementById('codgenerados');
var innerDoc2 = iframe2.contentDocument || iframe2.contentWindow.document;	

var filas=innerDoc.getElementById('fil').value;	
var idpro=document.getElementById('2').value;
var dto1=document.getElementById('3').value;
var dto2=document.getElementById('4').value;
var temp=document.getElementById('5').value;

var error="";
if(!idpro){var error=error + 'Debe selecionar un proveedor. \n';}
if(!temp){var error=error + 'Debe especificar una temporada. \n';}

if(error){
	alert(error);
}else{
var i=1;
while (i <= filas)
  {
var c1=innerDoc.getElementById(i + 'V1').value;	  
var c2=innerDoc.getElementById(i + 'V2').value;	 
var c3=innerDoc.getElementById(i + 'V3').value;	 
var c4=innerDoc.getElementById(i + 'V4').value;	 
var c5=innerDoc.getElementById(i + 'V5').value;	 
var c6=innerDoc.getElementById(i + 'V6').value;	 
var c7=innerDoc.getElementById(i + 'V7').value;	 
var c8=innerDoc.getElementById(i + 'V8').value;	   

var url='/ajax/crate_art_grid.php?id_proveedor=' + idpro + 
'&repro=' + c1 + 
'&id_g=' + c2 + 
'&id_s=' + c3 +
'&color=' + c4 + 
'&cantidad=' + c5 + 
'&alarma=' + c6 + 
'&precioC=' + c7 + 
'&pvp=' + c8 + 
'&dto1=' + dto1 + 
'&dto2=' + dto2 + 
'&temp=' + temp + 
'&evcache=' + i + new Date();

var aimpr=(c5*1) + 1;

$.getJSON(url, function(data) {
$.each(data, function(key, val) {

var contenido=innerDoc2.getElementById('codbarras').innerHTML;
innerDoc2.getElementById('codbarras').innerHTML=contenido + '<div style="float:left" onclick="copiaporta(\'' + key + '\')"  id="' + key + '">' + key + '</div> <div style="float:left"> - ' + aimpr + '</div> <div style="clear:both;"></div>';	
  	
 
});
});

i++;
  }	
}
}
