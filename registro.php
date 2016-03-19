<?php

$configuracion = parse_ini_file(dirname($_SERVER['DOCUMENT_ROOT']) . "/configuracion.ini");

define ('SERVIDOR', $configuracion['servidor']);
define ('DB_USUARIO', $configuracion['usuario']);
define ('DB_PASSWORD', $configuracion['password']);
define ('BASE_DATOS', $configuracion['base_datos']);

define ('SQL_INSERTAR', 'INSERT INTO usuarios(usuario, password, estado, ultima_actualizacion) VALUES(?, ?, "¡Hola, mundo!", now())');

$usuario = $_POST['usuario'];

$password1 = $_POST['password'];
$password2 = $_POST['password2'];

$error = false;
$descripcionError = '';

if (strlen($password1) < 8) {
	$error = true;
	$descripcionError = 'La contrase&ntilde;a es demasiado corta.';
}

if (strcmp($password1, $password2) !== 0) {
	$error = true;
	$descripcionError = 'La contrase&ntilde;a y la verificaci&oacute;n no coinciden.';
}

if (strlen($usuario) < 4) {
	$error = true;
	$descripcionError = 'El nombre de usuario es demasiado corto.';
}

if (preg_match_all("/\w+/", $usuario) === FALSE) {
//if (!ctype_alnum($usuario)) {
	$error = true;
	$descripcionError = 'El nombre de usuario solo puede contener car&aacute;cteres alfanum&eacute;ricos.';
}

if ($error == false) {

	$password = password_hash($password1, PASSWORD_DEFAULT);
	$conexion = new mysqli(SERVIDOR, DB_USUARIO, DB_PASSWORD, BASE_DATOS);
	$sentencia = $conexion->stmt_init();
	$sentencia->prepare(SQL_INSERTAR);
	$sentencia->bind_param('ss', $usuario, $password);

	if ($sentencia->execute()) {
		echo '&Eacute;xito.';
	} else {
		$error = true;
		$descripcionError = 'El nombre de usuario seleccionado ya est&aacute; en uso.';
	}

}

if ($error == true) {
	echo $descripcionError;
} else {
	header("Location: ./index.php");
	die();
}

?>