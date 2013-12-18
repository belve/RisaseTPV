<?php

require_once("../db.php");
require_once("../variables.php");


if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "select var, value from config";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$config = "\$" . $row['var'] . "='" . $row['value'] . "';";   eval($config);};

if (!$dbnivel->close()){die($dbnivel->error());};

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>

<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />
<link rel='stylesheet' type='text/css' href='/css/tiquets.css' />
<script type="text/javascript" src="/js/tiquets.js"></script>



</head>





<body>





	
	
<script type="text/javascript">

    
window.top.combo=1;    

   // Register keypress events on the whole document
   $(document).keypress(function(e) {
   	
   //alert(e.keyCode);
      switch(e.keyCode) { 
        
         case 13:
         introD();
         return false;	
         break;
      
		 case 9:
         loopSS();
         return false;	
         break;
       
		
		 case 39:
         movC('ri');
         return false;	
         break;
		
		 case 37:
         movC('le');
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
      
      
      
         case 112:
           vercaja();
         return false;
         break;
         
         case 113:
           opencaj();
         return false;
         break;
         
         
         
         
         case 114:
           desglosecaja();
         return false;
         break;
      
      
         
         case 115:
         loop_emp();
       	 return false;
         break;
         
		 case 116:
         return false;
         break;

		 case 117:
         vregalo();
         return false;
         break;
         

         case 118:
           cobro();
         return false;
         break;
         
          case 119:
            cobro();
         return false;
         break;
         
          case 120:
            cobro();
         return false;
         break;
         
         
       
         case 122:
         devolucion();
         return false;	
         break;  
         
         case 123:
              showdescount();
         return false;     
         break;
         
      }
   });
   

</script>




<div class="emple">Empleado</div>
<div class="emple2" id="emple"></div>
<div class="subcar" id="sc">A</div>
<div style="clear:both;"></div>

<div class="emple">Código</div>
<div class="emple2" id="emple"><input type="text" class="impCod" id="impCod" onFocus="this.select()"></div>

<input type="hidden" value="0" id="dev_h">


<div id="dev_c" style="visibility: hidden;" class="modDEVT">

<div class="modDEV">MODO DEVOLUCIÓN</div> 

<div id="busqT2" class="tforRELM tfrINM"  style='background-color: white;' >
<input onkeyup="chkREG2();" type="text" id='searchT2' class="inpbti" value="">
</div>
		

</div>

<div style="clear:both;"></div>	


<div class="cabemp">
	<div class="cabtab_emp nom_tab_emp">Código</div>
	<div class="cabtab_emp ap1_tab_emp">Artículo</div>
	<div class="cabtab_emp ap2_tab_emp">Cant</div>
	<div class="cabtab_emp trbj_tab_emp">Precio</div>
	
</div>

<div style="clear:both;"></div>	
<div style="float:left">
<iframe id="dettiq" src="/ajax/det_ticket.php" width="400" height="230" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>
</div>

<div style="float:left">
<div class="keys">
F1 Ver Caja <br>	
F2 Abrir cajón <br>
F3 Desglose Caja <br>
F4 Cambiar Empleado <br>
<br>
<br>
F6 Ticket Regalo<br>
F7,F8,F9 Cobrar Ticket <br>
F11 Devoluciones <br>
F12 Descuento <br>	
</div>

</div>

<div style="clear:both;"></div>	
<div class="emple">Importe</div>
<div class="total" id="total">0.00 €</div>


<div id="vregalo" style="visibility: hidden;">
<div style=" background-color: #C8C8C8;    height: 341px;    left: 0px;    opacity: 0.6;    position: absolute;    top: 0px;    width: 560px;"></div>
<div style="background-color: #cccccc;    height: 130px;    left: 150px;    padding: 25px;    position: absolute;    top: 84px;    width: 201px; border: 1px solid #666666;">

<div id="contREG">
		
</div>

<div id="busqT" class="tforREL tfrIN"  style='background-color: white;' >
	<input onkeyup="chkREG();" type="text" id='searchT' class="inpbti" value="">
	<input type="hidden" id="idnt" value="<?php echo $id_nom_tienda; ?>">
</div>
		
</div>



<div id="devti" style="visibility: hidden;">

<div style=" background-color: #C8C8C8;    height: 341px;    left: 0px;    opacity: 0.6;    position: absolute;    top: 0px;    width: 560px;"></div>
<div style="  background-color: #CCCCCC;    border: 1px solid #666666;    height: 236px;    left: 68px;    padding: 25px;    position: absolute;    top: 21px;    width: 400px;">

<div style="position:relative">
<div style="color: #0000FF;  font-size: 12px;  font-weight: bold; position: relative; float: left; " id="ntick"></div>
<div style="color: #0000FF;  font-size: 12px;  font-weight: bold; position: relative; float: right; " id="nemp"></div>
</div>

<div style="position:relative">
<div class="cabemp" style=" position: absolute;    top: 23px;    width: 363px;">
	<div class="cabtab_emp nom_tab_emp" style=" width: 75px;">Código</div>
	<div class="cabtab_emp ap1_tab_emp" style=" width: 162px;">Artículo</div>
	<div class="cabtab_emp trbj_tab_emp" style=" width: 40px;" >€</div>
	<div class="cabtab_emp ap2_tab_emp" style=" width: 35px;">Cant</div>
	<div class="cabtab_emp ap2_tab_emp" style=" width: 43px;">Dev</div>
	
</div>
</div>

<div style="position: absolute; top:74px;">
<iframe id="dettiqq" src="/ventanas/blank.html" width="390" height="170" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>	
</div>

<div style="position: absolute; top:247px;width: 356px;">

<div style="position:relative">
<div class="ffDvt" id="ftqq">12/05/2013</div>
<div style="color: #0000FF;  font-size: 12px;  font-weight: bold; position: relative; float: right; " id="dtoAPP"></div>
</div>
	
</div>


<div style="position: absolute; top:267px;width: 356px;">

<div style="position:relative">
<div class="ffDvt" id="mftqq">12/05/2013</div>
<div style="color: #0000FF;  font-size: 12px;  font-weight: bold; position: relative; float: right; " id="itotT"></div>
</div>
	
</div>



</div>

</div>



<div id="cobrador" style="visibility: hidden;">
<div style=" background-color: #C8C8C8;    height: 341px;    left: 0px;    opacity: 0.6;    position: absolute;    top: 0px;    width: 560px;"></div>
<div style="background-color: #cccccc;    height: 87px;    left: 93px;    padding: 35px;    position: absolute;    top: 84px;    width: 201px; border: 1px solid #666666;">
	
<div class="emple">Importe: </div><input type="text" class="impCod2" style="margin-left: 31px; border:0px; background-color: #cccccc; color:green;" id="do_tot">
<div style="clear:both;"></div>
<div class="emple">Efectivo:</div><input type="text" class="impCod2" id="do_pag" style="background-color: white; color:#333333;"; onkeyup="javascript:cambi();">	
<div style="clear:both;"></div>
<div class="emple">Cambio:</div><input type="text" class="impCod2" id="do_cam" style="margin-left: 31px; border:0px; background-color: #cccccc; color:red;">	

<input type="hidden" id="do_tot_H" value="">
<input type="hidden" id="do_Dtot_H" value="">

</div>	


<div style="background-color: #cccccc; padding: 35px; position: absolute; z-index: 100; height: 17px; top: 90px; width: 195px; left: 96px; visibility: hidden; " id="cajon">

<!--
<div style="background-color: orange; color: white; text-align: center; padding: 5px; width: 100px; margin-left: 47px; font-weight: bold; cursor: pointer;  margin-top: -20px; margin-bottom: 10px;" onclick="javascript:regalo();">T. Regalo</div>	
-->

<input type="hidden" id='tregalo' value='' />
	
<div style="background-color: orange; color: white; text-align: center; padding: 5px; width: 100px; margin-left: 47px; font-weight: bold; cursor: pointer;" onclick="javascript:escapeD();">Cerrar</div>	
	
</div>

</div>



<div id="descuento" style="visibility: hidden;">
<div style=" background-color: #C8C8C8;    height: 341px;    left: 0px;    opacity: 0.6;    position: absolute;    top: 0px;    width: 560px;"></div>
<div style="background-color: #cccccc;    height: 87px;    left: 93px;    padding: 35px;    position: absolute;    top: 84px;    width: 201px; border: 1px solid #666666;">
	
<input type="hidden" id="descount_H" value="">
<div class="emple">Descuento:</div><input type="text" class="impCod2" id="descount" style="background-color: white; color:#333333; cursor: pointer;"; onsubmit ="javascript:descount();">	
<div style="clear:both;"></div>

<input type="hidden" id="do_tot_H" value="">

</div>	
</div>


<div id="manual" style="visibility: hidden;">
<div style=" background-color: #C8C8C8;    height: 341px;    left: 0px;    opacity: 0.6;    position: absolute;    top: 0px;    width: 560px;"></div>
<div style="background-color: #cccccc;    height: 36px;    left: 93px;    padding: 35px;    position: absolute;    top: 84px;    width: 150px; border: 1px solid #666666;">


<div class="emple">Importe:</div><input type="text" class="impCod2" id="manual_i" style="width:40px; background-color: white; color:#333333; cursor: pointer;"; onsubmit ="javascript:descount();">	
<div style="clear:both;"></div>


</div>	
</div>





<div id="vercaja" style="visibility: hidden;">
<div style=" background-color: #C8C8C8;    height: 341px;    left: 0px;    opacity: 0.6;    position: absolute;    top: 0px;    width: 560px;"></div>
<div style="background-color: #cccccc;  left: 93px;    padding: 25px;    position: absolute;    top: 84px;    width: 240px; border: 1px solid #666666;">


<div id="detcaja">
	
	
</div>
<div style="clear: both;"></div>
<div onclick="javascript:escapeD();" style="cursor:pointer; background-color: orange; color: white; text-align: center;margin-top: 10px; padding: 5px; width: 100px; margin-left: 60px; font-weight: bold;">Cerrar</div>
</div>	
</div>





<script>
	

setTimeout('cargaEmpleados();', 1000);
</script>

</body>
</html>