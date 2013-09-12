

<?php



function ticket($tifprint,$nt,$dr,$id_tienda){

$espacios[0] ="";
$espacios[1] =" ";
$espacios[2] ="  ";
$espacios[3] ="   ";
$espacios[4] ="    ";
$espacios[5] ="     ";
$espacios[6] ="      ";
$espacios[7] ="       ";
$espacios[8] ="        ";
$espacios[9] ="         ";
$espacios[10]="          ";
$espacios[11]="           ";
$espacios[12]="            ";
$espacios[13]="             ";
$espacios[14]="              ";
$espacios[15]="               ";
$espacios[16]="                ";
$espacios[17]="                 ";

$fecha=date('d') . "/" . date('m') . "/" . date('Y');
$ticket ="RISASE,S.A. (A-78088176)  Fecha:$fecha\n";

$s=$espacios[43-strlen($nt)-strlen($dr)]; $dr=$s . $dr;
$ticket.= $nt . $dr ."\n\n";


 
#$ticket.="Fecha: $fecha\n";
$ticket.="Articulo       Codigo  Cant  Precio  Total\n";
#$ticket.="Anillos      14141414     2    2,00   4,00\n";

$toti=0;
if(count($tifprint)>0){foreach($tifprint as $point => $det){foreach($det as $cod => $vals){

$art=$vals['n'];	
					$s=$espacios[21-strlen($cod)-strlen($art)]; $cod=$s . $cod;
$can=$vals['q'];	$s=$espacios[6-strlen($can)]; $can=$s . $can;
$pun=$vals['p'];	$s=$espacios[8-strlen($pun)]; $pun=$s . $pun;	
$pto=$can*$pun;
$pto=number_format($pto, 2);		$s=$espacios[7-strlen($pto)]; $pto=$s . $pto;

$ticket.=$art . $cod . $can . $pun . $pto . "\n";

$total=$vals['t'];
$descuento=$vals['d'];
$toti=$toti+$pto;

}}}






if($descuento>0){

$idesc=$toti-$total;
$idesc=number_format($idesc, 2);
	
$s=$espacios[9-strlen($idesc)-strlen($descuento)]; $idesc=$s . $idesc;	

$ticket.="                      Descuento:$descuento%$idesc\n";
	
}


$ticket.="\n";

$total=number_format($total, 2);

$s=$espacios[7-strlen($total)]; $total=$s . $total;

$ticket.="I.V.A. Incluido        Total euros:$total\n";

$ticket.="------------------------------------------\n";
$ticket.="GRACIAS POR SU COMPRA                     \n";
$ticket.="------------------------------------------\n";

$ticket.="           www.debisuteria.com            \n";
$ticket.="visitenos en internet y obtenga descuentos\n";

$ticket.="\n\n\n\n\n\n\n\n";


Send_print($ticket);

}


function Send_print($ticket){


$ticket2 = chr(29) . chr(86) . chr(48)  . chr(0) ;
$ticket3 = chr(27) . chr(112) . chr(0)  . chr(25) . chr(250);


	
$ticket=iconv('UTF-8', 'ASCII//TRANSLIT', $ticket);
#$ticket2=iconv('UTF-8', 'ASCII//TRANSLIT', $ticket2);
#$ticket3=iconv('UTF-8', 'ASCII//TRANSLIT', $ticket3);

$fp = fopen("LPT1:", "r+");
fwrite($fp,$ticket);
fwrite($fp,$ticket2);
fwrite($fp,$ticket3);
#fwrite($fp,chr(27) . chr(112) . chr(48)  . chr(100) );	

	
}


function Send_print2($ticket){
	
$ticket=urlencode($ticket);

$file = fopen ("http://192.168.1.41/print.php?t=$ticket", "r");
while (!feof ($file)) { $fotos = fgets ($file, 1024);};
fclose($file);
	
}




?>