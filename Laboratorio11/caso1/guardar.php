<?php
require 'conexion.php';

$id_libro = $_POST["id_libro"];
$dni = $_POST["dni"];
$dias = (int)$_POST["dias"];

$stmtUser = $conexion->prepare("SELECT id_usuario FROM usuarios WHERE dni = ?");
$stmtUser->bind_param("s", $dni);
$stmtUser->execute();
$usuario = $stmtUser->get_result()->fetch_assoc();

if (!$usuario) { echo "Usuario no encontrado"; exit; }

$id_usuario = $usuario['id_usuario'];
$fecha_devolucion = date('Y-m-d', strtotime("+ $dias days"));

$sql = "INSERT INTO prestamos (id_libro, id_usuario, fecha_devolucion_estimada) VALUES (?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("iss", $id_libro, $id_usuario, $fecha_devolucion);

if ($stmt->execute()) {
    $stmtStock = $conexion->prepare("UPDATE libros SET stock = stock - 1 WHERE id_libro = ?");
    $stmtStock->bind_param("i", $id_libro);
    $stmtStock->execute();
    $stmtStock->close();
    header("Location: index.php");
}

$stmt->close();
$stmtUser->close();
$conexion->close();
?>
