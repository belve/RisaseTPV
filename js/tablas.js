function paraguardar(tab,value){

var tab;
var value;	
var almacenado="";
	
if(getCookie(tab)){var almacenado=	getCookie(tab);};

if(almacenado.length == almacenado.replace(value,"").length){
var nuevo=almacenado + 'I' + value;
setCookie(tab,nuevo,1);
}
}

function modifield(tabla,campo,busco,id){
var valor=document.getElementById(busco).value;
url='/ajax/updatefield.php?tabla=' + tabla
+ '&campo=' + campo	
+ '&value=' + valor
+ '&id=' + id;

$.getJSON(url, function(data) {
});	
	
}


function save_tabla(tabla){
	$.ajaxSetup({'async': false});
timer(1);
var iframe = document.getElementById(tabla);
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
var url='/ajax/updatefields.php?tabla=' + tabla + "&";
if(getCookie(tabla)){

var almacenado=	getCookie(tabla);	
var datos =almacenado.split('I');
var campos="";

for (var i = 0; i < datos.length; i++) {
if(datos[i].length > 0){
	
var valor=innerDoc.getElementById(datos[i]).value;
campos= campos + 'campos[' + datos[i] + ']=' + valor + "&";	
	
}}}

url=url+campos;
setCookie(tabla,'',1);
$.getJSON(url, function(data) {
});	
timer(0);
}
	



function getCookie(c_name)
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

function setCookie(c_name,value,exdays)
{
var exdate=new Date();
exdate.setDate(exdate.getDate() + exdays);
var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString()) + "; path=/";
document.cookie=c_name + "=" + c_value;
}

function guardacambios(tab){


var datos = nuevo.split('I');
var nuevo
for (var i = 0; i < datos.length; i++) {
   
}	
}



function changefield_art(value){
		
	var i=$("*:focus").attr("id");
	
	
	
	var datos = i.split('V');
	var fila = datos[1]; var columna= datos[0];
	
	
	if(value=='left'){
		columna--;
		var nuevo=columna + "V" + fila
	};
	
	if(value=='right'){
		columna++;
		var nuevo=columna + "V" + fila
	};
	
	
	if(value=='up'){
		fila--;
		var nuevo=columna + "V" + fila
	};
	
	if(value=='down'){
		fila++;
		var nuevo=columna + "V" + fila
		};	
	
	
	$('#'+ nuevo).focus().select();

	
}


function changefield_mas(value){
		
	var i=$("*:focus").attr("id");
	
	
	
	var datos = i.split('V');
	var fila = datos[0]; var columna= datos[1];
	
	
	if(value=='left'){
		columna--;
		var nuevo=fila + "V" + columna
	};
	
	if(value=='right'){
		columna++;
		var nuevo=fila + "V" + columna
	};
	
	
	if(value=='up'){
		fila--;
		var nuevo=fila + "V" + columna
	};
	
	if(value=='down'){
		fila++;
		var fil=document.getElementById('fil').value;
		
		if(fila > fil){create_grid();};
		
		var nuevo=fila + "V" + columna
		};	
	
	
	$('#'+ nuevo).focus().select();

	
}


function create_grid(){
var fil=document.getElementById('fil').value;
fil++;
document.getElementById('fil').value=fil;

var fila='<tr><td style="width:122px"><input type="text" class="camp_mas_rpro" 		value="" id="' + fil
 + 'V1"></td><td style="width:22px">	<input type="text" class="camp_mas_g" 		value="" id="' + fil
 + 'V2"></td><td style="width:22px">	<input type="text" class="camp_mas_s" 		value="" id="' + fil
 + 'V3"></td><td style="width:45px">	<input type="text" class="camp_mas_color"  	value="" id="' + fil
 + 'V4"></td><td style="width:45px">	<input type="text" class="camp_mas_cantidad"value="" id="' + fil
 + 'V5"></td><td style="width:45px">	<input type="text" class="camp_mas_alarma"	value="" id="' + fil
 + 'V6"></td><td style="width:45px">	<input type="text" class="camp_mas_precioC"	value="" id="' + fil
 + 'V7"></td><td style="width:45px">	<input type="text" class="camp_mas_pvp" 	value="" id="' + fil
 + 'V8"></td></tr>';

$('#grid').append(fila);
	
	
}


function limpiarGRID(){

document.getElementById('pegar').setAttribute("style", "visibility:hidden;");
var iframe = document.getElementById('repartos');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
innerDoc.getElementById('gridRepartos').innerHTML='';	
innerDoc.getElementById('filsel').value="";
innerDoc.getElementById('idrep').value="";
innerDoc.getElementById('filas').value="";
innerDoc.getElementById('LinCOP').value="";


	
}

function art_en_REP(){
limpiarGRID();
addArticulo('enrep');	
}





function addArticulo(codigo){
$.ajaxSetup({'async': false});	

timer(1);

var iframe = document.getElementById('repartos');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;

if(innerDoc.getElementById('filas')){var filas = innerDoc.getElementById('filas').value;}else{var filas = 0;};





if(codigo=='listador'){



var prov=document.getElementById(2).value
var grup=document.getElementById(3).value
var subg=document.getElementById(4).value
var colo=document.getElementById(5).value
var codi=document.getElementById(6).value
var pvp=document.getElementById(7).value
var desd=document.getElementById(8).value
var hast=document.getElementById(9).value
var temp=document.getElementById(10).value
	
url = "/ajax/gridRepart.php?id_proveedor=" + prov
 + "&id_grupo=" + grup
 + "&id_subgrupo=" + subg
 + "&id_color=" + colo
 + "&codigo=" + codi
 + "&pvp=" + pvp
 + "&desde=" + desd
 + "&hasta=" + hast
 + "&temporada=" + temp
 + '&ultifila=' + filas
 + '&listador=1'; 



}else if(codigo=='enrep'){ 
	
url = "/ajax/gridRepart.php?listador=2&ultifila=" + filas;	
	
}else{

url = "/ajax/gridRepart.php?codbarras=" + codigo + '&ultifila=' + filas;
	
}



if(innerDoc.getElementById('CART' + codigo)){
alert('Articulo ya listado en el grid');	
}else{
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
var iframe = document.getElementById('repartos');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
if(key=='html'){var html=val;}
if(key=='ultfile'){var ultfile=val;}
if(key=='error'){alert(val);}else{
innerDoc.getElementById('repnue').innerHTML='';	
var grid=innerDoc.getElementById('gridRepartos');
$(grid).append(html);

var $contents = $('#repartos').contents();
$contents.scrollTop($contents.height());	
filas++;
innerDoc.getElementById('filas').value=ultfile;

}

});
});

}



document.getElementById('art').select();

timer(0);
}
















function reparto(reparto){
timer(1);
document.getElementById('repartos').src='/ajax/repartos.php?nomrep=' + reparto;	
}


function cambiaFieldRep(i){

var alarma=parent.document.getElementById('alarma').value

var datos = i.split('I');
var part = datos[0]; var point= datos[1];
var datos2 = point.split('P');
var fila = datos2[0]; var columna= datos2[1];

var val=document.getElementById(i).value;



var CR=document.getElementById('CR'+fila);
var CA=document.getElementById('CA'+fila);
var stock=document.getElementById('Stock'+fila).value;
var stock2=CA.value;
var ncol=document.getElementById('columnas').value;

var a=0; var rep=0;
while (a < ncol){a++;
if(document.getElementById('CI'+ fila + 'P' + a)){
var rep=rep + ((document.getElementById('CI'+ fila + 'P' + a).value) *1);	
}
}



if(part=='A'){
var alar=	document.getElementById('AI'+ fila + 'P' + columna).value;
var iddet=	document.getElementById('BI'+ fila + 'P' + columna).value;	
var url='/ajax/updatedetreparto.php?iddetr=' +iddet + '&alarma=' + alar;
}


if(part=='C'){
var newalmacen=document.getElementById('sumatorio'+ fila).value;
var newalmacen=newalmacen - rep;	
CR.value=rep;
CA.value=newalmacen;
document.getElementById('AI'+ fila + 'P' + columna).value=Math.round((val/100)*alarma);



var alar=	document.getElementById('AI'+ fila + 'P' + columna).value;
var iddet=	document.getElementById('BI'+ fila + 'P' + columna).value;
var idrept=	document.getElementById('idrep').value;
var idarti=	document.getElementById('idarti'+ fila).value;

var url='/ajax/updatedetreparto.php?iddetr=' +iddet + '&cant=' + val + '&alarma=' + alar + '&idrept=' + idrept + '&columna=' + columna + '&idarti=' + idarti + '&stock=' + newalmacen;
}



$.getJSON(url, function(data) {
$.each(data, function(key, val) {

});
});

if(document.getElementById('AI'+ fila + 'P' + columna).value==0){document.getElementById('AI'+ fila + 'P' + columna).value='';};
if (val==0){document.getElementById(i).value="";};	
}


function estadoT(estado){

}

function sumatienda(tienda,TIE){

var iframe = document.getElementById('repartos');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
var filas=innerDoc.getElementById('filas').value;

	
var i=0;var suma=0;
while(i < filas){i++;
var dato=innerDoc.getElementById('CI' + i + 'P' + tienda).value;	
var suma=(suma*1)+(dato*1);	
}

alert(TIE + ': ' + suma);	
}

function cambiEstado(estado){

var iframe = document.getElementById('repartos');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
var idREP=innerDoc.getElementById('idrep').value;

var url='/ajax/cambiaEstREP.php?idrep=' + idREP + '&estado=' + estado;

$.getJSON(url, function(data) {
$.each(data, function(key, val) {
});
});	

if(estado=='A'){var textE='En Almacén';};
if(estado=='T'){var textE='Enviado a Tiendas';};
document.getElementById('eREP').innerHTML=textE;
	
}

function pegarLIN(){
$.ajaxSetup({'async': false});	
timer(1);
var iframe = document.getElementById('repartos');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
var LinCOP=innerDoc.getElementById('LinCOP').value;	
var filsel=innerDoc.getElementById('filsel').value;
var columnas=innerDoc.getElementById('columnas').value;


var idarti_new="";
var idarti=	innerDoc.getElementById('idarti'+ LinCOP).value;
var Afilsel=filsel.split(',');
for (var i = 0; i < Afilsel.length; i++) {var a=0;
var idarti_new=idarti_new +	innerDoc.getElementById('idarti'+ Afilsel[i]).value + ',';

	innerDoc.getElementById('F' + Afilsel[i]).setAttribute("style", "background-color:white;");
	innerDoc.getElementById('trC' + Afilsel[i]).setAttribute("style", "background-color:white;");
	innerDoc.getElementById('trA' + Afilsel[i]).setAttribute("style", "background-color:white;");	


}


var url='/ajax/copiReparto.php?idarticulo=' +idarti + '&idarticulo_new=' + idarti_new;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
	
var iframe = document.getElementById('repartos');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
	
var filaart=innerDoc.getElementById(key).value;
var newssto=innerDoc.getElementById('Stock' + filaart).value -val;
innerDoc.getElementById('CA' + filaart).value=newssto;

});
});


for (var i = 0; i < Afilsel.length; i++) {var a=0;
var repartidas=0;	
while (a < columnas){a++;
vcopio=innerDoc.getElementById('CI' + LinCOP + 'P' + a).value;
vacopio=innerDoc.getElementById('AI' + LinCOP + 'P' + a).value;
repartidas=(repartidas*1)+(vcopio*1);


if(vcopio>0){
innerDoc.getElementById('CI' + Afilsel[i] + 'P' + a).value=vcopio;
innerDoc.getElementById('AI' + Afilsel[i] + 'P' + a).value=vacopio;
}}

innerDoc.getElementById('CR' + Afilsel[i]).value=repartidas;
}



innerDoc.getElementById('LinCOP').value="";	
innerDoc.getElementById('filsel').value="";
document.getElementById('pegar').setAttribute("style", "visibility:hidden;");
timer(0);	
}






function copiarLIN(){

document.getElementById('pegar').setAttribute("style", "visibility:visible;");
var iframe = document.getElementById('repartos');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
var LinCOP=innerDoc.getElementById('filsel').value;

innerDoc.getElementById('F' + LinCOP).setAttribute("style", "background-color:white;");
innerDoc.getElementById('trC' + LinCOP).setAttribute("style", "background-color:white;");
innerDoc.getElementById('trA' + LinCOP).setAttribute("style", "background-color:white;");	

innerDoc.getElementById('LinCOP').value=LinCOP;
innerDoc.getElementById('filsel').value='';		
}

function selectFile(file){
	

	
var filsel=document.getElementById('filsel').value;
var LinCOP=document.getElementById('LinCOP').value;

if(LinCOP==''){

if(filsel!=''){
document.getElementById('F' + filsel).setAttribute("style", "background-color:white;");
document.getElementById('trC' + filsel).setAttribute("style", "background-color:white;");
document.getElementById('trA' + filsel).setAttribute("style", "background-color:white;");		
}
document.getElementById('F' + file).setAttribute("style", "background-color:#CBE9FE;");
document.getElementById('trC' + file).setAttribute("style", "background-color:#CBE9FE;");
document.getElementById('trA' + file).setAttribute("style", "background-color:#CBE9FE;");

document.getElementById('filsel').value=file;

	
}else{
var Afilsel=filsel.split(',');	

var noesta=0;
var newA = [];

for (var i = 0; i < Afilsel.length; i++) {
if(Afilsel[i]>0){
if (file!=Afilsel[i]){
	newA.push(Afilsel[i]);
	}else{
	var noesta=1;
	document.getElementById('F' + file).setAttribute("style", "background-color:white;");
	document.getElementById('trC' + file).setAttribute("style", "background-color:white;");
	document.getElementById('trA' + file).setAttribute("style", "background-color:white;");	
	}    
}}	

if(noesta==0){
newA.push(file);	
document.getElementById('F' + file).setAttribute("style", "background-color:#CBE9FE;");
document.getElementById('trC' + file).setAttribute("style", "background-color:#CBE9FE;");
document.getElementById('trA' + file).setAttribute("style", "background-color:#CBE9FE;");
}	

var filsel="";
for (var i = 0; i < newA.length; i++) {
filsel=filsel + newA[i] + ',';	
}

filsel=filsel.substr(0,(filsel.length)-1);
document.getElementById('filsel').value=filsel;
}
	
}


function moveFieldRepart(value){
		
	var i=$("*:focus").attr("id");
	
	
	
	var datos = i.split('I');
	var part = datos[0]; var point= datos[1];
	
	
	var datos2 = point.split('P');
	var fila = datos2[0]; var columna= datos2[1];
	
	
	
	if(value=='left'){
		columna--;
		var nuevo=part + "I" + fila + "P" + columna;
		};
	
	if(value=='right'){
		columna++;
		var nuevo=part + "I" + fila + "P" + columna;
	};
	
	
	if(value=='up'){
		if(part=='A'){part='C'}else{fila--;part='A';};
		var nuevo=part + "I" + fila + "P" + columna;
	};
	
	if(value=='down'){
		if(part=='C'){part='A'}else{fila++;part='C';};
		var nuevo=part + "I" + fila + "P" + columna;
		};	
	
		
		setTimeout("$('#" + nuevo + "').focus();",10);
	
	

	
}



function marcListRep(){
timer(1);
document.getElementById('repartos').src='/ajax/ListRep.php';	
	
}

function opRep(idrep){
alert(idrep);
}


function ShowDetArt(orig,ida){
var url='/ajax/ShowDetArt.php?idarticulo=' +ida + '&orig=' + orig;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
	
if(key=='datos'){alert(val);};

});
});	
}


