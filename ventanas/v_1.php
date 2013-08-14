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

    
    

   // Register keypress events on the whole document
   $(document).keypress(function(e) {
   	
   
      switch(e.keyCode) { 
        
         case 13:
         introD();
         return false;	
         break;
      
		 
         case 27:
         escapeD();
         return false;	
         break;      
      
      
      
         case 112:
           alert('Ver caja');
         return false;
         break;
         
         case 114:
           alert('Desglose de caja');
         return false;
         break;
      
      
         
         case 115:
         loop_emp();
       	 return false;
         break;
         
		 case 116:
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
              alert('Devoluciones');
         return false;     
         break;
         
         case 123:
              alert('Descuento');
         return false;     
         break;
         
      }
   });
   

</script>




<div class="emple">Empleado</div>
<div class="emple2" id="emple"></div>

<div style="clear:both;"></div>

<div class="emple">Código</div>
<div class="emple2" id="emple"><input type="text" class="impCod" id="impCod" onFocus="this.select()"></div>

<div style="clear:both;"></div>	


<div class="cabemp">
	<div class="cabtab_emp nom_tab_emp">Cod</div>
	<div class="cabtab_emp ap1_tab_emp">Artículo</div>
	<div class="cabtab_emp ap2_tab_emp">Cant</div>
	<div class="cabtab_emp trbj_tab_emp">Precio</div>
	
</div>

<div style="clear:both;"></div>	
<div style="float:left">
<iframe id="dettiq" src="/ajax/det_ticket.php" width="364" height="230" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>
</div>

<div style="float:left">
<div class="keys">
F1 Ver Caja <br>	
F3 Desglose Caja <br>
F4 Cambiar Empleado <br>
<br>
<br>
F7,F8,F9 Cobrar Ticket <br>
F11 Devoluciones <br>
F12 Descuento <br>	
</div>

</div>

<div style="clear:both;"></div>	
<div class="emple">Importe</div>
<div class="total" id="total">0.00 €</div>

<div id="cobrador" style="visibility: hidden;">
<div style=" background-color: #C8C8C8;    height: 341px;    left: 0px;    opacity: 0.6;    position: absolute;    top: 0px;    width: 476px;"></div>
<div style="background-color: #999999;    height: 87px;    left: 93px;    padding: 35px;    position: absolute;    top: 84px;    width: 201px;">
	
<div class="emple">Total: </div><input type="text" class="impCod2" style="margin-left: 43px;" id="do_tot">
<div style="clear:both;"></div>
<div class="emple">Pagado:</div><input type="text" class="impCod2" id="do_pag">	
<div style="clear:both;"></div>
<div class="emple">Cambio:</div><input type="text" class="impCod2" id="do_cam">	

<input type="hidden" id="do_tot_H" value="">

</div>	
</div>


<script>
	

setTimeout('cargaEmpleados();', 1000);
</script>

</body>
</html>