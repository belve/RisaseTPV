<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>

<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />
<link rel='stylesheet' type='text/css' href='/css/tiquets.css' />
<script type="text/javascript" src="/js/compArt.js"></script>



</head>





<body>





	
	
<script type="text/javascript">

    
    

   // Register keypress events on the whole document
   $(document).keypress(function(e) {
   	
   
      switch(e.keyCode) { 
        
         case 13:
         introCA();
         return false;	
         break;
      
		         
      }
   });
   

</script>






<div class="emple wA">Código</div>
<div class="emple2" id="emple" style="margin-left: 0px;"><input type="text" class="impCod3" id="impCodA" onFocus="this.select()"></div>

<div style="clear:both;"></div>
<div class="emple wA">Grupo</div>
<div class="emple2" id="3"></div>

<div style="clear:both;"></div>
<div class="emple wA">Subgrupo</div>
<div class="emple2" id="4"></div>

<div style="clear:both;"></div>
<div class="emple wA">Color</div>
<div class="emple2" id="5"></div>


<div style="clear:both;"></div>
<div class="emple wA">Stock</div>
<div class="emple2" id="10"></div>



<div style="clear:both;"></div>
<div class="emple wA">Stock mín</div>
<div class="emple2" id="11"></div>


<div style="clear:both;"></div>
<div class="emple wA">PVP</div>
<div class="emple2" id="16"></div>

<div style="clear:both;"></div>
<div style="margin-top: 16px;">
<div class="emple wA">Detalles</div>
<div id="18" style="float: none;" class="emple2"></div>
</div>

<div style="clear:both;"></div>
<div class="emple wA">Coment</div>
<div id="19" style="float: none;" class="emple2"></div>


<div class="photo">
	<img src="" id="foto" style="max-height:205px; max-width: 273px; margin:1px; ">
	<div id="opciones"></div>
</div>



<script>
	document.getElementById("impCodA").select();
</script>
</body>
</html>