<?php

define ('COOKIE_SESION', 'cookie_sesion'); // Nombre de la cookie con el ID de sesión.

SeguirUsuario::seguir($_COOKIE[COOKIE_SESION], $_POST['usuario'], $_POST['operacion']);

class SeguirUsuario {
	
	public static function seguir($sesion, $usuario, $operacion) {

		$configuracion = parse_ini_file(dirname($_SERVER['DOCUMENT_ROOT']) . "/configuracion.ini");

		define ('SERVIDOR', $configuracion['servidor']);
		define ('DB_USUARIO', $configuracion['usuario']);
		define ('DB_PASSWORD', $configuracion['password']);
		define ('BASE_DATOS', $configuracion['base_datos']);

		if ($operacion == "insertar") {
			define ('SQL_GESTIONAR_SEGUIDOR', 'INSERT INTO favoritos(usuario_destino, usuario_origen) SELECT ?, usuario FROM usuarios WHERE sesion = ?');							
		} else if ($operacion == "eliminar") {
			define ('SQL_GESTIONAR_SEGUIDOR', 'DELETE FROM favoritos WHERE usuario_destino = ? AND usuario_origen IN (SELECT usuario FROM usuarios WHERE sesion = ?)');							
		} else {
			header("Location: ./index.php");
			die();
		}

		$conexion = new mysqli(SERVIDOR, DB_USUARIO, DB_PASSWORD, BASE_DATOS);

		$sentencia = $conexion->stmt_init();
		$sentencia->prepare(SQL_GESTIONAR_SEGUIDOR);
		$sentencia->bind_param('ss', $usuario, $sesion);

		$sentencia->execute();

		echo 'Usuario: ' . $sesion . '<br/>';
		echo 'Usuario: ' . $usuario . '<br/>';
		echo 'Usuario: ' . $operacion . '<br/>';

		//header("Location: ./index.php");
		//die();
		
	}

}