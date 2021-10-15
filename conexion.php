<?php

	$host = 'localhost';
	$user = 'eduky';
	$password = '';
	$db = 'visualflexx';

	$conection = @mysqli_connect($host,$user,$password,$db);

	if (!$conection) {
		echo "Error en la conexión de la base de datos";
	}

?>