
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title>Aplicación TPV RISASE</title>


<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="/js/functions.js"></script>
<script type="text/javascript" src="/js/tiquets.js"></script>



<link rel='stylesheet' type='text/css' href='/css/framework.css' />




</head>

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
         
          case 113:
           opencaj();
         return false;
         break;
         
         
         case 114:
           alert('Desglose de caja');
         return false;
         break;
      
      
         
         case 115:
        loop_emp2();
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




<body class="gris1_BG">
	
<input style="font-size:10px;" type="hidden" id="crtl" style="position:absolute;top:0px;left:0px; z-index: 999; " value="0">
	
<div class="page">


<div id="menu">
<ul id="nav">
	<li><a>Principal</a>
		<ul class="submenu">
        	
        	 <li onclick="javascript:owin('v_1','Venta de Artículos','');"><a>Venta de Artículos</a></li>
        	 <li onclick="javascript:owin('v_2','Roturas/Devoluciones','');"><a>Roturas/Devoluciones</a></li>
        </ul>
	</li>
    
    <li><a>Utilidades</a>
    	<ul class="submenu">
        	
        	<li onclick="javascript:owin('v_3','Comprobar Artículo','');"><a>Comprobar Artículo</a></li>
        	<li onclick="javascript:owin('v_4','Vales','');"><a>Vales</a></li>
        </ul>
    	
    </li>
    
    

   
</ul>
<div style="color:blue;" class="fdate" id="date"><?php echo date('d') . "/" . date('m') . "/" . date('Y'); ?></div>

</div>




<div id="ventanas">


	
</div>





</div>


<div class="minimizadas" id="minimizadas">

</div>


</div>





<!--
<iframe style="position: absolute; top:452px; background-color: white; " id="syncro" src="/sync/autoSync.php" width="50" height="50" border="0" frameborder="0" marginheight="0" scrolling="auto"></iframe>
-->



<script>
owin('v_1','Venta de Artículos','');
	
	
	
	
function sync1(){
var func='sync2();'
$.getJSON('/sync/autoSync.php', function(data) {
$.each(data, function(key, val) {
});
});

setTimeout(func, 600000);	
}	


function sync2(){
var func='sync1();'
$.getJSON('/sync/autoSync.php', function(data) {
$.each(data, function(key, val) {
});
});

setTimeout(func, 600000);	
}	



function dtime1(){

$.getJSON('/sync/getDate.php', function(data) {
$.each(data, function(key, val) {
if(key==1){document.getElementById("date").innerHTML=val; document.getElementById("date").setAttribute("style", "color:red;");};
if(key==2){document.getElementById("date").innerHTML=val; document.getElementById("date").setAttribute("style", "color:blue;");};	
});
});
	

setTimeout('dtime2();', 500000);	
}


function dtime2(){

$.getJSON('/sync/getDate.php', function(data) {
$.each(data, function(key, val) {
if(key==1){document.getElementById("date").innerHTML=val; document.getElementById("date").setAttribute("style", "color:red;");};
if(key==2){document.getElementById("date").innerHTML=val; document.getElementById("date").setAttribute("style", "color:blue;");};
});
});



setTimeout('dtime1();', 500000);	
}


dtime1();	
sync1();	
</script>
</body>
</html>













