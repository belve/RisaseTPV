<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>

<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />
<link rel='stylesheet' type='text/css' href='/css/tiquets.css' />
<script type="text/javascript" src="/js/roturas.js"></script>



</head>





<body>





	
	
<script type="text/javascript">

    
    

   // Register keypress events on the whole document
   $(document).keypress(function(e) {
   	
   
      switch(e.keyCode) { 
        
         case 13:
         DintroD();
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





<div style="clear:both;"></div>

<div class="emple">Código</div>
<div class="emple2" id="emple"><input type="text" class="impCod" id="impCodD" onFocus="this.select()" style="width:140px; margin-left:-5px;"></div>

<div style="clear:both;"></div>

<div class="botDev bdNara" id="Dev" onclick="javascript:putDev();" >Devolución</div>
<input type="hidden" id="mod" value="D">
<div class="botDev bdGris" id="Rot" onclick="javascript:putRot();">Rotura</div>

<div style="clear:both;"></div>	


<div class="cabDEV">
	<div class="cabtab_DEV nom_tab_emp">Código</div>
	<div class="cabtab_DEV ap1_tab_DEV">Can</div>
	<div class="cabtab_DEV ap2_tab_DEV">R/D</div>
	
	
</div>

<div style="clear:both;"></div>	
<div style="float:left">
<iframe id="detRotura" src="/ajax/det_devolucion.php" width="238" height="245" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>
</div>



<div style="clear:both;"></div>	
<div class="botDev" style="margin-left: 127px;" onclick="javascript:do_rotura();">Enviar >></div>






<script>
setCookieT('roturas','',1);	

document.getElementById("impCodD").focus();
</script>

</body>
</html>