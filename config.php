<?php

$host = "localhost";
$db_name = "glpi_original";
$username = "root";
$password = "ausias";


$con = new mysqli($host, $username, $password, $db_name);
if ($con->connect_errno) { // Si se produce algún error finaliza con mensaje de error
 die("Error de Conexión: " . $con->connect_error);
}
$con->set_charset("utf8");

?>