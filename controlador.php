<?php

include 'config.php';
include_once 'functions.php';

sec_session_start();
$usuario = filter_input(INPUT_POST, 'usuario', $filter = FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'psha', $filter = FILTER_SANITIZE_STRING); // The hashed password.

if (!login($conexion)) { //no estas autorizado
        if (isset($usuario, $password)) {
                if (login($usuario, $password, $conexion) == true) {
                        // Éxito
                         $accion = $default_action; //acción por defecto
                         echo "<div class=\"logout\"> <a href=\"index.php?accion=logout\"> logout {$_SESSION['usuario']} </a></div>";
                     } else {
                        // Login error: no coinciden usuario y password
                         $accion = "login";
                     }
                } else {
                    //significa que aún no has valores para usuario y password
                     $accion = "login";
                }
       } else { //estás autorizado
            $accion = basename(filter_input(INPUT_GET, 'accion', $filter = FILTER_SANITIZE_STRING));
            switch ($accion){
                case 'login': $accion = $default_action;break;
                case 'logout':logout();$accion='login';
            }
             echo "<div class=\"logout\"> <a href=\"index.php?accion=logout\"> logout {$_SESSION['usuario']} </a></div>";
                if (!isset($accion)) {
                        $accion = $default_action; //acción por defecto $default_action = "lista"
                }
                if (!file_exists($accion . '.php')) { //comprobamos que el fichero exista
                        $accion = $default_action; //si no existe mostramos la página por defecto
                        echo "Operación no soportada: Podíamos mostrar la página 404";
                }
       }
include( $accion . '.php'); //y ahora mostramos la pagina llamada
?>