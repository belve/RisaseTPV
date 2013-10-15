


function introCA(){

var cod=document.getElementById('impCodA').value;
var url='/ajax/getArt.php?codbarras=' + cod;

$.getJSON(url, function(data) {
$.each(data, function(key, val) {

if(key=="error"){
alert("Código no encontrado");
document.getElementById("impCodA").value="";
document.getElementById("impCodA").select();		
}else if(key=="foto"){
document.getElementById('foto').src=val;
}else if(key=="opciones"){
document.getElementById('opciones').innerHTML=val;
}else{

if(document.getElementById(key)){
document.getElementById(key).innerHTML=val;
}
}			
	
});
});

	
	
	
}
