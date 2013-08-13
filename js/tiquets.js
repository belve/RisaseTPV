
function getCookieT(c_name)
{
var i,x,y,ARRcookies=document.cookie.split(";");
for (i=0;i<ARRcookies.length;i++)
{
  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
  x=x.replace(/^\s+|\s+$/g,"");
  if (x==c_name)
    {
    return unescape(y);
    }
  }
}

function setCookieT(c_name,value,exdays)
{
var exdate=new Date();
exdate.setDate(exdate.getDate() + exdays);
var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString()) + "; path=/";
document.cookie=c_name + "=" + c_value;
}



function cargaEmpleados(){

$.ajaxSetup({'async': false});	
var url='/ajax/cargaempleados.php';
$.getJSON(url, function(data) {
var count=0;	
$.each(data, function(key, val) {
if(key=='count'){
	setCookieT('num_emp',val,1);
}else{
count++;

setCookieT('empK_' + count,key,1);
setCookieT('empN_' + count,val,1);
	
}

});
});	

show_emp(1);	
	
}




function loop_emp(){
var current=getCookieT('current_emp');	
var total=getCookieT('num_emp');	
if(current==total){current=1;}else{current++;};
show_emp(current)	;
}

function show_emp(numemp){
setCookieT('current_emp',numemp,1);
document.getElementById('emple').innerHTML=getCookieT('empN_' + numemp);
$('#impCod').focus();	
}


function loop_emp2(){
var current=getCookieT('current_emp');	
var total=getCookieT('num_emp');	
if(current==total){current=1;}else{current++;};
show_emp2(current)	;
}

function show_emp2(numemp){
setCookieT('current_emp',numemp,1);
var iframe = document.getElementById('f_v_1');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
innerDoc.getElementById('emple').innerHTML=getCookieT('empN_' + numemp);
$('#impCod').focus();	
}



