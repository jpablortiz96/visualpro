		
		<div class="menu" id="show-menu">
		<nav>
			<ul>
				<?php if ($_SESSION['rol'] == 3) { ?>
					<li><a href="inicio_foto.php"><i class="fas fa-home"></i>Inicio</a></li>
				<?php } ?>

				<?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
				?>
				<li><a href="index.php"><i class="fas fa-home"></i>Inicio</a></li>
				<?php } ?>

				<?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
				?>
				<!--<li class="principal">
					<a href="#">Empresas</a>
					<ul>
						<li><a href="#">Nueva Empresa</a></li>
						<li><a href="#">Lista de Empresas</a></li>
					</ul>
				</li>-->
				<li class="principal">
					<a href="#"><i class="fas fa-users"></i>Usuarios</a>
					<ul>
						<li><a href="registro_usuario.php"><i class="far fa-user"></i>Nuevo Usuario</a></li>
						<li><a href="lista_usuarios.php"><i class="fas fa-list"></i>Lista de Usuarios</a></li>
					</ul>
				</li>
				<li id="salir_menu"><a href="salir.php"><i class="fas fa-sign-out-alt"></i>Salir</a></li>
			<?php } ?>
			</ul>
		</nav>	
		</div>
		<div id="icon-menu">
		<i class="fas fa-bars"></i>
		</div>



