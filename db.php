<?php


class DB
{
### parametros de conexion #####

var $db_host='';
var $db_user='';
var $db_password='';
var $db_database='';
var $db_persistent=false;

###### Cadena de conexión ######

var $db_conn = NULL;

#### Resultado de la query #####

var $db_result =false;




function DB($db_host,$db_user,$db_password,$db_database,$db_persistent = false)
{
$this->host=$db_host;
$this->user=$db_user;
$this->password=$db_password;
$this->database=$db_database;
$this->persistent=$db_persistent;
	
}


function open()
{
##### Comprobabos el metodo de conexion mas apropiado
if ($this->persistent){$func='mysql_pconnect';}else{$func='mysql_connect';};

$this->conn = $func($this->host, $this->user, $this->password);
if(!$this->conn){return false;};

if (@!mysql_select_db($this->database, $this->conn)){return false;};

return true;
}


function close(){
	return(@mysql_close($this->conn));	
}


function error(){
	return(mysql_error());
}

function query($sql)
{
	mysql_query("SET NAMES 'utf8'");
	$this->result = @mysql_query($sql, $this->conn);
	return($this->result != false);
}

function affectedrows()
{
	return(@mysql_affected_rows($this->conn));
}


function numrows()
{
	return(@mysql_num_rows($this->result));
}


function fetchobject()
{
	return(@mysql_fetch_object($this->result, MYSQL_ASSOC));
} 

function fetcharray()
{
	return(@mysql_fetch_array($this->result, MYSQL_NUM));
}


function fetchassoc()
{
	return(@mysql_fetch_assoc($this->result));
}

function freeresult()
{
	return(@mysql_free_result($this->result));
}



}



?>