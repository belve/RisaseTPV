<?php
$maxF="";

$ft=date('Y') . "-" . date('m') . "-" . date('d'); 
$fecha = new DateTime($ft);
$fecha->add(new DateInterval('P3M'));
$maxF= $fecha->format('d/m/Y');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="/js/tiquets.js"></script>


<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />
<link rel='stylesheet' type='text/css' href='/css/tiquets.css' />


<script>
	
	$(document).keypress(function(e) {
   	
   //alert(e.keyCode);
      switch(e.keyCode) { 
        
         case 13:
         vale();
         return false;	
         break;
      
	       
      }
   });
   
	
	
</script>

</head>





<body>

 
<div style="color: #0000FF;    float: left;    font-size: 13px;    font-weight: bold;">
Valido hasta:	

<br>
<input  onkeyup="tabF(this.id)" style="width:100px; margin-left: -2px" type="text" id='maxF' value="<?php echo $maxF; ?>"/>
</div> 



<div style="color: #0000FF;    float: left;    font-size: 13px;    font-weight: bold;">
Importe:	

<br>

<input style="width:50px;" type="text" id='imp' value=""/>
</div> 

<div onclick="vale();" style="position: absolute; top: 52px; left: 36px; width: 80px; height: 17px; background-color: orange; border: 1px solid #888888; cursor:pointer; padding: 3px; text-align: center;">Imprimir</div>

<script>
$('#imp').focus();

function tabF(id){
var fech=document.getElementById(id).value;
if(fech.length==2){fech=fech + '/';};
if(fech.length==5){fech=fech + '/';};
var fech=fech.replace("//","/");
document.getElementById(id).value=fech;	
}
	
</script>

</body>
</html>