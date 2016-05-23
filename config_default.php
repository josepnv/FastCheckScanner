<?php

$host = "";
$db_name = "";
$username = "";
$password = "";


$conexion = new mysqli($host, $username, $password, $db_name);
if ($conexion->connect_errno) { // Si se produce algún error finaliza con mensaje de error
 die("Error de Conexión: " . $conexion->connect_error);
}
$con->set_charset("utf8");


$intentos_login = 5;
$tiempo_fuerzabruta = 2; //horas
$secure = false; //por defecto no obligar a https
$default_action = 'lista';
?>
