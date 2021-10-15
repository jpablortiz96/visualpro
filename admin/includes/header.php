<?php 

if (empty($_SESSION['active'])) {
	header("location: ../");
}

?>	

	<header>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximun-scale=1.0, minium-scale=1.0">
		<div class="header">
			<img class="logo" src="../img/visual.png">
			<div class="optionsBar">
				<p>Colombia, <?php echo fechaC(); ?></p>
				<span>|</span>
				<span class="user"><?php echo $_SESSION['nameUser'].' - '.$_SESSION['rol']; ?></span>
				<img class="photouser" src="img/user.png" alt="Usuario">
				<a href="salir.php"><img class="close" src="img/salir.png" alt="Salir del sistema" title="Salir"></a>
			</div>
		</div>
		<?php include "nav.php" ?>
	</header>

	