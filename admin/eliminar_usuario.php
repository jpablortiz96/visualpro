<?php 

	session_start();
	if ($_SESSION['rol'] == 3) {
		header("Location: ./");
	}

	include "../conexion.php";

	if (!empty($_POST)) {
		if ($_POST['idusuario']=="ADMIN2020+") {
			header("Location: lista_usuarios.php");
			mysqli_close($conection);
			exit;
		}
		$idusuario = $_POST['idusuario'];
		//$query_delete = mysqli_query($conection, "DELETE FROM administrador WHERE id ='$idusuario'");
		$query_delete = mysqli_query($conection, "UPDATE administrador SET estado = 0 WHERE id ='$idusuario'");
		mysqli_close($conection);
		if ($query_delete) {
			header("location: lista_usuarios.php");

		}else{
			echo "Error al eliminar el usuario";
		}
	}


	if (empty($_REQUEST['id']) || $_REQUEST['id'] == 'ADMIN2020+') {
		header("location: lista_usuarios.php");
		mysqli_close($conection);
	}else {
		include "../conexion.php";
		$idusuario = $_REQUEST['id'];
		$query = mysqli_query($conection,"SELECT a.id, a.nombre, (a.rol) as idrol, (r.rol) as rol FROM administrador a INNER JOIN rol r ON a.rol = r.idrol WHERE a.id = '$idusuario'");
		mysqli_close($conection);
		$result = mysqli_num_rows($query);
		if ($result>0) {
			while ($data = mysqli_fetch_array($query)) {
				$nombre = $data['nombre'];
				$usuario = $data['id'];
				$rol = $data['rol'];
			}
		}else{
				header("Location: lista_usuarios.php");
			}
		}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php" ?>
	<title>Eliminar usuario</title>
</head>
<body>
	<?php include "includes/header.php" ?>
	<section id="container">
		<div class="data_delete">
		<h2>¿Estas seguro que deseas eliminar el siguiente usuario?</h2>
		<p>Nombre: <span><?php echo $nombre; ?></span></p>
		<p>Usuario: <span><?php echo $usuario; ?></span></p>
		<p>Rol: <span><?php echo $rol; ?></span></p>

		<form method="post" action="">
			<input type="hidden" name="idusuario" value="<?php echo $idusuario; ?>">
			<a href="lista_usuarios.php" class="btn_cancel">Cancelar</a>
			<input type="submit" value="Aceptar" class="btn_ok" >
		</form>
		</div>
	</section>
	<script src="js/menu.js"></script>
	<?php include "includes/footer.php" ?>
</body>
</html>