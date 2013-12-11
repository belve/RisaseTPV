<?php

foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");

if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "select (SELECT CONCAT_WS(' ', nombre, apellido1, apellido2) from empleados where empleados.id=dev_tickets.id_empleado) as nemp, 
fecha, importe, descuento from dev_tickets WHERE id_ticket='$t';"; 
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$nemp=$row['nemp']; $ft=$row['fecha']; $importe=$row['importe']; $descuento=$row['descuento'];};

$grid="";$ccc=0;
$queryp= "select id_articulo, (SELECT refprov from articulos where articulos.codbarras=dev_ticket_det.id_articulo) as refprov, 
importe, cantidad from dev_ticket_det WHERE id_ticket='$t' AND cantidad > 0;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$cod=$row['id_articulo']; $refprov=$row['refprov']; $impu=$row['importe']; $cantidad=$row['cantidad'];

$impu2=$impu - ($impu*$descuento/100);
$impu2=round($impu2,2);

$ccc++;
$grid.="

<div class='tCod'>$cod</div><input type='hidden' id='cod-$ccc' value='$cod'>
<div class='tArt'>$refprov</div><input type='hidden' id='ref-$ccc' value='$refprov'>
<div class='tpre'>$impu</div><input type='hidden' id='imp-$ccc' value='$impu2'>
<div class='tCan'>$cantidad</div><input type='hidden' id='can-$ccc' value='$cantidad'>
<div class='tDev'><input type='text' id='CD-$ccc' value='' class='CDev'></div>



<div style='clear:both;'></div>

";

}


$fecha = new DateTime($ft);
$ftt= $fecha->format('d/m/Y');
$fecha->add(new DateInterval('P15D'));
$maxD= $fecha->format('d/m/Y');
$maxDFC= ($fecha->format('Ymd'))*1;
$hoy=(date('Y') . date('m') . date('d'))*1;


if($hoy > $maxDFC){$colo="red";}else{$colo="#0000FF";};

if (!$dbnivel->close()){die($dbnivel->error());};



?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>


	
	
<script type="text/javascript">



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


//window.top.devuCODS=new Array();
//window.top.devuREFS=new Array();
//window.top.devuIMPS=new Array();
//window.top.devuCANT=new Array();

window.top.combo=1;    

   // Register keypress events on the whole document
   $(document).keypress(function(e) {
   	
   //alert(e.keyCode);
      switch(e.keyCode) { 
        
         case 13:
         introDT();
         return false;	
         break;
      		
		 case 38:
         movF('up');
         return false;	
         break;
		
		  case 40:
         movF('dw');
         return false;	
         break;
		 
          case 27:
         escapeD();
         return false;	
         break;      
      

         
      }
   });
   
window.top.devC=1;
window.top.MdevC=<?php echo $ccc;?>;

function movF(w){
var c=window.top.devC;
if(w=='dw'){c=c+1;}
if(w=='up'){c=c-1;}
if(c<1){c=window.top.MdevC;}	
if(c>window.top.MdevC){c=1;}
window.top.devC=c;
$('#CD-' + c).focus().select();
}

function introDT(){

var m=window.top.MdevC;

var devuCODS=new Array();
var devuREFS=new Array();
var devuIMPS=new Array();
var devuCANT=new Array();
var nodo=new Array();

for (var a=1; a <= m ; a++){
	var ct=(document.getElementById("CD-" + a).value)*1;
	
if(ct){

if(ct > (document.getElementById("can-" + a).value)){alert('No puede devolver un numero superior de articulos'); $('#CD-' + a).focus().select(); break;var noo=1;}else{var noo=0;};	
	
devuCODS[a]=document.getElementById("cod-" + a).value;
devuREFS[a]=document.getElementById("ref-" + a).value;
devuIMPS[a]=document.getElementById("imp-" + a).value;
devuCANT[a]=ct * -1;

}

	
}


console.info(devuCODS);
console.info(devuREFS);
console.info(devuIMPS);
console.info(devuCANT);

window.top.devuCODS=devuCODS;
window.top.devuREFS=devuREFS;
window.top.devuIMPS=devuIMPS;
window.top.devuCANT=devuCANT;

if(noo==0){
var tiq="";	
var current=getCookieT('current_emp');
if(getCookieT('tiq_'+current + '_' + window.top.subcarr)){
var tiq=getCookieT('tiq_'+current + '_' + window.top.subcarr);
}

console.log(tiq);
if(tiq.length>0){var det=tiq.split('<>');}

var repe=0;
var total=0;
var code="";

if(det){
for (var i = 1; i < det.length; i++) {
var deti=det[i];	
var datos=deti.split('|');

var cdb=datos[0];  var qty=datos[2]; var imp=datos[3] *1; imp=imp.toFixed(2); var o=devuCODS.indexOf(cdb);

if(o){
	
		if((qty<0)&&(imp==devuIMPS[o])){nodo.push(cdb);
		code=code + '<>' + datos[0] + '|' + datos[1] + '|' + devuCANT[o] + '|' + imp;	
		}else{
		code=code + '<>' + datos[0] + '|' + datos[1] + '|' + datos[2] + '|' + imp;	
		}
				
	}else{
		var imp=datos[3]*1; imp=imp.toFixed(2);
		code=code + '<>' + datos[0] + '|' + datos[1] + '|' + datos[2] + '|' + imp;	
	}


}
}


console.info(nodo);
if(devuCODS){
for (var i = 1; i < devuCODS.length; i++) {
var a=nodo.indexOf(devuCODS[i]);
		if((a<0)&&(devuCODS[i])){var imp=devuIMPS[i]*1; imp=imp.toFixed(2);
		 	code=code + '<>' + devuCODS[i] + '|' + devuREFS[i] + '|' + devuCANT[i] + '|' + imp;	
		}
}}



setCookieT('tiq_'+current + '_' + window.top.subcarr,code,1);	
showTicket();
console.log(code);
}}



function showTicket(){
var tiq="";	
var current=getCookieT('current_emp');
if(getCookieT('tiq_'+current + '_' + window.top.subcarr)){
var tiq=getCookieT('tiq_'+current + '_' + window.top.subcarr);
}


var iframe = parent.document.getElementById('dettiq');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
innerDoc.getElementById('tiqcode').innerHTML='';

if(tiq.length>0){var det=tiq.split('<>');}

var total=0;
var Dtotal=0;
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
parent.document.getElementById('total').innerHTML=total + " €";
parent.document.getElementById('do_tot_H').value=total;
parent.document.getElementById('do_Dtot_H').value=Dtotal;

escapeD();
}

function escapeD(){
parent.document.getElementById("devti").style.visibility='hidden';
parent.document.getElementById("impCod").select();
parent.document.getElementById('searchT2').setAttribute("style", "color:black;");
parent.document.getElementById('searchT2').value="";
parent.document.getElementById('busqT2').setAttribute("style", "background-color:white;");
window.top.tickSEARCH2=0;
parent.document.getElementById("dev_h").value=0;
parent.document.getElementById("dev_c").style.visibility='hidden';
window.top.combo=1;
$('#impCod').focus().select();
}

</script>





</head>

<style>
.body {margin:0px;font-family: Arial;}
.tCod {overflow: hidden; text-align:center; padding-top:2px; width:72px; height:18px;  border-right: 1px solid #888888; font-size: 10px; float:left; border-bottom: 1px solid #888888;border-left: 1px solid #888888; padding-left: 3px; background-color: white; }
.tArt {padding-top:2px; width:159px; height:18px; border-right: 1px solid #888888; font-size: 10px; float:left;  border-bottom: 1px solid #888888;padding-left: 3px; background-color: white;}
.tCan {padding-top:2px; width:32px; height:18px;  border-right: 1px solid #888888; font-size: 12px; float:left;text-align: right; border-bottom: 1px solid #888888;padding-right: 3px; background-color: white;}
.tpre {padding-top:2px; width:35px; height:18px;  font-size: 12px; float:left; text-align: right; border-bottom: 1px solid #888888;border-right: 1px solid #888888; padding-right: 5px; background-color: white;}
.tDev {width:41px; height:20px;  font-size: 12px; float:left; text-align: right; border-bottom: 1px solid #888888;border-right: 1px solid #888888; padding-right: 5px; background-color: white;}

.CDev {width:26px; border:0px; font-size: 12px; font-family:Arial; color:#000000;   margin-top: 1px; text-align: center;  margin-right: 4px;}
</style>

<body class="body">
<html>

<div id="gridTDEV">


<?php echo $grid; ?>

	
</div>	

<script>
parent.document.getElementById("ntick").innerHTML='<?php echo $t;?>';	
parent.document.getElementById("nemp").innerHTML='<?php echo $nemp;?>';	

parent.document.getElementById("ftqq").innerHTML= 'F TICKET: <?php echo $ftt;?>';	
parent.document.getElementById("mftqq").innerHTML='MAX DEV: <?php echo $maxD;?>';	

parent.document.getElementById("dtoAPP").innerHTML= 'Dto: <?php echo $descuento;?> %';	
parent.document.getElementById("itotT").innerHTML='Tot: <?php echo $importe;?> €';


parent.document.getElementById("mftqq").setAttribute("style", "color:<?php echo $colo; ?>;");
$('#CD-1').focus().select();
</script>
	
</html>
</body>