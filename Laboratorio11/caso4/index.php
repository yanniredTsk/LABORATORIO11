<?php
require 'conexion.php';

$habitaciones = $conexion->query("SELECT * FROM habitaciones WHERE estado = 'Disponible'");
$sqlReservas = "SELECT r.id_reserva, h.nombres, h.apellidos, ha.numero, ha.tipo, 
                r.fecha_entrada, r.fecha_salida, r.total_pagar, r.estado FROM reservas r
                INNER JOIN huespedes h ON r.id_huesped = h.id_huesped
                INNER JOIN habitaciones ha ON r.id_habitacion = ha.id_habitacion
                WHERE r.estado = 'Activa' ORDER BY r.fecha_entrada ASC";
$reservas = $conexion->query($sqlReservas);
?>

<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Hotel - Reservas</title></head>
<body>
    <h1>Sistema de Reservas - Hotel</h1>
    <h2>Nueva reserva</h2>
    <form action="guardar.php" method="POST">
        <label>DNI: <input type="text" name="dni" maxlength="8" required></label><br>
        <label>Nombres: <input type="text" name="nombres" required></label><br>
        <label>Apellidos: <input type="text" name="apellidos" required></label><br>
        <label>Email: <input type="email" name="email"></label><br>
        <label>Teléfono: <input type="text" name="telefono"></label><br>
        <label>Habitación: <select name="id_habitacion" required>
            <?php while ($ha = $habitaciones->fetch_assoc()): ?>
            <option value="<?= $ha['id_habitacion'] ?>"><?= $ha['numero'] ?> - <?= $ha['tipo'] ?> (S/ <?= $ha['precio_noche'] ?>/noche)</option>
            <?php endwhile; ?>
        </select></label><br>
        <label>Entrada: <input type="date" name="fecha_entrada" required></label><br>
        <label>Salida: <input type="date" name="fecha_salida" required></label><br>
        <button type="submit">Crear reserva</button>
    </form>
    <h2>Reservas activas</h2>
    <table border="1" cellpadding="6">
        <tr><th>ID</th><th>Huésped</th><th>Hab</th><th>Entrada</th><th>Salida</th><th>Total</th><th>Acciones</th></tr>
        <?php while ($r = $reservas->fetch_assoc()): ?>
        <tr>
            <td><?= $r['id_reserva'] ?></td>
            <td><?= $r['nombres'] . ' ' . $r['apellidos'] ?></td>
            <td><?= $r['numero'] ?></td>
            <td><?= $r['fecha_entrada'] ?></td>
            <td><?= $r['fecha_salida'] ?></td>
            <td>S/ <?= number_format($r['total_pagar'], 2) ?></td>
            <td><a href="checkout.php?id=<?= $r['id_reserva'] ?>">Checkout</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
<?php $conexion->close(); ?>
