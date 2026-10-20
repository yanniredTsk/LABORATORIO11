<?php
require 'conexion.php';

$id = $_GET["id"];
$stmt = $conexion->prepare("DELETE FROM citas WHERE id_cita = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();
$conexion->close();

header("Location: index.php");
?>
