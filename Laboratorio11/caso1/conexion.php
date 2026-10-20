<?php
$servidor = "localhost";
$usuario = "root";
$clave = "";
$basedatos = "biblioteca_municipal";
$conexion = new mysqli($servidor, $usuario, $clave, $basedatos);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
$conexion->set_charset("utf8mb4");
?>
