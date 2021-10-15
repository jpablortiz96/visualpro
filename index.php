<?php

$alert = "";
session_start();
if (!empty($_SESSION['active'])) {
	header('location: admin/');
}else{

if (!empty($_POST)) {
	if (empty($_POST['usuario']) || empty($_POST['clave'])) {
		$alert = 'Ingrese su usuario y su clave';
	}else{
		require_once "conexion.php";

		$user = mysqli_real_escape_string($conection, $_POST['usuario']);
		$pass = md5(mysqli_real_escape_string($conection, $_POST['clave']));

		$query = mysqli_query($conection, "SELECT * FROM administrador WHERE id= '$user' AND contrasena = '$pass'");
		mysqli_close($conection);
		$result = mysqli_num_rows($query);

		if ($result > 0) {
			$data = mysqli_fetch_array($query);
			
			$_SESSION['active'] = true;
			$_SESSION['idUser'] = $data['id'];
			$_SESSION['email'] = $data['correo_admin'];
			$_SESSION['nameUser'] = $data['nombre'];
			$_SESSION['rol'] = $data['rol'];
			$_SESSION['idOrganizacion'] = $data['id_organizacion'];

			header('location: admin/');

		}else{
			$alert = 'Usuario o clave incorrecta';
			session_destroy();
		}


	}
}
}

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximun-scale=1.0, minium-scale=1.0">
	<title>Iniciar sesión | VISUALPRO</title>
	<link rel="stylesheet" href="css/estilo.css">

</head>
<body>
	<form class="login-box" action="" method="post">
		<h1>Iniciar sesión</h1>
		<div class="textbox">
			<i class="fa fa-user" aria-hidden="true"></i>
			<input type="text" required placeholder="Usuario" name="usuario">
		</div>
		<div class="textbox">
			<i class="fa fa-lock" aria-hidden="true"></i>
			<input type="password" required placeholder="Contraseña" name="clave">
		</div>
		<input class="btn" type="submit" value="Ingresar">
		<div class="alert">
			<?php echo isset($alert) ? $alert : ''; ?>
		</div>
	</form>


</body>
</html>