
function timerAD(w,cual,donde){

if(donde==0){
if(w==0){document.getElementById(cual).style.visibility = "hidden";document.body.style.cursor = 'default';};
if(w==1){document.getElementById(cual).style.visibility = "visible";document.body.style.cursor = 'wait';};	
}

if(donde==1){
if(w==0){parent.document.getElementById(cual).style.visibility = "hidden";document.body.style.cursor = 'default';};
if(w==1){parent.document.getElementById(cual).style.visibility = "visible";document.body.style.cursor = 'wait';};	
}
	
}


function selectAgrup(id,tip){
var lastsel=document.getElementById('agrupSel').value;
if(lastsel!=id){
if(lastsel!=''){document.getElementById(lastsel).setAttribute("style", "background-color:white;");};	
if(document.getElementById(id)){
document.getElementById(id).setAttribute("style", "background-color:#8DC29E;");		
document.getElementById('agrupSel').value=id;
detAgrupado(id,tip);
};
}}


function cargaPendientes(tip){$.ajaxSetup({'async': false});	
timerAD(1,'timer1',0);

var url='/ajax/actionPedidos.php?tip=' + tip + '&action=1';
$.getJSON(url, function(data) {
$.each(data, function(key, val) {

var iframe = document.getElementById('pedipent');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
innerDoc.getElementById('artselected').value='';
if(key=='html'){innerDoc.getElementById('pedipent').innerHTML=val;};		
	
});
});	

timerAD(0,'timer1',0);
}


function cargaAgrupados(tip,agrupar){$.ajaxSetup({'async': false});	
timerAD(1,'timer2',0);

var url='/ajax/actionPedidos.php?tip=' + tip + '&action=2&agrupar=' + agrupar;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {

var iframe = document.getElementById('agrupaciones');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
if(key=='html'){innerDoc.getElementById('agrupaciones').innerHTML=val;};		
	
});
});	

timerAD(0,'timer2',0);
	
}	


function newAgrup(tip){timerAD(1,'timer2',0);
var nom=document.getElementById('newgrup').value;
var url='/ajax/newAgrup.php?nom=' + nom + '&tip=' + tip;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
var iframe = document.getElementById('agrupaciones');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;

if(key=='id'){
var lista=innerDoc.getElementById('agrupaciones');	
$(lista).append("<div class='agrup' id='" + val + "' onclick='selectAgrup(" + val + ")'>" + nom + "<div class='iconos trash' onclick='borra_agru(" + val + "," + tip + ")'></div> </div>");

var iframe = document.getElementById('FV2P1');
var V = iframe.contentDocument || iframe.contentWindow.document;
var addf="<div class='agrup_V2' id='" + val + "' onclick='selV2agrup(\"" + val + "|1\")'>" + nom + "</div>";
$(V).find('#agrupaciones').append(addf);

}

if(key=='error'){
alert(val);
}	

});
});		
timerAD(0,'timer2',0);
}

function modiAgrup(nom){
var idagr=document.getElementById('agrupSel').value;
var url='/ajax/updatefield.php?id=' + idagr + '&campo=nombre&tabla=agrupedidos&value=' + nom;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
});
});		

}

function autoagrupar(tip){$.ajaxSetup({'async': false});	
cargaAgrupados(tip,1);
var iframe = document.getElementById('pedipent');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
innerDoc.getElementById('pedipent').innerHTML='';
cargaAgrupados2(tip,0);	
}



function detAgrupado(id,tip){$.ajaxSetup({'async': false});	
timerAD(1,'timer3',1);

var url='/ajax/actionPedidos.php?tip=' + tip + '&action=3&id=' + id;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {

var iframe = parent.document.getElementById('pediagrup');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
innerDoc.getElementById('artselected').value='';
if(key=='html'){innerDoc.getElementById('pedipent').innerHTML=val;};		
	
});
});	

timerAD(0,'timer3',1);
	
}	




function selART(idart){
var filas=[];var nohagas=0;var ini=0; var fin=0;
		
var ctrl=top.document.getElementById('crtl').value; 
var ini=document.getElementById('ini').value; 
var fin=document.getElementById('fin').value; 


if(ctrl==1){

	if(ini==0){document.getElementById('ini').value=document.getElementById('I' + idart).value;var nohagas=1;};
		
	if(ini>0){
	var fin=document.getElementById('I' + idart).value;
	var finB=fin;
	var iniB=ini;
	
	if(ini > fin){var fin2=ini; ini=fin; fin=fin2;};
	while (ini <= fin){filas.push(document.getElementById('F' + ini).value); ini++;}; 
	document.getElementById('ini').value=0;document.getElementById('fin').value=0;	
	}

}else{
	filas.push(idart);document.getElementById('ini').value=0;document.getElementById('fin').value=0;		
}

/*alert('ctrl:' + ctrl + '\n' + 'ini:' + iniB + '\n' + 'fin:' + finB + '\n');*/

if(nohagas==0){
	for (var i = 0; i < filas.length; i++) {
	if(filas[i]){
	var idart=filas[i];
	selecciona(idart);
	}}
}



}


function selecciona(idart){
var newlist='';
var artselected=document.getElementById('artselected').value; 
var art=artselected.split(',');
var esta=0;
	
for (var i = 0; i < art.length; i++) {
if(art[i]!=''){
	if(art[i]==idart){document.getElementById(idart).setAttribute("style", "background-color:white;");esta=1;}else{newlist=newlist + art[i] + ',';}
}	
}
			
if(esta==0){document.getElementById(idart).setAttribute("style", "background-color:#8DC29E;");newlist=newlist + idart + ',';};		

newlist=newlist.substr(0,(newlist.length)-1);
document.getElementById('artselected').value=newlist;
document.getElementById('ini').value=0;document.getElementById('fin').value=0;	
}




function sacaAgrup(tip){
var iframe = document.getElementById('agrupaciones');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
var agrupacion=innerDoc.getElementById('agrupSel').value;	

var iframe = document.getElementById('pediagrup');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
var seleccionados=innerDoc.getElementById('artselected').value;

var url='/ajax/cambiaagrupa.php?tip=' + tip + '&oldG=' + agrupacion + '&newG=' + '' + '&selecion=' + seleccionados;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {

		
	
});
});	


cargaPendientes(tip);

timerAD(1,'timer3',0);

var url='/ajax/actionPedidos.php?tip=' + tip + '&action=3&id=' + agrupacion;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {

var iframe = document.getElementById('pediagrup');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
innerDoc.getElementById('artselected').value='';
if(key=='html'){innerDoc.getElementById('pedipent').innerHTML=val;};		
	
});
});	

timerAD(0,'timer3',0);

	
}



function meteAgrup(tip){
var iframe = document.getElementById('agrupaciones');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
var agrupacion=innerDoc.getElementById('agrupSel').value;	

var iframe = document.getElementById('pedipent');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
var seleccionados=innerDoc.getElementById('artselected').value;

var url='/ajax/cambiaagrupa.php?tip=' + tip + '&oldG=' + '' + '&newG=' + agrupacion + '&selecion=' + seleccionados;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {

		
	
});
});	


cargaPendientes(tip);

timerAD(1,'timer3',0);

var url='/ajax/actionPedidos.php?tip=' + tip + '&action=3&id=' + agrupacion;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {

var iframe = document.getElementById('pediagrup');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
innerDoc.getElementById('artselected').value='';
if(key=='html'){innerDoc.getElementById('pedipent').innerHTML=val;};		
	
});
});	

timerAD(0,'timer3',0);

	
}



function selPEST(p){
var estAct=document.getElementById(p).className;
if(estAct=='PestaniaOFF'){


if(p=='P1'){
document.getElementById('DV2P1').setAttribute("style", "visibility:hidden;");
document.getElementById('DV2P2').setAttribute("style", "visibility:hidden;");
document.getElementById('DV2P3').setAttribute("style", "visibility:hidden;");
document.getElementById('DV2P4').setAttribute("style", "visibility:hidden;");	
}

if(p=='P2'){
document.getElementById('DV2P1').setAttribute("style", "visibility:hidden;");
document.getElementById('DV2P2').setAttribute("style", "visibility:hidden;");
document.getElementById('DV2P3').setAttribute("style", "visibility:hidden;");
document.getElementById('DV2P4').setAttribute("style", "visibility:hidden;");	
document.getElementById('V2P1').className="V2_PEST_off";	
document.getElementById('V2P2').className="V2_PEST_off";	
document.getElementById('V2P3').className="V2_PEST_off";	
document.getElementById('V2P4').className="V2_PEST_off";

var V2=document.getElementById('V2SEL').value;
document.getElementById('D' + V2).setAttribute("style", "visibility:visible;");
document.getElementById(V2).className="V2_PEST_on";
}


document.getElementById('P1').className="PestaniaOFF";	
document.getElementById('P2').className="PestaniaOFF";	

document.getElementById('VP1').setAttribute("style", "visibility:hidden !important;");
document.getElementById('VP2').setAttribute("style", "visibility:hidden !important;");

document.getElementById(p).className="PestaniaON";	
document.getElementById('V' + p).setAttribute("style", "visibility:visible !important;");
	
	
	
}	
}


function selPEST_V2(p){
var estAct=document.getElementById(p).className;



if(estAct=='V2_PEST_off'){
	
	
	
document.getElementById('V2P1').className="V2_PEST_off";	
document.getElementById('V2P2').className="V2_PEST_off";	
document.getElementById('V2P3').className="V2_PEST_off";	
document.getElementById('V2P4').className="V2_PEST_off";

document.getElementById('DV2P1').setAttribute("style", "visibility:hidden;");
document.getElementById('DV2P2').setAttribute("style", "visibility:hidden;");
document.getElementById('DV2P3').setAttribute("style", "visibility:hidden;");
document.getElementById('DV2P4').setAttribute("style", "visibility:hidden;");

document.getElementById('V2SEL').value=p;

document.getElementById(p).className="V2_PEST_on";	
document.getElementById('D' + p).setAttribute("style", "visibility:visible;");	
	
}	
}








function cargaAgrupados2(tip,agrupar){	





var url='/ajax/listAgrupV2.php?tip=' + tip + '&action=1&agrupar=' + agrupar;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {


var str=val.toString();
var valu=str.replace(/,/g, '');

if(key=='P'){
	var iframe = document.getElementById('FV2P1');
	var P = iframe.contentDocument || iframe.contentWindow.document;
	P.getElementById('agrupaciones').innerHTML=valu;};
			
if(key=='A'){
	var iframe = document.getElementById('FV2P2');
	var A = iframe.contentDocument || iframe.contentWindow.document;
	A.getElementById('agrupaciones').innerHTML=valu;};
		
if(key=='T'){
	var iframe = document.getElementById('FV2P3');
	var T = iframe.contentDocument || iframe.contentWindow.document;
	T.getElementById('agrupaciones').innerHTML=valu;};	

if(key=='F'){
	var iframe = document.getElementById('FV2P4');
	var F = iframe.contentDocument || iframe.contentWindow.document;
	F.getElementById('agrupaciones').innerHTML=valu;};	

if(key=='filasP'){document.getElementById('nfV2P1').value=val;};	
if(key=='filasA'){document.getElementById('nfV2P2').value=val;};
if(key=='filasT'){document.getElementById('nfV2P3').value=val;};
if(key=='filasF'){document.getElementById('nfV2P4').value=val;};


	
});
});	


}





function selV2agrup(ida){
var valo=ida.split('|');var ida2=valo[0];	var v=valo[1];
var idag=parent.document.getElementById('ag_selected').value;	
if(idag!=ida2){

var lastPsel=parent.document.getElementById('ag_selected_P').value;	
if(lastPsel && (lastPsel!=parent.document.getElementById('V2SEL').value)){
var iframe = parent.document.getElementById('F' + lastPsel);
var V = iframe.contentDocument || iframe.contentWindow.document;
if(V.getElementById(idag)){V.getElementById(idag).setAttribute("style", "background-color:white;");};
}else{
if(idag){document.getElementById(idag).setAttribute("style", "background-color:white;");};	
}

document.getElementById(ida2).setAttribute("style", "background-color:#8DC29E;");
parent.document.getElementById('ag_selected').value=ida2;
parent.document.getElementById('ag_selected_P').value=parent.document.getElementById('V2SEL').value;
cargaGRIDagru(ida2);
}
}


function cargaGRIDagru(idag){$.ajaxSetup({'async': false});	

timerAD(1,'timer4',1);

var url='/ajax/listGRID.php?idagrupacion=' + idag;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
var iframe = parent.document.getElementById('GRID');
var GRID = iframe.contentDocument || iframe.contentWindow.document;	

if(key=='cabe'){parent.document.getElementById('optCABE').innerHTML=val;};
if(key=='html'){GRID.getElementById('grid').innerHTML=val;};
if(key=='nagru'){parent.document.getElementById('nagru').innerHTML=val;};
if(key=='estado'){pest_Cestado(val,parent.document);};
});
});	
parent.document.getElementById('ag_selected').value=idag;
timerAD(0,'timer4',1);
	
}



function pest_Cestado(est,donde){

donde.getElementById('bot_imp').setAttribute("style", "visibility:hidden;");
if(est=='A'){donde.getElementById('bot_imp').setAttribute("style", "visibility:visible;");};

donde.getElementById('P_E_P').className="pG_estado_off";
donde.getElementById('P_E_A').className="pG_estado_off";
donde.getElementById('P_E_T').className="pG_estado_off";
donde.getElementById('P_E_F').className="pG_estado_off";

if(donde.getElementById('P_E_' + est)){
donde.getElementById('P_E_' + est).className="pG_estado_on";
}

donde.getElementById('est_sel_act').value=est;
}


function cambiaEst_agru(est,tip){$.ajaxSetup({'async': false});	


if(est=='T'){var C=confirm("¿Esta seguro de que desea enviarlo a tiendas?");}else{var C=true;};
if(C){
document.getElementById('bot_imp').setAttribute("style", "visibility:hidden;");
if(est=='A'){document.getElementById('bot_imp').setAttribute("style", "visibility:visible;");};

var oldest=document.getElementById('est_sel_act').value;
timerAD(1,'timer4',0);
var idag=document.getElementById('ag_selected').value;	
if(est=='F'){alert('Los pedidos pasan a estado finalizado de forma automática');}else{
var url='/ajax/listAgrupV2.php?action=2&idag=' + idag + '&newest=' + est;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
});
});	
pest_Cestado(est,document);

if (oldest=='P'){vo='V2P1';};if (oldest=='A'){vo='V2P2';};if (oldest=='T'){vo='V2P3';};if (oldest=='F'){vo='V2P3';};
if (est=='P'){vn='V2P1';};if (est=='A'){vn='V2P2';};if (est=='T'){vn='V2P3';};if (est=='F'){vn='V2P3';};


borradepest(vo,idag);
creaenpest(vn,idag,tip);

}
timerAD(0,'timer4',0);

}}

function creaenpest(v,idag,tip){
	

if(v=='V2P1'){
var nagru=document.getElementById('nagru').innerHTML;
var tip=document.getElementById('tip').value;	
var iframe = document.getElementById('agrupaciones');
var V = iframe.contentDocument || iframe.contentWindow.document;
var addf="<div onclick='selectAgrup(" + idag + "," + tip + ")' id='" + idag + "' class='agrup'>" + nagru + "<div class='iconos trash' onclick='borra_agru(" + idag + "," + tip + ")'> </div>";
$(V).find('#agrupaciones').append(addf);	
}		
	
	
var iframe = document.getElementById('F' + v);
var V = iframe.contentDocument || iframe.contentWindow.document;
var nagru=document.getElementById('nagru').innerHTML;
var nf=document.getElementById('nf' + v).value;
nf++;document.getElementById('nf' + v).value=nf;

document.getElementById('ag_selected_P').value=v;
var vent=v.replace('V2P', '');

var addf="<div class='agrup_V2' id='" + idag + "' onclick='selV2agrup(\"" + idag + "|" + vent + "\")'>" + nagru + "</div>";
$(V).find('#agrupaciones').append(addf);
V.getElementById(idag).setAttribute("style", "background-color:#8DC29E;");
}

function borradepest(v,idag){
if(v=='V2P1'){
var iframe = document.getElementById('agrupaciones');
var V = iframe.contentDocument || iframe.contentWindow.document;
if(V.getElementById('agrupSel').value==idag){

var iframe = document.getElementById('pediagrup');
var V = iframe.contentDocument || iframe.contentWindow.document;
V.getElementById('pedipent').innerHTML='';	
}	
	
var iframe = document.getElementById('agrupaciones');
var V = iframe.contentDocument || iframe.contentWindow.document;
V.getElementById('agrupSel').value='';

$(V).find('#' + idag).remove();		
}	
	
var iframe = document.getElementById('F' + v);
var V = iframe.contentDocument || iframe.contentWindow.document;

var nf=document.getElementById('nf' + v).value;
nf--;document.getElementById('nf' + v).value=nf;

fila='#' + idag;
$(V).find(fila).remove();		

}


function borra_agru(idag,tip){v='V2P1';$.ajaxSetup({'async': false});
var iframe = parent.document.getElementById('agrupaciones');
var V = iframe.contentDocument || iframe.contentWindow.document;
if(V.getElementById('agrupSel').value==idag){

var iframe = parent.document.getElementById('pediagrup');
var V = iframe.contentDocument || iframe.contentWindow.document;
V.getElementById('pedipent').innerHTML='';	
}	
	
var iframe = parent.document.getElementById('agrupaciones');
var V = iframe.contentDocument || iframe.contentWindow.document;
V.getElementById('agrupSel').value='';

$(V).find('#' + idag).remove();	


var iframe = parent.document.getElementById('F' + v);
var V = iframe.contentDocument || iframe.contentWindow.document;

var nf=parent.document.getElementById('nf' + v).value;
nf--;parent.document.getElementById('nf' + v).value=nf;

fila='#' + idag;
$(V).find(fila).remove();	

var ag_selected=parent.document.getElementById('ag_selected').value;
if(ag_selected==idag){
parent.document.getElementById('ag_selected').value="";	
var iframe = parent.document.getElementById('GRID');
var GRID = iframe.contentDocument || iframe.contentWindow.document;	
GRID.getElementById('grid').innerHTML='';
parent.document.getElementById('nagru').innerHTML='';
pest_Cestado('',parent.document);	
}
	

timerAD(1,'timer1',1);

var url='/ajax/cambiaagrupa.php?tip=' + tip + '&oldG=' + idag + '&newG=' + '' + '&selecion=all';
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
});
});		
	


var url='/ajax/actionPedidos.php?tip=' + tip + '&action=1';
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
var iframe = parent.document.getElementById('pedipent');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
innerDoc.getElementById('artselected').value='';
if(key=='html'){innerDoc.getElementById('pedipent').innerHTML=val;};		
});
});	

timerAD(0,'timer1',1);


	
	
}






function impREPt(){
$.ajaxSetup({'async': false});
var idREP=document.getElementById('ag_selected').value;
var url="/xls/repartoTiendas.php?id=" + idREP;
timerAD(1,'timer',0);
document.getElementById('print').src=url;	
setTimeout("timerAD(0,'timer',0);",16000);
}


	
function impREP(){
$.ajaxSetup({'async': false});
var idREP=document.getElementById('ag_selected').value;
var url="/xls/reparto.php?id=" + idREP;
timerAD(1,'timer',0);
document.getElementById('print').src=url;	

setTimeout("timerAD(0,'timer',0);",16000);


}


function impPED(){
$.ajaxSetup({'async': false});
var idREP=document.getElementById('ag_selected').value;
var url="/xls/pedido.php?id=" + idREP;
timerAD(1,'timer',0);
document.getElementById('print').src=url;	

setTimeout("timerAD(0,'timer',0);",16000);


}

function roturas(tip){
$.ajaxSetup({'async': false});
var idREP=document.getElementById('ag_selected').value;
var url="/xls/roturas.php?tip=" + tip;
timerAD(1,'timer',0);
document.getElementById('print').src=url;	

setTimeout("timerAD(0,'timer',0);",6000);


}



function updtPed(idp,field){
var valor=document.getElementById(field).value;
var url="/ajax/updatefield.php?tabla=pedidos&campo=cantidad&id=" + idp + '&value=' + valor;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
});
});	
}




function moveFieldGRID(value){
		
	var i=$("*:focus").attr("id");
	
	
	
	var datos = i.split('-');
	var fila = datos[0]; var columna= datos[1];
	
	
	
	if(value=='left'){
		columna--;
		var nuevo=fila + "-" + columna;
		};
	
	if(value=='right'){
		columna++;
		var nuevo=fila + "-" + columna;
	};
	
	
	if(value=='up'){
		fila--;
		var nuevo=fila + "-" + columna;
	};
	
	if(value=='down'){
		fila++
		var nuevo=fila + "-" + columna;
		};	
	
	
	if(document.getElementById(nuevo)){
	$('#'+ nuevo).focus();
	}

	
}





