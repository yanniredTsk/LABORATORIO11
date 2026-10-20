<?php
require 'conexion.php';

$id = $_GET["id"];

$stmtRes = $conexion->prepare("SELECT id_habitacion FROM reservas WHERE id_reserva = ?");
$stmtRes->bind_param("i", $id);
$stmtRes->execute();
$res = $stmtRes->get_result()->fetch_assoc();

$sql = "UPDATE reservas SET estado = 'Finalizada' WHERE id_reserva = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$stmtHab = $conexion->prepare("UPDATE habitaciones SET estado = 'Disponible' WHERE id_habitacion = ?");
$stmtHab->bind_param("i", $res['id_habitacion']);
$stmtHab->execute();

$stmt->close();
$stmtRes->close();
$stmtHab->close();
$conexion->close();

header("Location: index.php");
?>
