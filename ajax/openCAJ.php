<?php

$ticket3 = chr(27) . chr(112) . chr(0)  . chr(25) . chr(250);	
$fp = fopen("LPT1:", "r+");
fwrite($fp,$ticket3);	


?>