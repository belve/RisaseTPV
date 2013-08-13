

<?php



$ticket="
RISASE SA
collares	X1	22,95
Pulseras	X3	22.96
 
Total			33.25 €
";

$ticket=iconv('UTF-8', 'ASCII//TRANSLIT', $ticket). "\n\n\n\n\n\n\n\n\n";

#$fp = fopen("LPT1:", "r+");
#fwrite($fp,$ticket);


$data = "test.txt"; 
echo exec("type ".$data." > lpt1");  
#echo $ticket;
?>