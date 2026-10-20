<?php
require 'conexion.php';

$id_medicamento = $_POST["id_medicamento"];
$cantidad = (int)$_POST["cantidad"];

$stmtM = $conexion->prepare("SELECT precio_base, stock FROM medicamentos WHERE id_medicamento = ?");
$stmtM->bind_param("i", $id_medicamento);
$stmtM->execute();
$medicamento = $stmtM->get_result()->fetch_assoc();

if ($medicamento['stock'] < $cantidad) { echo "Stock insuficiente"; exit; }

$subtotal = $medicamento['precio_base'] * $cantidad;
$total = $subtotal * 1.18;

$sql = "INSERT INTO ventas (id_medicamento, cantidad, total) VALUES (?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("iid", $id_medicamento, $cantidad, $total);

if ($stmt->execute()) {
    $stmtStock = $conexion->prepare("UPDATE medicamentos SET stock = stock - ? WHERE id_medicamento = ?");
    $stmtStock->bind_param("ii", $cantidad, $id_medicamento);
    $stmtStock->execute();
    $stmtStock->close();
    header("Location: index.php");
}

$stmt->close();
$stmtM->close();
$conexion->close();
?>
