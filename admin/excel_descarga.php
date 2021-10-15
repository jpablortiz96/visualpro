<?php

	session_start();
	if ($_SESSION['rol'] == 3) {
		header("Location: ./");
	}

	header('Content-type:application/xls');
	header('Content-Disposition: attachment; filename=basededatos_visualflexx.xls');

	include "../conexion.php";

	if ($_SESSION['rol'] == 1) {
		$query="SELECT * FROM administrador";
		$result=mysqli_query($conection, $query);
	?>	
	
	<table border="1">
	<tr>
		<th>nombre</th>
		<th>id</th>
		<th>contrasena</th>
		<th>correo_admin</th>
		<th>id_organizacion	</th>
		<th>foto</th>
		<th>rol</th>
		<th>estado</th>
	</tr>
	<?php
		while ($row=mysqli_fetch_assoc($result)) {
			?>
				<tr>
					<td><?php echo $row['nombre']; ?></td>
					<td><?php echo $row['id']; ?></td>
					<td><?php echo $row['contrasena']; ?></td>
					<td><?php echo $row['correo_admin']; ?></td>
					<td><?php echo $row['id_organizacion']; ?></td>
					<td><?php echo $row['foto']; ?></td>
					<td><?php echo $row['rol']; ?></td>
					<td><?php echo $row['estado']; ?></td>
				</tr>	

			<?php
		}

	?>
</table>


<?php	} ?>


<?php

	if ($_SESSION['rol'] == 2) {
		$user = $_SESSION['idOrganizacion'];
		$query="SELECT * FROM administrador WHERE estado = 1 AND rol = 3 AND id_organizacion = '$user' ORDER BY nombre";
		$result=mysqli_query($conection, $query);
?>	

	<table border="1">
	<tr>
		<th>nombre</th>
		<th>id</th>
		<th>contrasena</th>
		<th>correo_admin</th>
		<th>foto</th>
	</tr>
	<?php
		while ($row=mysqli_fetch_assoc($result)) {
			?>
				<tr>
					<td><?php echo $row['nombre']; ?></td>
					<td><?php echo $row['id']; ?></td>
					<td><?php echo $row['contrasena']; ?></td>
					<td><?php echo $row['correo_admin']; ?></td>
					<td><?php echo $row['foto']; ?></td>
				</tr>	

			<?php
		}

	?>
</table>

<?php } ?>
	
