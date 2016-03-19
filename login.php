<?php

$configuracion = parse_ini_file("../configuracion.ini");

define ('COOKIE_SESION', 'cookie_sesion'); // Nombre de la cookie con el ID de sesión.
define ('COOKIE_DURACION', 30); // Duración en días.

define ('SERVIDOR', $configuracion['servidor']);
define ('DB_USUARIO', $configuracion['usuario']);
define ('DB_PASSWORD', $configuracion['password']);
define ('BASE_DATOS', $configuracion['base_datos']);

define ('SQL_COMPROBAR', 'SELECT password FROM usuarios WHERE usuario = ?');
define ('SQL_ACTUALIZAR_SESION', 'UPDATE usuarios SET sesion = ? WHERE usuario = ?');

$usuario = $_POST['usuario'];
$password = $_POST['password'];

$conexion = new mysqli(SERVIDOR, DB_USUARIO, DB_PASSWORD, BASE_DATOS);

$sentencia = $conexion->stmt_init();
$sentencia->prepare(SQL_COMPROBAR);
$sentencia->bind_param('s', $usuario);
$sentencia->execute();
$sentencia->bind_result($read_password);
$sentencia->fetch();

if (password_verify($password, $read_password)) {

	$sesion = $usuario . randomString(10);

	$sentencia = $conexion->stmt_init();
	$sentencia->prepare(SQL_ACTUALIZAR_SESION);
	$sentencia->bind_param('ss', $sesion, $usuario);

	if ($sentencia->execute()) {
		setcookie(COOKIE_SESION, $sesion, time() + (86400 * COOKIE_DURACION), "/");

		header("Location: ./index.php");
		die();

	} else {
		
		echo '<p>Error al crear la sesión.</p>';
	}

} else { 
	
	echo '<p>Error al validar.</p>';

}

function randomString($longitud) {

    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $longitud; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;

}

?>