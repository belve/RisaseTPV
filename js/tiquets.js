
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
if(document.getElementById("cobrador").style.visibility=='visible'){cobro_calc();}else{addART();};
}


function addART(){$.ajaxSetup({'async': false});
var tiq="";	
var current=getCookieT('current_emp');
if(getCookieT('tiq_'+current)){
var tiq=getCookieT('tiq_'+current);
}

var cod=document.getElementById('impCod').value;

if(tiq.length>0){var det=tiq.split('<>');}
var repe=0;
var total=0;
var code="";
if(det){
for (var i = 1; i < det.length; i++) {
var deti=det[i];	
var datos=deti.split('|');
if(datos[0]==cod){var QTY=(datos[2]*1)+1;var repe=1;}else{var QTY=datos[2]*1;};

code=code + '<>' + datos[0] + '|' + datos[1] + '|' + QTY + '|' + datos[3];
total=(total*1)+(datos[3]*QTY);
}

}

if(repe==0){
var url='/ajax/addArticulo.php?cod=' + cod;
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


function escapeD(){
if(document.getElementById("cobrador").style.visibility=='visible'){cobro_hide();}else{delTicket();};
}

function cobro_hide(){
document.getElementById("cobrador").style.visibility='hidden';
document.getElementById("impCod").select();	
document.getElementById("do_cam").value="";
document.getElementById("do_pag").value="";
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



function show_cobro_do(){
document.getElementById("cobrador").style.visibility='visible';
document.getElementById("do_pag").select();
document.getElementById('do_tot').value=document.getElementById('do_tot_H').value;
}

function cobro(){
show_cobro_do();

}

function cobro_calc(){
var total=document.getElementById('do_tot_H').value;	
var pagado=	document.getElementById("do_pag").value;
var cambio=(pagado*1)-(total*1);
cambio = cambio.toFixed(2);
document.getElementById("do_cam").value=cambio;
cobro_do();
delTicket();
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
code=code + '&detTick[' + datos[0] + '][q]=' + datos[2] +
			'&detTick[' + datos[0] + '][p]=' + datos[3]; 
total=(total*1)+(datos[3]*datos[2]);			
}}


var url='/ajax/cobro.php?emp=' + emp + '&total=' + total + code;
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
document.getElementById("impCod").select();


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
innerDoc.getElementById("impCod").select();	
		
}



