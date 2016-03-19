<?php

define ('COOKIE_SESION', 'cookie_sesion'); // Nombre de la cookie con el ID de sesión.

EscribirEstado::escribir($_COOKIE[COOKIE_SESION], $_GET['mensaje']);

class EscribirEstado {
	
	public static function escribir($sesion, $mensaje) {

		$mensaje_tratado = htmlspecialchars($mensaje, ENT_QUOTES);

		$error = false;
		$descripcionError = "";

		if (strlen($mensaje_tratado) > 140) {
			$error = true;
			$descripcionError = "El mensaje tiene demasiados car&aacute;cteres.";
		}

		if (strlen($mensaje_tratado) < 1) {
			$error = true;
			$descripcionError = "El mensaje est&aacute; vac&iacute;o.";
		}

		if ($error == false) {

			$configuracion = parse_ini_file(dirname($_SERVER['DOCUMENT_ROOT']) . "/configuracion.ini");

			define ('SERVIDOR', $configuracion['servidor']);
			define ('DB_USUARIO', $configuracion['usuario']);
			define ('DB_PASSWORD', $configuracion['password']);
			define ('BASE_DATOS', $configuracion['base_datos']);

			define ('SQL_LEER', 'UPDATE usuarios SET estado = ?, ultima_actualizacion = now() WHERE sesion = ?');

			$conexion = new mysqli(SERVIDOR, DB_USUARIO, DB_PASSWORD, BASE_DATOS);

			$sentencia = $conexion->stmt_init();
			$sentencia->prepare(SQL_LEER);
			$sentencia->bind_param('ss', $mensaje_tratado, $sesion);

			$sentencia->execute();

			header("Location: ./index.php");
			die();

		} else {

			echo $descripcionError;

		}
		
	}

}