
$('.example-default-value').each(function() {
    var default_value = this.value;
    $(this).focus(function() {
        if(this.value == default_value) {
            this.value = '';
        }
    });
    $(this).blur(function() {
        if(this.value == '') {
            this.value = default_value;
        }
    });
});


function mainmenu(){
// Oculto los submenus
$(" #nav ul ").css({display: "none"});
// Defino que submenus deben estar visibles cuando se pasa el mouse por encima
$(" #nav li").hover(function(){
    $(this).find('ul:first:hidden').css({visibility: "visible",display: "none"}).slideDown(400);
    },function(){
        $(this).find('ul:first').slideUp(400);
    });
}
$(document).ready(function(){
    mainmenu();
});


function cwin(value){
$("#"+value).remove();
$("#m_"+value).remove();
}



function focusW(value){

	var i=1;
			while (i<25)
			  {
			if(document.getElementById("v_"+i)){
				document.getElementById("v_"+i).style.display = "none";
				document.getElementById("m_v_"+i).setAttribute("class", "minimi_off")  
			}
			  i++;
			}

	document.getElementById(value).style.display = "block";
	document.getElementById("m_"+value).setAttribute("class", "minimi_on"); 
	
	
	var iframe = document.getElementById("f_"+value);
	var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
	
	if(innerDoc.getElementById('impCod')){innerDoc.getElementById('impCod').focus();}
	if(innerDoc.getElementById('impCodD')){innerDoc.getElementById('impCodD').focus();} 
	if(innerDoc.getElementById('impCodA')){innerDoc.getElementById('impCodA').focus();}
	if(innerDoc.getElementById('imp')){innerDoc.getElementById('imp').focus();}
	
	
}



function owin(value,tit,param){
			var i=1;
			while (i<25)
			  {
			if(document.getElementById("v_"+i)){
				document.getElementById("v_"+i).style.display = "none";
				document.getElementById("m_v_"+i).setAttribute("class", "minimi_off")  
			}
			  i++;
			}
	
	
	
	
	if(document.getElementById(value)) {
	document.getElementById(value).style.display = "block"; 
	document.getElementById("m_"+value).setAttribute("class", "minimi_on");  	
	
	
	
	
	}else{
	var html='<div id="' + value +'" class="'+ value  + '"><div class="contenedor gris2_BG shadow"><div class="cabcontenerdor"><div class="tit_contenedor">'+ tit +
	'</div><div class="iconos closeW" onclick="javascript:cwin(\'' +	 value + '\')"></div></div><div class="iframe"><iframe id="f_' + value + '" src="/ventanas/'+ value +'.php' + param + '" width="100%" height="100%" border="0" frameborder="0" marginheight="0" scrolling="no"></iframe></div></div></div>';
	$('#ventanas').append(html);
	
	var minhtml='<div class="minimi_on" id="m_' + value +'" onclick="javascript:focusW(\''+ value +'\')">' + tit + '<div class="iconos closeW"  onclick="javascript:cwin(\'' + value + '\')"></div></div>';
	$('#minimizadas').append(minhtml);
	}
	
}


function addSlashes(input) {
    var v = input.value;
    if (v.match(/^\d{2}$/) !== null) {
        input.value = v + '/';
    } else if (v.match(/^\d{2}\/\d{2}$/) !== null) {
        input.value = v + '/';
    }
}




function timer(w){

if(w==0){document.getElementById("timer").style.visibility = "hidden";};
if(w==1){document.getElementById("timer").style.visibility = "visible";};	
	
}



function cargasubgrupo (id) {
 $("#4").load("/ajax/subgruposparalist.php?id=" + id); 
}





function listaArticulos(tab,ord){
timer(1);
var prov=document.getElementById(2).value
var grup=document.getElementById(3).value
var subg=document.getElementById(4).value
var colo=document.getElementById(5).value
var codi=document.getElementById(6).value
var pvp=document.getElementById(7).value
var desd=document.getElementById(8).value
var hast=document.getElementById(9).value
var temp=document.getElementById(10).value
var detalles=document.getElementById(11).value
var comentarios=document.getElementById(12).value
	
url = "/ajax/listarticulos.php?id_proveedor=" + prov
 + "&id_grupo=" + grup
 + "&id_subgrupo=" + subg
 + "&id_color=" + colo
 + "&codigo=" + codi
 + "&pvp=" + pvp
 + "&desde=" + desd
 + "&hasta=" + hast
 + "&detalles=" + detalles
 + "&comentarios=" + comentarios
 + "&tab=" + tab
 + "&ord=" + ord
 + "&temporada=" + temp;


document.getElementById('articulos').src=url;
 	
}
  



function example_append() {
    $('#example').append('jajajajajaj');
}

function borra(){
	$("#dd").remove();
}