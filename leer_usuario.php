<?php

// echo  '<h1>' . LeerUsuario::verUsuario($_GET['sesion']) . '</h1>';

class LeerUsuario {
	
	public static function verUsuario($sesion) {

		$configuracion = parse_ini_file("../configuracion.ini");

		define ('SERVIDOR', $configuracion['servidor']);
		define ('DB_USUARIO', $configuracion['usuario']);
		define ('DB_PASSWORD', $configuracion['password']);
		define ('BASE_DATOS', $configuracion['base_datos']);

		define ('SQL_LEER', 'SELECT usuario FROM usuarios WHERE sesion = ?');

		$conexion = new mysqli(SERVIDOR, DB_USUARIO, DB_PASSWORD, BASE_DATOS);

		$sentencia = $conexion->stmt_init();
		$sentencia->prepare(SQL_LEER);
		$sentencia->bind_param('s', $sesion);
		$sentencia->execute();
		$sentencia->bind_result($leerEstado);
		$sentencia->fetch();

		return $leerEstado;

	}

	/*
	public static function verEstado($usuario) {

		$configuracion = parse_ini_file("../configuracion.ini");

		define ('SERVIDOR', $configuracion['servidor']);
		define ('DB_USUARIO', $configuracion['usuario']);
		define ('DB_PASSWORD', $configuracion['password']);
		define ('BASE_DATOS', $configuracion['base_datos']);

		define ('SQL_ESTADO', 'SELECT estado FROM usuarios WHERE usuario = ?');

		$conexion = new mysqli(SERVIDOR, DB_USUARIO, DB_PASSWORD, BASE_DATOS);

		$sentencia = $conexion->stmt_init();
		$sentencia->prepare(SQL_ESTADO);
		$sentencia->bind_param('s', $usuario);
		$sentencia->execute();
		$sentencia->bind_result($leerEstado);
		$sentencia->fetch();

		return $leerEstado;

	}
	*/

}

?>