

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

$s=$espacios[42-strlen($nt)-strlen($dr)]; $dr=$s . $dr;
$ticket.= $nt . $dr ."\n\n";


 

$ticket.="Articulo       Codigo  Cant  Precio  Total\n";


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

$ticket.="\n\n\n\n\n";



$ticket2 = chr(29) . chr(86) . chr(48)  . chr(0) ;
$ticket3 = chr(27) . chr(112) . chr(0)  . chr(25) . chr(250);


Send_print($ticket,$ticket2,$ticket3);

}







function caja($det){


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
$espacios[18]="                  ";
$espacios[19]="                   ";
$espacios[20]="                    ";
$espacios[21]="                     ";
$espacios[22]="                      ";
$espacios[23]="                       ";
$espacios[24]="                        ";
$espacios[25]="                         ";
$espacios[26]="                          ";
$espacios[27]="                           ";
$espacios[28]="                            ";
$espacios[29]="                             ";
$espacios[30]="                              ";
$espacios[31]="                               ";
$espacios[32]="                                ";



$fecha=date('d') . "/" . date('m') . "/" . date('Y');



 
$ticket ="Caja                      Fecha:$fecha\n\n";
#$ticket.="Articulo       Codigo  Cant  Precio  Total\n";
#$ticket.="Empleado                           vendido\n";
$tot=0;
foreach ($det as $nom => $sum) {$tot=$tot+$sum;
$s=$espacios[42-strlen($nom)-strlen($sum)]; $sum=$s . $sum;
$ticket.= $nom . $sum ."\n";		
}


$ticket.="__________________________________________\n";

$tot=number_format($tot,2);$s=$espacios[36-strlen($tot)]; $tot=$s . $tot;
$ticket.="Total:$tot\n";

$ticket.="\n\n\n\n\n";	
	
	
$ticket2 = chr(29) . chr(86) . chr(48)  . chr(0) ;
$ticket3 = chr(27) . chr(112) . chr(0)  . chr(25) . chr(250);


Send_print($ticket,$ticket2,$ticket3);	
}








function Send_print($ticket,$ticket2,$ticket3){

$ticket=iconv('UTF-8', 'ASCII//TRANSLIT', $ticket);

$fp = fopen("LPT1:", "r+");
fwrite($fp,$ticket);
fwrite($fp,$ticket2);
fwrite($fp,$ticket3);


	
}


function Send_print2($ticket,$ticket2,$ticket3){
	
$ticket=urlencode($ticket . $ticket2 . $ticket3);

$file = fopen ("http://192.168.1.41/print.php?t=$ticket", "r");
while (!feof ($file)) { $fotos = fgets ($file, 1024);};
fclose($file);
	
}




?>