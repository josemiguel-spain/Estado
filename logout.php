<?php

define ('COOKIE_SESION', 'cookie_sesion'); // Nombre de la cookie con el ID de sesión.

echo 'Cerrando sesion con ID: ' . $_COOKIE[COOKIE_SESION] . '</br>';

Logout::escribir($_COOKIE[COOKIE_SESION]);

class Logout {
	
	public static function escribir($sesion) {

		$configuracion = parse_ini_file(dirname($_SERVER['DOCUMENT_ROOT']) . "/configuracion.ini");

		define ('SERVIDOR', $configuracion['servidor']);
		define ('DB_USUARIO', $configuracion['usuario']);
		define ('DB_PASSWORD', $configuracion['password']);
		define ('BASE_DATOS', $configuracion['base_datos']);

		define ('SQL_LEER', 'UPDATE usuarios SET sesion = "" WHERE sesion = ?');

		$conexion = new mysqli(SERVIDOR, DB_USUARIO, DB_PASSWORD, BASE_DATOS);

		$sentencia = $conexion->stmt_init();
		$sentencia->prepare(SQL_LEER);
		$sentencia->bind_param('s', $sesion);
		
		if ($sentencia->execute()) {
			setcookie(COOKIE_SESION, '', 0, '/');
		}

		header("Location: ./index.php");
		die();
		
	}

}