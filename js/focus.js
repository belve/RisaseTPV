



function changefield(value){
		
	var i=$("*:focus").attr("id");
	
	if(value=='up'){i--;};
	if(value=='down'){i++;};	
	$('#'+ i).focus();

	
}

function modifield(field){
	var i=$("*:focus").attr("id");
	var valor=document.getElementById(field).value;
	alert('Modifico en BD campo: ' + field + " Con el nuevo valor:" + valor);
	
}
