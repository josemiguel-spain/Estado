<!DOCTYPE html>
<html lang="es-ES">
<head>
	<title>Estado</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="./css/estilo.css">
	<script src="./javascript/validar_formulario.js"></script>
</head>
<body>

	<?php

	// Nombre de la cookie con el ID de sesión.
	define ('COOKIE_SESION', 'cookie_sesion'); 

	/* Si la cookie con ID de sesion existe leemos el usuario y su estado.
	O, al menos, lo intentamos. */
	if(isset($_COOKIE[COOKIE_SESION])) {

		include_once './leer_usuario.php';
		include_once './leer_estado.php';

		define ('USUARIO', LeerUsuario::verUsuario($_COOKIE[COOKIE_SESION]));		
		define ('ESTADO', LeerEstado::verEstado(USUARIO));

	}

	/* Si la constante USUARIO existe y no es nula
	mostramos el formulario de cambiar estado. */
	if(defined('USUARIO') && !is_null(USUARIO)) {

		include './index_usuario.html';

	/* En caso contrario mostramos el formulario de inicio
	de sesión y de registro. */
	} else {

		include './index_formulario.html';

	}

	//
	include './leer_favoritos.php';

	// Insertamos la lista de los últimos usuarios activos.
	include './leer_ultimos.php'; 
	print LeerUltimos::leer();

	?>

</body>
</html>