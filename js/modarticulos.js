$.ajaxSetup({'async': false});
function cargaArticulo(codbarras){
	

url = "/ajax/modarticulos.php?codbarras=" + codbarras;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
  
if(key==8){
if(val==0){document.getElementById(key).checked=false;};
if(val==1){document.getElementById(key).checked=true;};	
}else{
document.getElementById(key).value=val;
}

});
});

	
	
}


function calcosto(iva){


var costo=document.getElementById('13').value;
var dto1=document.getElementById('6').value
var dto2=document.getElementById('7').value

var neto=(costo - (costo / (100/dto1)) - (costo / (100/dto2))) * iva;
var fran=(costo - (costo / (100/dto1)) - (costo / (100/dto2))) * 1.20;

var neto=Math.round(neto*100)/100
var fran=Math.round(fran*100)/100
document.getElementById('14').value=neto;
document.getElementById('15').value=fran;
}

function modiArt(){

timer(1);

var id=	document.getElementById('1').value;	
var stock=document.getElementById('10').value;
var uniminimas=document.getElementById('11').value;
var preciocosto=document.getElementById('13').value;
var precioneto=document.getElementById('14').value;
var preciofran=document.getElementById('15').value;
var temporada=document.getElementById('12').value;
var pvp=document.getElementById('16').value;
var detalles=document.getElementById('18').value;
var comentarios=document.getElementById('19').value;


if(document.getElementById('8').checked==true){var congelado=1;}else{var congelado=0;};
	
url = "/ajax/update2.php?tabla=articulos&campos[stock]=" + stock + 
"&campos[uniminimas]=" + uniminimas  + 
"&campos[preciocosto]=" + preciocosto  +  
"&campos[precioneto]=" + precioneto  +  
"&campos[preciofran]=" + preciofran  +  
"&campos[temporada]=" + temporada  + 
"&campos[pvp]=" + pvp  +  
"&campos[detalles]=" + detalles  +  
"&campos[comentarios]=" + comentarios  +  
"&campos[congelado]=" + congelado  +  
"&id=" + id;
$.getJSON(url, function(data) {
});	

timer(0);
}
