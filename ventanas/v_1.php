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
           alert('combo');
         
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
         alert('cambio empleado');
       	 return false;
         break;
         
		 case 116:
         return false;
         break;

         case 118:
            alert('cobro');
         return false;
         break;
         
          case 119:
            alert('cobro');
         return false;
         break;
         
          case 120:
            alert('cobro');
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
<div class="emple2" id="emple">EMPLEADO EVENTUAL</div>

<div style="clear:both;"></div>

<div class="emple">Código</div>
<div class="emple2" id="emple"><input type="text" class="impCod" id="impCod"></div>

<div style="clear:both;"></div>	


<div class="cabemp">
	<div class="cabtab_emp nom_tab_emp">Cod</div>
	<div class="cabtab_emp ap1_tab_emp">Artículo</div>
	<div class="cabtab_emp ap2_tab_emp">Cant</div>
	<div class="cabtab_emp trbj_tab_emp">Precio</div>
	
</div>

<div style="clear:both;"></div>	
<div style="float:left">
<iframe id="agrupaciones" src="/ajax/agrupaciones.php" width="350" height="230" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>
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

</body>
</html>