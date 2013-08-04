function cargaColores(pointer){
url = "/ajax/basics-bd.php?tabla=colores&pointer=" + pointer;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
   document.getElementById('color_hid').value=key;
   document.getElementById('color_id').value=key;
   document.getElementById('color_name').value=val;
});
});
}

function cargaColoresMENOS(){
var actual=	document.getElementById('color_hid').value;
actual--;
cargaColores(actual);
}

function cargaColoresMAS(){
var actual=	document.getElementById('color_hid').value;
actual++;
cargaColores(actual);
}


function cargaColoresINI(){
cargaColores(0);
}

function cargaColoresFIN(){
cargaColores('-1');
}

function cargaColoresS(){
var actual=	document.getElementById('color_id').value;
cargaColores(actual);
}

function saveColor(){
var id=	document.getElementById('color_hid').value;	
var name=document.getElementById('color_name').value;	
url = "/ajax/update-bd.php?tabla=colores&id=" + id + "&name=" + name;
$.getJSON(url, function(data) {
});
}









function cargaGrupos(pointer){
url = "/ajax/basics-bd.php?tabla=grupos&pointer=" + pointer;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
   document.getElementById('grupos_hid').value=key;
   document.getElementById('grupos_id').value=key;
   document.getElementById('grupos_name').value=val;
});
});
}

function cargaGruposMENOS(){
var actual=	document.getElementById('grupos_hid').value;
actual--;
cargaGrupos(actual);
}

function cargaGruposMAS(){
var actual=	document.getElementById('grupos_hid').value;
actual++;
cargaGrupos(actual);
}


function cargaGruposINI(){
cargaGrupos(0);
}

function cargaGruposFIN(){
cargaGrupos('-1');
}

function cargaGruposS(){
var actual=	document.getElementById('grupos_id').value;
cargaGrupos(actual);
}

function saveGrupo(){
var id=	document.getElementById('grupos_hid').value;	
var name=document.getElementById('grupos_name').value;	
url = "/ajax/update-bd.php?tabla=grupos&id=" + id + "&name=" + name;
$.getJSON(url, function(data) {
});
}





function createSubGrupo(){
url = "/ajax/createrecord.php?tabla=subgrupos";
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
   if(key == 'lastid'){cargaSubGrupos2(val);};
});
});
	
}



function cargaSubGrupos(pointer){
var actual=	document.getElementById('1_hid').value;

if (pointer == 'menos'){pointer=(actual*1)-1;};
if (pointer == 'mas'){pointer=(actual*1)+1;};

url = "/ajax/subgrupos.php?pointer=" + pointer;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
  
  if(key == 1){
  	document.getElementById('1_hid').value=val;
   	document.getElementById('1').value=val;
   	}
   if(key == 2){document.getElementById('2').value=val;};
   if(key == 3){document.getElementById('3').value=val;};
   if(key == 4){document.getElementById('4').value=val;};
  	
 
});
});
}


function cargaSubGrupos2(pointer){
var actual=	document.getElementById('1_hid').value;

if (pointer == 'menos'){pointer=(actual*1)-1;};
if (pointer == 'mas'){pointer=(actual*1)+1;};

url = "/ajax/subgrupos.php?noborro=1&pointer=" + pointer;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
  
  if(key == 1){
  	document.getElementById('1_hid').value=val;
   	document.getElementById('1').value=val;
   	}
   if(key == 2){document.getElementById('2').value=val;};
   if(key == 3){document.getElementById('3').value=val;};
   if(key == 4){document.getElementById('4').value=val;};
  	
 
});
});
}





function cargaSubGruposS(){
var actual=	document.getElementById('1').value;
cargaSubGrupos(actual);
}



function saveSubGrupo(){
var id=	document.getElementById('1_hid').value;	
var grupo=document.getElementById('2').value;
var subgrupo=document.getElementById('3').value;
var clave=document.getElementById('4').value;
	
url = "/ajax/update2.php?tabla=subgrupos&campos[id_grupo]=" + grupo + "&campos[nombre]=" + subgrupo  + "&campos[clave]=" + clave  +  "&id=" + id;
$.getJSON(url, function(data) {
});
}










function createproveedores(){
url = "/ajax/createrecord.php?tabla=proveedores";
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
   if(key == 'lastid'){cargaproveedores2(val);};
});
});
	
}

function cargaproveedores(pointer){
var actual=	document.getElementById('1_hid').value;

if (pointer == 'menos'){pointer=(actual*1)-1;};
if (pointer == 'mas'){pointer=(actual*1)+1;};

url = "/ajax/proveedores.php?pointer=" + pointer;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
  
  if(key == 1){
  	document.getElementById('1_hid').value=val;
   	document.getElementById('1').value=val;
   	}
   if(key == 2){document.getElementById('2').value=val;};
   if(key == 3){document.getElementById('3').value=val;};
   if(key == 4){document.getElementById('4').value=val;};
   if(key == 5){document.getElementById('5').value=val;};
   if(key == 6){document.getElementById('6').value=val;};
   if(key == 7){document.getElementById('7').value=val;};
   if(key == 8){document.getElementById('8').value=val;};
   if(key == 9){document.getElementById('9').value=val;};
   if(key == 10){document.getElementById('10').value=val;};
   if(key == 11){document.getElementById('11').value=val;};
   if(key == 12){document.getElementById('12').value=val;};
   
  	
 
});
});
}


function cargaproveedores2(pointer){
var actual=	document.getElementById('1_hid').value;

if (pointer == 'menos'){pointer=(actual*1)-1;};
if (pointer == 'mas'){pointer=(actual*1)+1;};

url = "/ajax/proveedores.php?noborro=1&pointer=" + pointer;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
  
  if(key == 1){
  	document.getElementById('1_hid').value=val;
   	document.getElementById('1').value=val;
   	}
   if(key == 2){document.getElementById('2').value=val;};
   if(key == 3){document.getElementById('3').value=val;};
   if(key == 4){document.getElementById('4').value=val;};
   if(key == 5){document.getElementById('5').value=val;};
   if(key == 6){document.getElementById('6').value=val;};
   if(key == 7){document.getElementById('7').value=val;};
   if(key == 8){document.getElementById('8').value=val;};
   if(key == 9){document.getElementById('9').value=val;};
   if(key == 10){document.getElementById('10').value=val;};
   if(key == 11){document.getElementById('11').value=val;};
   if(key == 12){document.getElementById('12').value=val;};
   
  	
 
});
});
}


function cargaproveedoresS(){
var actual=	document.getElementById('1').value;
cargaproveedores(actual);
}



function saveproveedores(){
var id=	document.getElementById('1_hid').value;	
var nombre=document.getElementById('2').value;
var cif=document.getElementById('3').value;
var direccion=document.getElementById('4').value;
var cp=document.getElementById('5').value;
var poblacion=document.getElementById('6').value;
var provincia=document.getElementById('7').value;
var contacto=document.getElementById('8').value;
var telefono=document.getElementById('9').value;
var fax=document.getElementById('10').value;
var email=document.getElementById('11').value;
var nomcorto=document.getElementById('12').value;

if(nomcorto.length>6){
	
alert('La abreviatura del proveedor debe tener un máximo de 6 caracteres');	
}else{
	
url = "/ajax/update2.php?tabla=proveedores"
+ "&campos[nombre]=" + nombre  
+ "&campos[cif]=" + cif  
+ "&campos[direccion]=" + direccion  
+ "&campos[cp]=" + cp  
+ "&campos[poblacion]=" + poblacion  
+ "&campos[provincia]=" + provincia  
+ "&campos[contacto]=" + contacto  
+ "&campos[telefono]=" + telefono  
+ "&campos[fax]=" + fax  
+ "&campos[email]=" + email  
+ "&campos[nomcorto]=" + nomcorto  

+  "&id=" + id;
$.getJSON(url, function(data) {
});


}

}






