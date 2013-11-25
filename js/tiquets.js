
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
else if ((document.getElementById("dev_c").style.visibility=='visible')&&(window.top.combo==2)){if(window.top.tickSEARCH2){showDEV();}}
else if (document.getElementById("vregalo").style.visibility=='visible'){printREG();}
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
cod=cod.trim();
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

if(key=="console"){console.log(val);}


if(key=="error"){
alert("Código no encontrado");
document.getElementById("impCod").value="";
document.getElementById("impCod").select();		
}

if(key=="d"){
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
document.getElementById("impCod").select();window.top.tregalsSEL=1;
}else if
(document.getElementById("vregalo").style.visibility=='visible'){
document.getElementById("vregalo").style.visibility='hidden';
document.getElementById("impCod").select();window.top.tregalsSEL=1;
}else if
(document.getElementById("devti").style.visibility=='visible'){
document.getElementById("devti").style.visibility='hidden';
document.getElementById("impCod").select();
document.getElementById('searchT2').setAttribute("style", "color:black;");
document.getElementById('searchT2').value="";window.top.combo=1;
document.getElementById('busqT2').setAttribute("style", "background-color:white;");
window.top.tickSEARCH2=0;
}else if
(document.getElementById("vercaja").style.visibility=='visible'){
document.getElementById("vercaja").style.visibility='hidden';
document.getElementById("impCod").select();window.top.tregalsSEL=1;
}else if
(document.getElementById("manual").style.visibility=='visible'){
document.getElementById("manual").style.visibility='hidden';
document.getElementById("manual_i").value='';
document.getElementById("impCod").select();window.top.tregalsSEL=1;
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
document.getElementById("impCod").value="";
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

var Dtotal=0;
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
if(datos[2]<0){Dtotal=(Dtotal*1)+(datos[3]*datos[2]);};
}
}else{
code='<div class="tCod"></div><div class="tArt"></div><div class="tCan"></div><div class="tpre"></div><div style="clear:both;"></div>';
}

innerDoc.getElementById('tiqcode').innerHTML=code;
total = total.toFixed(2);
document.getElementById('total').innerHTML=total + " €";
document.getElementById('do_tot_H').value=total;
document.getElementById('do_Dtot_H').value=Dtotal;
}

function showdescount(){
var tiq="";	
var current=getCookieT('current_emp');
if(getCookieT('tiq_'+current)){
var tiq=getCookieT('tiq_'+current);
}
	
if(tiq){	
document.getElementById("descuento").style.visibility='visible';
document.getElementById("descount").select();
}	
}

function aplydescuent(){
document.getElementById("descount_H").value=document.getElementById("descount").value;	
document.getElementById("descuento").style.visibility='hidden';	
show_cobro_do();
}


function show_cobro_do(){
document.getElementById("cobrador").style.visibility='visible';
document.getElementById("do_pag").select();

var importe=(document.getElementById('do_tot_H').value)*1;
var Dimporte=(document.getElementById('do_Dtot_H').value)*1;

if(document.getElementById("descount_H").value > 0){
	
importe=importe-Dimporte;	
importe =importe -(importe * document.getElementById("descount_H").value / 100);
importe=importe+Dimporte;
importe = importe.toFixed(2);	
}

document.getElementById('do_tot').value=importe + " €";
}


function movC(W){
if(document.getElementById("dev_c").style.visibility=='visible'){	
var p=window.top.combo; 	
if(W=='ri'){p=p+1;};	
if(W=='le'){p=p-1;};	
if(p<1){p=2;};
if(p>2){p=1;};
if(p==1){$('#impCod').focus().select();  };
if(p==2){$('#searchT2').focus().select();  };	
window.top.combo=p;
}}

function movF(w){
if(document.getElementById("vregalo").style.visibility=='visible'){

window.top.tickSEARCH=0;	
document.getElementById('busqT').setAttribute("style", "background-color:white;");
document.getElementById('searchT').value="";

var p=window.top.tregalsSEL;
var t=window.top.tregals[p];
if(document.getElementById(t)){document.getElementById(t).setAttribute("style", "background-color:white;");};

if(w=='up'){p=p-1;};	
if(w=='dw'){p=p+1;};
if(p<0){p=3;};if(p>3){p=0;};

window.top.tregalsSEL=p;
var t=window.top.tregals[p];
if(document.getElementById(t)){document.getElementById(t).setAttribute("style", "background-color:orange;");}

}}


function showDEV(){
var t=window.top.tickSEARCH2;
document.getElementById("dettiqq").src='/ajax/det_ticket_dev.php?t=' +t;
document.getElementById("devti").style.visibility='visible';	
}


function chkREG2(){
document.getElementById('searchT2').setAttribute("style", "color:black;");
document.getElementById('busqT2').setAttribute("style", "background-color:white;");
window.top.tickSEARCH2=0;	

var it=document.getElementById('searchT2').value; it=it.toUpperCase();
var indt=document.getElementById('idnt').value;
var imn=it.replace(indt,"");

if(it.length>=3){
	
var url="/ajax/chkTICK2.php?idt=" + it;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
if((key=='no')&&(val < 1)){document.getElementById('searchT2').setAttribute("style", "color:red;");	}	
if((key=='no')&&(val > 0)){document.getElementById('searchT2').setAttribute("style", "color:black;");	}	

if(key=='ok'){
document.getElementById('busqT2').setAttribute("style", "background-color:orange;");
document.getElementById('searchT2').setAttribute("style", "color:black;");
window.top.tickSEARCH2=val;
}
	
});
});	
	
	
}
}

function chkREG(){


document.getElementById('searchT').setAttribute("style", "color:black;");
document.getElementById('busqT').setAttribute("style", "background-color:white;");
window.top.tickSEARCH=0;
	
var it=document.getElementById('searchT').value; it=it.toUpperCase();
var indt=document.getElementById('idnt').value;
var imn=it.replace(indt,"");

if(it.length>=1){
if(window.top.tregalsSEL>=0){	
var p=window.top.tregalsSEL;
var t=window.top.tregals[p];
if(document.getElementById(t)){document.getElementById(t).setAttribute("style", "background-color:white;");};	
window.top.tregalsSEL=-1;
}}


if(imn.length==12){

var url="/ajax/chkTICK.php?idt=" + it;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
if(key=='no'){document.getElementById('searchT').setAttribute("style", "color:red;");	}	

if(key=='ok'){
document.getElementById('busqT').setAttribute("style", "background-color:orange;");
document.getElementById('searchT').setAttribute("style", "color:black;");
window.top.tickSEARCH=val;
}
	
});
});
	
}


	
	
}

function vregalo(){	
var current=getCookieT('current_emp');	
var emp=getCookieT('empK_' + current);	
window.top.tregals=new Array();
window.top.tregalsSEL=0;

document.getElementById("vregalo").style.visibility='visible';

var url="/ajax/contREG.php?idemp=" + emp;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {

if(key=='html'){document.getElementById("contREG").innerHTML=val;}else{

window.top.tregals.push(val);

	
}			
	
});
});

document.getElementById('busqT').setAttribute("style", "background-color:white;");
document.getElementById('searchT').value="";
$('#searchT').focus();


}


function printREG(){
var t="";	
if(window.top.tregalsSEL>=0){		
var p=window.top.tregalsSEL;
var t=window.top.tregals[p];
} else if (window.top.tickSEARCH) {
t=window.top.tickSEARCH;}


if(t){
var url='/ajax/regalo.php?t=' + t;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
	
});
});
	
}}

function cobro(){

var tiq="";	
var current=getCookieT('current_emp');
if(getCookieT('tiq_'+current)){
var tiq=getCookieT('tiq_'+current);
}
if(tiq){
show_cobro_do();
}

}


function cambi(){
var total=(document.getElementById('do_tot_H').value)*1;
var Dtotal=(document.getElementById('do_Dtot_H').value)*1;
if(document.getElementById("descount_H").value > 0){
total=total-Dtotal;	
total =total -(total * document.getElementById("descount_H").value / 100);
total=total+Dtotal;
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
var Dtotal=(document.getElementById('do_Dtot_H').value)*1;

if(document.getElementById("descount_H").value > 0){
total=total-Dtotal;	
total =total -(total * document.getElementById("descount_H").value / 100);
total=total+Dtotal;	
total = total.toFixed(2);	
}


	
var pagado=	document.getElementById("do_pag").value;
var cambio=(total*1)-(pagado*1);var check=cambio;
console.log('check:' + check);
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
var Dtotal=0;
var code="";
if(det){
for (var i = 1; i < det.length; i++) {
var deti=det[i];	
var datos=deti.split('|');
code=code + '&detTick[' + i + '][' + datos[0] + '][q]=' + datos[2] +
			'&detTick[' + i + '][' + datos[0] + '][p]=' + datos[3]; 
total=(total*1)+(datos[3]*datos[2]);
if(datos[2]<0){Dtotal=(Dtotal*1)+(datos[3]*datos[2]);};			
}}

var desc=0;
if(document.getElementById("descount_H").value > 0){
desc=document.getElementById("descount_H").value;	
total=total-Dtotal;
total =total -(total * document.getElementById("descount_H").value / 100);
total=total+Dtotal;
total = total.toFixed(2);	
}


var url='/ajax/cobro.php?emp=' + emp + '&desc=' + desc + '&total=' + total + code;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {

if(key=='t'){document.getElementById("tregalo").value=val;}			
	
});
});


}

document.getElementById("impCod").value="";
document.getElementById("impCod").select();
document.getElementById("dev_h").value=0;
document.getElementById("dev_c").style.visibility='hidden';
}

function regalo(){
var t=document.getElementById("tregalo").value;
var url='/ajax/regalo.php?t=' + t;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
	
});
});
	
}


function vale(){
var f=document.getElementById("maxF").value;
var i=document.getElementById("imp").value;

if((f)&&(i)){
var url='/ajax/vale.php?f=' + f + '&i=' + i; 
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
	
});
});
}else{alert('Debe indicar validez e importe');}
	
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
document.getElementById("dev_c").style.visibility='hidden';	


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
innerDoc.getElementById("dev_c").style.visibility='hidden';
		
}

function devolucion(){

if(document.getElementById("dev_h").value==1){
document.getElementById("dev_h").value=0;
document.getElementById("dev_c").style.visibility='hidden';
window.top.combo=1;
$('#impCod').focus().select();  
}else{
document.getElementById("dev_h").value=1;
document.getElementById("dev_c").style.visibility='visible';
window.top.combo=2;
$('#searchT2').focus().select(); 	
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


function opencaj(){
var url='/ajax/openCAJ.php';
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
	
});
});	
	
}




function desglosecaja(){
var url='/ajax/vercaja.php?a=i';
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
if(key=='c'){
document.getElementById("detcaja").innerHTML=val;	
document.getElementById("vercaja").style.visibility='visible';
}
			
	
});
});	
	
}

