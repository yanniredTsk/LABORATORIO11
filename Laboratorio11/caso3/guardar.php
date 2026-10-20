<?php
require 'conexion.php';

$nombre_cliente = $_POST["nombre_cliente"];
$telefono = $_POST["telefono"];
$id_servicio = $_POST["id_servicio"];
$fecha = $_POST["fecha"];
$hora = $_POST["hora"];

$stmtCheck = $conexion->prepare("SELECT id_cliente FROM clientes WHERE nombre = ?");
$stmtCheck->bind_param("s", $nombre_cliente);
$stmtCheck->execute();
$resultado = $stmtCheck->get_result();

if ($resultado->num_rows > 0) {
    $cliente = $resultado->fetch_assoc();
    $id_cliente = $cliente['id_cliente'];
} else {
    $stmtNew = $conexion->prepare("INSERT INTO clientes (nombre, telefono) VALUES (?, ?)");
    $stmtNew->bind_param("ss", $nombre_cliente, $telefono);
    $stmtNew->execute();
    $id_cliente = $stmtNew->insert_id;
    $stmtNew->close();
}

$sql = "INSERT INTO citas (id_cliente, id_servicio, fecha, hora) VALUES (?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("iiss", $id_cliente, $id_servicio, $fecha, $hora);

if ($stmt->execute()) header("Location: index.php");

$stmt->close();
$stmtCheck->close();
$conexion->close();
?>
