<?php
$servidor = "localhost";
$usuario = "root";
$clave = "";
$basedatos = "farmacia_ventas";

$conexion = new mysqli($servidor, $usuario, $clave, $basedatos);
if ($conexion->connect_error) die("Error: " . $conexion->connect_error);
$conexion->set_charset("utf8mb4");
?>
