<?php 

if (empty($_SESSION['active'])) {
	header("location: ../");
}

?>	

<a class="appWhatsapp" href="https://api.whatsapp.com/send?phone=573176352066&text=Hola%2C%20tengo%20una%20inquietud">
	<img src="./img/whatsapp.png" alt="whatsapp">
</a>

	<footer class="navbar navbar-fixed-bottom">
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximun-scale=1.0, minium-scale=1.0">

		<p class="texto">Todos Los Derechos Reservados &copy;-VISUALPRO 2020 - VISUALFLEXX SAS NIT 900698975-6</p>
		<p class="texto">VISUALPRO es nombre comercial de VISUALFLEXX SAS</p>

		<table>
			<tr>
				<td id="links_footer">
					<a class="link_footer" href="https://visualpro.com.co/tarjetas-%26-carnets">Tarjeta y Carnets</a>
					|
					<a class="link_footer" href="https://visualpro.com.co/se%C3%B1alizaci%C3%B3n-1">Señalización</a>
					|
					<a class="link_footer" href="https://visualpro.com.co/papeleria-y-publicitarios">Papeleria y Publicitarios</a>
				</td>
			</tr>
		</table>

		<div class="sociales">
			<a href="https://www.facebook.com/plasticosimpresos/" class="facebook"><i class="fa fa-facebook"></i></a>
			<a href="https://www.instagram.com/visualpro.com.co/" class="instagram"><i class="fa fa-instagram"></i></a>
		</div>

	</footer>