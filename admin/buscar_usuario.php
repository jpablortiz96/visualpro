<?php

	session_start();
	if ($_SESSION['rol'] == 3) {
		header("Location: ./");
	}
	
	
	include "../conexion.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php" ?>
	<title>Lista de usuarios</title>
</head>
<body>
	<?php include "includes/header.php" ?>
	<section id="container">

		<?php 
			$busqueda = $_REQUEST['busqueda'];
			if (empty($busqueda)) {
				header("Location: lista_usuarios.php");
			}
		?>

		<h1>Lista de usuarios</h1>
		<a href="excel_descarga.php" class="btn_new">Descargar DB</a>
		<a href="registro_usuario.php" class="btn_new">Crear usuario</a>
		<a href="registro_masivo.php" class="btn_new">Registro masivo</a>
		<a href="correo_masivo.php" class="btn_email">Correo masivo</a>

		<form action="buscar_usuario.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar usuario" value="<?php echo $busqueda ?>">
			<input type="submit" value="Buscar" class="btn_search">
		</form>

		<table id="lista">
			<tr>
				<th>Identificación</th>
				<th>Nombre</th>
				<th>Correo</th>
				<th>Rol</th>
				<th>Acciones</th>
			</tr>
			<?php

				$rol = '';
				if ($busqueda == 'administrador') {
					$rol = " OR rol LIKE '%1%' ";
				}else if ($busqueda == 'organización') {
					$rol = " OR rol LIKE '%2%' ";
				}else if ($busqueda == 'usuario') {
					$rol = " OR rol LIKE '%3%' ";
				}

				if ($_SESSION['rol'] == 1) {
					$sql_register = mysqli_query($conection, "SELECT COUNT(*) as total_registro FROM `administrador` WHERE (
								    id LIKE '%$busqueda%' OR 
								    nombre LIKE '%$busqueda%' OR
									correo_admin LIKE '%$busqueda%'
									$rol ) 
									AND estado = 1");

				}else if ($_SESSION['rol'] == 2) {
					$user = $_SESSION['idOrganizacion'];
					$sql_register = mysqli_query($conection, "SELECT COUNT(*) as total_registro FROM `administrador` WHERE (
								    id LIKE '%$busqueda%' OR 
								    nombre LIKE '%$busqueda%' OR
									correo_admin LIKE '%$busqueda%'
									$rol ) 
									AND estado = 1 AND id_organizacion = '$user' ");
				}
				

				$result_register = mysqli_fetch_array($sql_register);
				$total_registro = $result_register['total_registro'];

				$por_pagina = 15;

				if (empty($_GET['pagina'])) {
					$pagina = 1;
				}else{
					$pagina = $_GET['pagina'];
				}

				$desde = ($pagina - 1) * $por_pagina;
				$total_paginas = ceil($total_registro / $por_pagina);

				if ($_SESSION['rol'] == 1) {
					$query = mysqli_query($conection, "SELECT a.id, a.nombre, a.correo_admin, r.rol FROM administrador a INNER JOIN rol r ON a.rol = r.idrol  
					WHERE
					(a.id LIKE '%$busqueda%' OR 
					a.nombre LIKE '%$busqueda%' OR
					a.correo_admin LIKE '%$busqueda%' OR
					r.rol LIKE '%$busqueda%') 
					AND
					estado = 1 ORDER BY rol ASC LIMIT $desde,$por_pagina");

				}else if ($_SESSION['rol'] == 2) {
					$user = $_SESSION['idOrganizacion'];
					$query = mysqli_query($conection, "SELECT a.id, a.nombre, a.correo_admin, r.rol FROM administrador a INNER JOIN rol r ON a.rol = r.idrol  
					WHERE
					(a.id LIKE '%$busqueda%' OR 
					a.nombre LIKE '%$busqueda%' OR
					a.correo_admin LIKE '%$busqueda%' OR
					r.rol LIKE '%$busqueda%') 
					AND
					estado = 1 AND id_organizacion = '$user' ORDER BY rol ASC LIMIT $desde,$por_pagina");
				}

				

				mysqli_close($conection);
				$result = mysqli_num_rows($query);
				if ($result > 0) {
					while ($data = mysqli_fetch_array($query)) {
				?>
				<tr>
					<td><?php echo $data["id"]; ?></td>
					<td><?php echo $data["nombre"]; ?></td>
					<td><?php echo $data["correo_admin"]; ?></td>
					<td><?php echo $data["rol"]; ?></td>
					<td>
						<?php if ($data["id"] != 'ADMIN2020+') {?> 
						<a class="link_edit" href="editar_usuario.php?id=<?php echo $data["id"]; ?>">Editar</a>
						|
						<a class="link_email" href="enviar_correo.php?id=<?php echo $data["id"]; ?>">Email</a>
						|
						<a class="link_delete" href="eliminar_usuario.php?id=<?php echo $data["id"]; ?>">Eliminar</a>
						<?php } ?>

					</td>
				</tr>	
			<?php
					}
				}
			?>
			
		</table>

		<?php
			if ($total_registro!=0) {
		?>

		<div class="paginador">
			<ul>
				<?php 

				if ($pagina != 1) {
				 ?>
				<li><a href="?pagina=<?php echo 1; ?>&busqueda=<?php echo $busqueda; ?>">|<</a></li>
				<li><a href="?pagina=<?php echo $pagina-1; ?>&busqueda=<?php echo $busqueda; ?>"><<</a></li>
				<?php 
					}	
					for ($i=1; $i <= $total_paginas; $i++) { 
						if ($i == $pagina) {
							echo '<li class="pageSelected">'.$i.'</li>';
						}else{
							echo '<li><a href="?pagina='.$i.'&busqueda='.$busqueda.'">'.$i.'</a></li>';
						}
					}

					if ($pagina != $total_paginas) {
				?>
				<li><a href="?pagina=<?php echo $pagina+1; ?>&busqueda=<?php echo $busqueda; ?>">>></a></li>
				<li><a href="?pagina=<?php echo $total_paginas; ?>&busqueda=<?php echo $busqueda; ?>">>|</a></li>
			<?php } ?>
			</ul>
		</div>
	<?php } ?>
	</section>
	<?php include "includes/footer.php" ?>
</body>
</html>