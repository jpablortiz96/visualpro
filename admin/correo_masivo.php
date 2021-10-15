<?php

	session_start();

	include "../conexion.php";

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require '../PHPMailer/src/Exception.php';
	require '../PHPMailer/src/PHPMailer.php';
	require '../PHPMailer/src/SMTP.php';

	$mail = new PHPMailer;

	if (!empty($_SESSION['idUser'])) {

			$user = $_SESSION['idUser'];
			//$mail->SMTPDebug = 4; 
			$mail->isSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'tls';
			$mail->Host = 'smtp.gmail.com';
			$mail->Port = 587;
			$mail->SMTPOptions = array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
					)
				);
			$mail->Username = 'juanprueba9619@gmail.com'; //Correo de donde enviaremos los correos
			$mail->Password = 'JuanPablo.1996'; // Password de la cuenta de envío
			$mail->CharSet = 'UTF-8';
			$mail->setFrom('juanprueba9619@gmail.com', 'VISUALPRO');

			$result = mysqli_query($conection,"SELECT a.id, a.nombre, a.correo_admin, a.rol FROM administrador a WHERE a.id_organizacion = '$user' AND a.rol = 3");

			while ($row = $result->fetch_array()) {

			    $mail->addAddress($row['correo_admin'], $row['nombre']); //Correo receptor
				$mail->isHTML(true);

				$mail->Subject = 'Tu foto de identificación te espera';
				$mail->Body    = '<h3>Hola, '.$row['nombre'].'</h3><br><br><p>Es momento de crear tu carnet de identificación para lo cual debes subir tu foto dando clic en el siguiente <a href="https://www.google.com/">enlace</a></p><br><p>Tu usuario para acceder a la página es <strong>'.$row['id'].'</strong></p><br><em>Muchas gracias por tu atención</em><br><p><strong>VISUALPRO</strong></p>';

				if($mail->send()) {
					echo '<script type="text/javascript"> alert("Envio de correo masivo exitoso"); window.location="lista_usuarios.php";</script>';
				} else {
					echo '<script type="text/javascript"> alert("Error en el envio de correo masivo"); window.location="lista_usuarios.php";</script>';
				}
				    // Limpiamos los datos par próximos envíos
				    $mail->clearAddresses();
				    $mail->clearAttachments();
				}

	}

?>