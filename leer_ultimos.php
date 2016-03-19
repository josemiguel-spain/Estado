<?php

// echo  LeerUltimos::leer();

class LeerUltimos {
	
	public static function leer() {

		// 
		$resultado = '<div class="login">';
		$resultado = $resultado . '<h1>&Uacute;ltimas actualizaciones</h1>';

		$configuracion = parse_ini_file("../configuracion.ini");

		define ('SERVIDOR', $configuracion['servidor']);
		define ('DB_USUARIO', $configuracion['usuario']);
		define ('DB_PASSWORD', $configuracion['password']);
		define ('BASE_DATOS', $configuracion['base_datos']);

		define ('SQL_LEER_ULTIMOS', 'SELECT usuario FROM usuarios ORDER BY ultima_actualizacion DESC LIMIT 100');

		$xconexion = new mysqli(SERVIDOR, DB_USUARIO, DB_PASSWORD, BASE_DATOS);

		$sentencia = $xconexion->stmt_init();
		$sentencia->prepare(SQL_LEER_ULTIMOS);
		$sentencia->execute();
		$sentencia->bind_result($nombreUsuario);

		while ($r = $sentencia->fetch()) {

			include_once './leer_estado.php';
			$resultado = $resultado . '<p><strong> ' . $nombreUsuario . ': </strong>' . LeerEstado::verEstado($nombreUsuario) . '</p>';

		}

		$resultado = $resultado . '</div>';

		return $resultado;

	}

}

?>