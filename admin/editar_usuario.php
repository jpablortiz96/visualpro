<?php  

	session_start();
	if ($_SESSION['rol'] == 3) {
		header("Location: ./");
	}

	include "../conexion.php";

	if (!empty($_POST)) {
		$alert='';
		if (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['rol'])) {

			$alert='<p class="msg_error">Por favor, diligencia todos los campos</p>';

		}else{

			$nombre = $_POST['nombre'];
			$email = $_POST['correo'];
			$user = $_POST['usuario'];
			$clave = md5($_POST['clave']);
			$rol = $_POST['rol'];

			$query = mysqli_query($conection,"SELECT * FROM administrador WHERE (nombre = '$nombre' AND id != '$user') OR (correo_admin = '$email' AND id != '$user')");
			$result = mysqli_fetch_array($query);

			if ($result > 0) {
				$alert='<p class="msg_error">El usuario o correo ya existen</p>';
			}else{

				if (empty($_POST['clave'])){
					$sql_update = mysqli_query($conection, "UPDATE `administrador` SET `id` = '$user', `correo_admin` = '$email', `nombre` = '$nombre', `rol` = '$rol' WHERE `administrador`.`id` = '$user'");
				}else{
					$sql_update = mysqli_query($conection, "UPDATE `administrador` SET `id` = '$user', `contrasena` = '$clave' ,`correo_admin` = '$email', `nombre` = '$nombre', `rol` = '$rol' WHERE `administrador`.`id` = '$user'");
				}

				if ($sql_update) {
					 $alert = '<p class="msg_save">Usuario modificado correctamente</p>';
				}else{
					$alert = '<p class="msg_error">Error en la actualización del usuario</p>';
				}
			}

		}
		mysqli_close($conection); 
	}

	//Validar id
	if (empty($_GET['id'])){
		header('Location: lista_usuarios.php');
		mysqli_close($conection);
	}
	$iduser = $_GET['id'];

	$sql = mysqli_query($conection,"SELECT a.id, a.nombre, a.correo_admin, (a.rol) as idrol, (r.rol) as rol FROM administrador a INNER JOIN rol r on a.rol = r.idrol WHERE id = '$iduser'");
	mysqli_close($conection);

	$result_sql=mysqli_num_rows($sql);

	if ($result_sql == 0) {
		header('Location: lista_usuarios.php');
	}else{
		$option = '';
		while ($data = mysqli_fetch_array($sql)) {
			$iduser = $data['id'];
			$nombre = $data['nombre'];
			$correo = $data['correo_admin'];
			$idrol = $data['idrol'];
			$rol = $data['rol'];

			if ($idrol == 1) {
				$option = '<option value="'.$idrol.'" select>'.$rol.'</option>';
			}else if ($idrol == 2) {
				$option = '<option value="'.$idrol.'" select>'.$rol.'</option>';
			}else if ($idrol == 3) {
				$option = '<option value="'.$idrol.'" select>'.$rol.'</option>';
			}
		}
	}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php" ?>
	<title>Editar usuario</title>
</head>
<body>
	<?php include "includes/header.php" ?>
	<section id="container">
		
		<div class="form_register">
			<h1>Editar datos del usuario</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="post">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" id="nombre" placeholder="Nombre completo" value="<?php echo $nombre; ?>">
				<label for="correo">Correo electrónico</label>
				<input type="email" name="correo" id="correo" placeholder="Correo electrónico" value="<?php echo $correo; ?>">
				<label for="usuario">Usuario</label>
				<input type="text" name="usuario" id="usuario" placeholder="Usuario" value="<?php echo $iduser; ?>">
				<label for="clave">Contraseña</label>
				<input type="password" name="clave" id="clave" placeholder="Contraseña">
				<label for="rol">Tipo Perfil</label>
			
					<?php 
						include "../conexion.php";
						$query_rol=mysqli_query($conection,"SELECT * FROM rol");
						mysqli_close($conection);
						$result_rol=mysqli_num_rows($query_rol);
					?>

				<select name="rol" id="rol" class="notItemOne">
				<?php 
					echo $option;
					if ($result_rol > 0) {
						while ($rol = mysqli_fetch_array($query_rol)) {
				?>
						<option value="<?php echo $rol["idrol"]; ?>"><?php echo $rol["rol"] ?></option>
				<?php
						}
					}
				?> 

				</select>
				<input type="submit" value="Actualizar datos" class="btn_save">
			</form>
		</div>

	</section>
	<script src="js/menu.js"></script>
	<?php include "includes/footer.php" ?>
</body>
</html>