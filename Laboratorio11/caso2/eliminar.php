<?php
require 'conexion.php';

$id = $_GET["id"];
$stmt = $conexion->prepare("DELETE FROM ventas WHERE id_venta = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();
$conexion->close();

header("Location: index.php");
?>
