<?php
require 'conexion.php';

$dni = $_POST["dni"];
$nombres = $_POST["nombres"];
$apellidos = $_POST["apellidos"];
$email = $_POST["email"];
$telefono = $_POST["telefono"];
$id_habitacion = $_POST["id_habitacion"];
$fecha_entrada = $_POST["fecha_entrada"];
$fecha_salida = $_POST["fecha_salida"];

$stmtCheck = $conexion->prepare("SELECT id_huesped FROM huespedes WHERE dni = ?");
$stmtCheck->bind_param("s", $dni);
$stmtCheck->execute();
$resultado = $stmtCheck->get_result();

if ($resultado->num_rows > 0) {
    $huesped = $resultado->fetch_assoc();
    $id_huesped = $huesped['id_huesped'];
} else {
    $stmtNew = $conexion->prepare("INSERT INTO huespedes (dni, nombres, apellidos, email, telefono) VALUES (?, ?, ?, ?, ?)");
    $stmtNew->bind_param("sssss", $dni, $nombres, $apellidos, $email, $telefono);
    $stmtNew->execute();
    $id_huesped = $stmtNew->insert_id;
    $stmtNew->close();
}

$stmtPrecio = $conexion->prepare("SELECT precio_noche FROM habitaciones WHERE id_habitacion = ?");
$stmtPrecio->bind_param("i", $id_habitacion);
$stmtPrecio->execute();
$habitacion = $stmtPrecio->get_result()->fetch_assoc();

$fecha_entrada_obj = new DateTime($fecha_entrada);
$fecha_salida_obj = new DateTime($fecha_salida);
$noches = $fecha_salida_obj->diff($fecha_entrada_obj)->days;
$total = $habitacion['precio_noche'] * $noches;

$sql = "INSERT INTO reservas (id_huesped, id_habitacion, fecha_entrada, fecha_salida, total_pagar) VALUES (?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("iissd", $id_huesped, $id_habitacion, $fecha_entrada, $fecha_salida, $total);

if ($stmt->execute()) {
    $stmtUpdate = $conexion->prepare("UPDATE habitaciones SET estado = 'Ocupada' WHERE id_habitacion = ?");
    $stmtUpdate->bind_param("i", $id_habitacion);
    $stmtUpdate->execute();
    $stmtUpdate->close();
    header("Location: index.php");
}

$stmt->close();
$stmtCheck->close();
$stmtPrecio->close();
$conexion->close();
?>
