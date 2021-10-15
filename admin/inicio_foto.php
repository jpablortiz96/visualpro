<?php
	session_start();
	include "../conexion.php";
	$folder = 'imagenes/';
	$orig_w = 480;

	if (isset($_POST['submit'])) {

		if ($_FILES['img']['type'] == 'image/jpeg') {
			$user = $_SESSION['idUser'];
			$imageFile = $_FILES['img']['tmp_name'];
			$filename = $user.'-'.$_FILES['img']['name'];
			$tamano = $_POST['tamanoFoto'];

			list($width, $height) = getimagesize($imageFile);

			$src = imagecreatefromjpeg($imageFile);
			$orig_h = ($height/$width)*$orig_w;

			$tmp = imagecreatetruecolor($orig_w, $orig_h);
			imagecopyresampled($tmp, $src, 0, 0, 0, 0, $orig_w, $orig_h, $width, $height);
			imagejpeg($tmp, $folder.$filename,100);

			imagedestroy($tmp);
			imagedestroy($src);

			$filename = urlencode($filename);
			header("Location: crop.php?filename=$filename&height=$orig_h&size=$tamano");

		} elseif ($_FILES['img']['type'] == 'image/png') {

			$user = $_SESSION['idUser'];
			$imageFile = $_FILES['img']['tmp_name'];
			$filename = $user.'-'.$_FILES['img']['name'];
			$tamano = $_POST['tamanoFoto'];

			list($width, $height) = getimagesize($imageFile);

			$src = imagecreatefrompng($imageFile);
			$orig_h = ($height/$width)*$orig_w;

			$tmp = imagecreatetruecolor($orig_w, $orig_h);
			imagecopyresampled($tmp, $src, 0, 0, 0, 0, $orig_w, $orig_h, $width, $height);
			imagejpeg($tmp, $folder.$filename,100);

			imagedestroy($tmp);
			imagedestroy($src);

			$filename = urlencode($filename);
			header("Location: crop.php?filename=$filename&height=$orig_h&size=$tamano");

		} else {
			echo '<script type="text/javascript"> alert("Archivo de foto incorrecto, recuerde que debe ser una foto de formato .jpg o .png"); window.location="inicio_foto.php";</script>';
			die();
		}		
	}	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximun-scale=1.0, minium-scale=1.0">
	<?php include "includes/scripts.php" ?>
	<title>VISUALPRO</title>
</head>
<body>
	<?php include "includes/header.php" ?>
	<div id="container">
		<div class="form_register">
			<h1>Foto de Identificación</h1>
			<ul>
			  <li>Elija el tamaño de la identificación con foto y las dimensiones de la placa de identificación con fotografía, según el estándar deseado.</li>
			  <li>Suba una foto suya desde la cámara de su teléfono inteligente, cámara web, cámara o un escaneo de una foto en papel. Elige un fondo claro, una cara y una expresión neutra.</li>
			  <li>¡Es simple y gratis y sin registro!</li>
			</ul>
			<hr>
			<form name="frmcargararchivo" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
				<table>
					<td><input type="file" REQUIRED name="img" id="img"></td>
				</table>
				<select name="tamanoFoto" id="tamanoFoto">    
                            <option value="3x4">Foto Rectangular 3X4 cm</option>    
                            <option value="3x3">Foto Cuadrada 3X3 cm</option>       
                </select><br>
			<input class="btn_save" type="submit" name="submit" value="Aceptar"/>
			</form>	
			</div>
		
	</div>
	<script src="js/menu.js"></script>
	<?php include "includes/footer.php" ?>
</body>
</html>