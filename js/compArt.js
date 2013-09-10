


function introCA(){

$.getJSON(url, function(data) {
$.each(data, function(key, val) {

if(val=="error"){
alert("Código no encontrado");		
}else{
tiq=tiq + val;	
}			
	
});
});

	
	
	
}
