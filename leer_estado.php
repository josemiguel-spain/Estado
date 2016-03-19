<?php

// echo  '<h1>' . LeerEstado::verEstado($_GET['usuario']) . '</h1>';

class LeerEstado {
	
	public static function verEstado($usuario) {

		$configuracion = parse_ini_file(dirname($_SERVER['DOCUMENT_ROOT']) . "/configuracion.ini");

		define ('SERVIDOR', $configuracion['servidor']);
		define ('DB_USUARIO', $configuracion['usuario']);
		define ('DB_PASSWORD', $configuracion['password']);
		define ('BASE_DATOS', $configuracion['base_datos']);

		define ('SQL_LEER_ESTADO', 'SELECT estado FROM usuarios WHERE usuario = ?');

		$conexion = new mysqli(SERVIDOR, DB_USUARIO, DB_PASSWORD, BASE_DATOS);

		$sentencia = $conexion->stmt_init();
		$sentencia->prepare(SQL_LEER_ESTADO);
		$sentencia->bind_param('s', $usuario);
		$sentencia->execute();
		$sentencia->bind_result($leerEstado);
		$sentencia->fetch();

		return $leerEstado;

	}

	public static function verCaca() {

		return 'caca';

	}

}

?>