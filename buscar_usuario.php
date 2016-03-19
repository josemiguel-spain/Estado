<?php

$usuario = $_GET['usuario'];

$configuracion = parse_ini_file("../configuracion.ini");

define ('SERVIDOR', $configuracion['servidor']);
define ('DB_USUARIO', $configuracion['usuario']);
define ('DB_PASSWORD', $configuracion['password']);
define ('BASE_DATOS', $configuracion['base_datos']);

define ('SQL_BUSCAR_USUARIO', 'SELECT count(*) FROM usuarios WHERE usuario = ?;');

$conexion = new mysqli(SERVIDOR, DB_USUARIO, DB_PASSWORD, BASE_DATOS);

$sentencia = $conexion->stmt_init();
$sentencia->prepare(SQL_BUSCAR_USUARIO);
$sentencia->bind_param('s', $usuario);
$sentencia->execute();
$sentencia->bind_result($numeroUsuarios);
$sentencia->fetch();

echo $numeroUsuarios;

?>