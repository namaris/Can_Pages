<?php
	
	if (isset($_POST ['name']) && ($_POST['phone']) && ($_POST['email']) ) {
		
	$email_from = $_POST['name'];
	$email_to = 'dulani.mir@gmail.com';
	$email_subject = 'Contacto Web Restaurant Can Pages';
	$email_message = $_POST['coments'];
	$email_email = $_POST['email'];

	$headers = 'From: '.$email_from."\r\n". 'Reply-To: '.$email_email."\r\n" . 'X-Mailer: PHP/' . phpversion();
					
	mail($email_to, $email_subject, $email_message, $headers);
	echo 'Mensaje enviado correctamente <br/><br/>';
	echo 'Redirigiendo al servidor.......<br/>'; 		
	}
	else {
		echo 'Error al enviar el Correo';
	}
	
/* >>>>>>>>>>>>>>>>>>>>>>>> Codigo opcional para enviar el email con la clase PHPMailer <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

require 'phpmailer/PHPMailerAutoload.php';


$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'anda80.e-distribuidores.eu';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'info@restaurantcanpages.es';        // SMTP username
$mail->Password = '595959as';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to

$mail->From = 'info@restaurantcanpages.es';
$mail->FromName = 'Restaurante Can Pages';
$mail->addAddress('vdelani@google.com');     // Add a recipient



$mail->isHTML(true);                                  // Set email format to HTML 

$mail->Subject = 'Asunto: Probando';
$mail->Body    = '<b>Probando 123...</b>';


if(!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
	header ('Location: http://restaurantcanpages.com/contacto.html');
}
-----------------------------------------------------------------------------------------------------------------------*/
?>