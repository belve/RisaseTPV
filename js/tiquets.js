
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



function cargaEmpleados(){

$.ajaxSetup({'async': false});	
var url='/ajax/cargaempleados.php';
$.getJSON(url, function(data) {
var count=0;	
$.each(data, function(key, val) {
if(key=='count'){
	setCookieT('num_emp',val,1);
}else{
count++;

setCookieT('empK_' + count,key,1);
setCookieT('empN_' + count,val,1);
	
}

});
});	

show_emp(1);	
	
}


function introD(){
if      (document.getElementById("cajon").style.visibility=='visible'){cobro_hide();}
else if (document.getElementById("cobrador").style.visibility=='visible'){cobro_calc();}
else if (document.getElementById("descuento").style.visibility=='visible'){aplydescuent();}
else if (document.getElementById("vercaja").style.visibility=='visible'){document.getElementById("vercaja").style.visibility='hidden';}
else{addART();};
}


function addART(){$.ajaxSetup({'async': false});
var tiq="";	
var current=getCookieT('current_emp');
if(getCookieT('tiq_'+current)){
var tiq=getCookieT('tiq_'+current);
}

var cod=document.getElementById('impCod').value;
var mod=document.getElementById("dev_h").value;

var check=0;
if ((cod==10009999)||(cod==20009999)||(cod==30009999)||(cod==40009999)||(cod==50009999)||(cod==60009999)||(cod==70009999)||(cod==80009999)||(cod==90009999)){var check=1;
if(document.getElementById("manual").style.visibility=='hidden'){
document.getElementById("manual").style.visibility='visible';
document.getElementById("manual_i").value='';
document.getElementById("manual_i").select();
}else{document.getElementById("manual").style.visibility='hidden';};	
}






if(document.getElementById("manual").style.visibility=='hidden'){
var manual=document.getElementById("manual_i").value;
document.getElementById("manual_i").value='';
	
if(tiq.length>0){var det=tiq.split('<>');}
var repe=0;
var total=0;
var code="";
if(det){
for (var i = 1; i < det.length; i++) {
var deti=det[i];	
var datos=deti.split('|');
if(mod==1){var mas=-1;}else{var mas=1;};
if((datos[0]==cod)&&(check==0)&&(mod!=1)&&(datos[2]>0)){var QTY=(datos[2]*1)+mas;var repe=1;}else{var QTY=datos[2]*1;};

code=code + '<>' + datos[0] + '|' + datos[1] + '|' + QTY + '|' + datos[3];
total=(total*1)+(datos[3]*QTY);
}

}



if(repe==0){
var url='/ajax/addArticulo.php?cod=' + cod + '&mod=' + mod + '&manual=' + manual;


$.getJSON(url, function(data) {
$.each(data, function(key, val) {

if(val=="error"){
alert("Código no encontrado");		
}else{
tiq=tiq + val;	
}			
	
});
});
}else{
tiq=code;	
}


setCookieT('tiq_'+ current,tiq,1);	
showTicket();
document.getElementById("impCod").select();
}


}


function escapeD(){
if(document.getElementById("cobrador").style.visibility=='visible'){cobro_hide();}
else if
(document.getElementById("descuento").style.visibility=='visible'){
document.getElementById("descuento").style.visibility='hidden';
}else if
(document.getElementById("vercaja").style.visibility=='visible'){
document.getElementById("vercaja").style.visibility='hidden';
}else if
(document.getElementById("manual").style.visibility=='visible'){
document.getElementById("manual").style.visibility='hidden';
document.getElementById("manual_i").value='';
document.getElementById("impCod").select();
}
else{delTicket();};

document.getElementById("descount_H").value='';
document.getElementById("descount").value='';
document.getElementById("do_pag").value='';

}

function cobro_hide(){
document.getElementById("cajon").style.visibility='hidden';
document.getElementById("cobrador").style.visibility='hidden';
document.getElementById("impCod").select();	
document.getElementById("do_cam").value="";
document.getElementById("do_pag").value="";
document.getElementById("descount_H").value='';
document.getElementById("descount").value='';
}


function delTicket(){
var tiq="";	
var current=getCookieT('current_emp');
setCookieT('tiq_'+ current,tiq,1);	
showTicket();
document.getElementById("impCod").select();
}

function showTicket(){
var tiq="";	
var current=getCookieT('current_emp');
if(getCookieT('tiq_'+current)){
var tiq=getCookieT('tiq_'+current);
}


var iframe = document.getElementById('dettiq');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
innerDoc.getElementById('tiqcode').innerHTML='';

if(tiq.length>0){var det=tiq.split('<>');}

var total=0;
var code="";
if(det){
for (var i = 1; i < det.length; i++) {
var deti=det[i];	
var datos=deti.split('|');
code=code + '<div class="tCod">' + datos[0] + '</div>' +
'<div class="tArt">' + datos[1] + '</div>' + 
'<div class="tCan">' + datos[2] + '</div>' +
'<div class="tpre">' + datos[3] + '</div> <div style="clear:both;"></div>';
total=(total*1)+(datos[3]*datos[2]);
}
}else{
code='<div class="tCod"></div><div class="tArt"></div><div class="tCan"></div><div class="tpre"></div><div style="clear:both;"></div>';
}

innerDoc.getElementById('tiqcode').innerHTML=code;
total = total.toFixed(2);
document.getElementById('total').innerHTML=total + " €";
document.getElementById('do_tot_H').value=total;
}

function showdescount(){
document.getElementById("descuento").style.visibility='visible';
document.getElementById("descount").select();
	
}

function aplydescuent(){
document.getElementById("descount_H").value=document.getElementById("descount").value;	
document.getElementById("descuento").style.visibility='hidden';	
show_cobro_do();
}


function show_cobro_do(){
document.getElementById("cobrador").style.visibility='visible';
document.getElementById("do_pag").select();

var importe=document.getElementById('do_tot_H').value

if(document.getElementById("descount_H").value > 0){
importe =importe -(importe * document.getElementById("descount_H").value / 100);
importe = importe.toFixed(2);	
}

document.getElementById('do_tot').value=importe + " €";
}

function cobro(){
show_cobro_do();

}


function cambi(){
var total=document.getElementById('do_tot_H').value;

if(document.getElementById("descount_H").value > 0){
total =total -(total * document.getElementById("descount_H").value / 100);
total = total.toFixed(2);	
}
	
var pagado=	document.getElementById("do_pag").value;
var cambio=(total*1)-(pagado*1);
cambio = cambio.toFixed(2);
if(cambio <= 0 ){cambio=cambio + ' €';}else{cambio='';};
document.getElementById("do_cam").value=cambio;
	
}

function cobro_calc(){
var total=document.getElementById('do_tot_H').value;

if(document.getElementById("descount_H").value > 0){
total =total -(total * document.getElementById("descount_H").value / 100);
total = total.toFixed(2);	
}


	
var pagado=	document.getElementById("do_pag").value;
var cambio=(total*1)-(pagado*1);var check=cambio;

if(check <= 0){
cambio = cambio.toFixed(2) + ' €';
document.getElementById("do_cam").value=cambio;
document.getElementById("cajon").style.visibility='visible';	
cobro_do();
delTicket();

}
}

function cobro_do(){
var tiq="";	
var current=getCookieT('current_emp');
var emp=getCookieT('empK_' + current);

if(getCookieT('tiq_'+current)){
var tiq=getCookieT('tiq_'+current);
}


var iframe = document.getElementById('dettiq');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
innerDoc.getElementById('tiqcode').innerHTML='';

if(tiq.length>0){var det=tiq.split('<>');

var total=0;
var code="";
if(det){
for (var i = 1; i < det.length; i++) {
var deti=det[i];	
var datos=deti.split('|');
code=code + '&detTick[' + i + '][' + datos[0] + '][q]=' + datos[2] +
			'&detTick[' + i + '][' + datos[0] + '][p]=' + datos[3]; 
total=(total*1)+(datos[3]*datos[2]);			
}}

var desc=0;
if(document.getElementById("descount_H").value > 0){
desc=document.getElementById("descount_H").value;	
total =total -(total * document.getElementById("descount_H").value / 100);
total = total.toFixed(2);	
}


var url='/ajax/cobro.php?emp=' + emp + '&desc=' + desc + '&total=' + total + code;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {

			
	
});
});


}	
}



function loop_emp(){
var current=getCookieT('current_emp');	
var total=getCookieT('num_emp');	
if(current==total){current=1;}else{current++;};
show_emp(current)	;
}

function show_emp(numemp){
setCookieT('current_emp',numemp,1);
document.getElementById('emple').innerHTML=getCookieT('empN_' + numemp);
document.getElementById("impCod").value="";
document.getElementById("impCod").select();
document.getElementById("dev_h").value=0;
document.getElementById("dev_c").innerHTML='';	


showTicket();
}


function loop_emp2(){
var current=getCookieT('current_emp');	
var total=getCookieT('num_emp');	
if(current==total){current=1;}else{current++;};
show_emp2(current)	;
}

function show_emp2(numemp){
setCookieT('current_emp',numemp,1);
var iframe = document.getElementById('f_v_1');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
innerDoc.getElementById('emple').innerHTML=getCookieT('empN_' + numemp);
innerDoc.getElementById("impCod").value="";	
innerDoc.getElementById("impCod").select();	
innerDoc.getElementById("dev_h").value=0;
innerDoc.getElementById("dev_c").innerHTML='';	
		
}

function devolucion(){

if(document.getElementById("dev_h").value==1){
document.getElementById("dev_h").value=0;
document.getElementById("dev_c").innerHTML='';	
}else{
document.getElementById("dev_h").value=1;
document.getElementById("dev_c").innerHTML='MODO DEVOLUCIÓN';	
}

	
}


function vercaja(){
var url='/ajax/vercaja.php?a=v';
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
if(key=='c'){
document.getElementById("detcaja").innerHTML=val;	
document.getElementById("vercaja").style.visibility='visible';
}
			
	
});
});	
	
}



