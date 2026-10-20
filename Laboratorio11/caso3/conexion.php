<?php
$servidor = "localhost";
$usuario = "root";
$clave = "";
$basedatos = "peluqueria_citas";

$conexion = new mysqli($servidor, $usuario, $clave, $basedatos);
if ($conexion->connect_error) die("Error: " . $conexion->connect_error);
$conexion->set_charset("utf8mb4");
?>
