

<?php



$ticket="
RISASE SA
collares	X1	22,95
Pulseras	X3	22.96
 
Total			33.25 €
";

$ticket=iconv('UTF-8', 'ASCII//TRANSLIT', $ticket). "\n\n\n\n\n\n\n\n\n";

$fp = fopen("lpt1:", "r+");
fwrite($fp,$ticket);



$handle = printer_open();
printer_write($handle, $ticket);
printer_close($handle);

echo $ticket;
?>