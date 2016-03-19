<?php

echo  LeerFavoritos::leer();

class LeerFavoritos {
	
	public static function leer() {

		define ('COOKIE_SESION', 'cookie_sesion'); 

		if(isset($_COOKIE[COOKIE_SESION])) {

			$usuario = $_COOKIE[COOKIE_SESION];		

			// 
			$resultado = '<div class="login">';
			$resultado = $resultado . '<h1>Mis favoritos</h1>';

			$configuracion = parse_ini_file("../configuracion.ini");

			define ('SERVIDOR', $configuracion['servidor']);
			define ('DB_USUARIO', $configuracion['usuario']);
			define ('DB_PASSWORD', $configuracion['password']);
			define ('BASE_DATOS', $configuracion['base_datos']);

			define ('SQL_LEER_FAVORITOS', 'SELECT usuario, estado FROM usuarios WHERE usuario IN (SELECT usuario_destino FROM favoritos WHERE usuario_origen IN (select usuario FROM usuarios WHERE sesion = ?))');

			$xconexion = new mysqli(SERVIDOR, DB_USUARIO, DB_PASSWORD, BASE_DATOS);

			$sentencia = $xconexion->stmt_init();
			$sentencia->prepare(SQL_LEER_FAVORITOS);
			$sentencia->bind_param('s', $usuario);
			$sentencia->execute();
			$sentencia->bind_result($nombreUsuario, $estado);

			$resultado = $resultado . '<table width="100%">';

			while ($r = $sentencia->fetch()) {

				$resultado = $resultado . '<tr><td style="white-space: nowrap;"><form action="./gestionar_seguidores.php" method="post" style="display: table;">';
				$resultado = $resultado . '<input type="hidden" name="usuario" value="' . $nombreUsuario . '"/>';
				$resultado = $resultado . '<input type="hidden" name="operacion" value="eliminar"/>';
				$resultado = $resultado . '<input type="submit" value="Eliminar"/>';
				$resultado = $resultado . '</form></td><td style="white-space: nowrap;">';
				$resultado = $resultado . '<strong>' . $nombreUsuario . ': </strong>';
				$resultado = $resultado . '</td><td width="99%">';
				$resultado = $resultado . $estado;
				$resultado = $resultado . '</td></tr>';

			}

			$resultado = $resultado . '</table>';
			
			$resultado = $resultado . '<p><form action="./gestionar_seguidores.php" method="post"/><input type="hidden" name="operacion" value="insertar"/>Seguir a: <input type="text" name="usuario"/><input type="submit"/></form></div></p>';

			$resultado = $resultado . '</div>';

			return $resultado;

		}

	}

}

?>