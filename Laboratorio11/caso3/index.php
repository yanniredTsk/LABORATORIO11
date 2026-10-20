<?php
require 'conexion.php';

$servicios = $conexion->query("SELECT * FROM servicios");
$sqlCitas = "SELECT c.id_cita, cl.nombre, s.nombre as servicio, c.fecha, c.hora, c.estado, s.precio
             FROM citas c INNER JOIN clientes cl ON c.id_cliente = cl.id_cliente
             INNER JOIN servicios s ON c.id_servicio = s.id_servicio
             WHERE c.fecha >= CURDATE() ORDER BY c.fecha ASC, c.hora ASC";
$citas = $conexion->query($sqlCitas);
?>

<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Peluquería - Citas</title></head>
<body>
    <h1>Sistema de Citas - Peluquería</h1>
    <h2>Agendar nueva cita</h2>
    <form action="guardar.php" method="POST">
        <label>Cliente: <input type="text" name="nombre_cliente" required></label><br>
        <label>Teléfono: <input type="text" name="telefono"></label><br>
        <label>Servicio: <select name="id_servicio" required>
            <?php while ($s = $servicios->fetch_assoc()): ?>
            <option value="<?= $s['id_servicio'] ?>"><?= $s['nombre'] ?> - S/ <?= $s['precio'] ?></option>
            <?php endwhile; ?>
        </select></label><br>
        <label>Fecha: <input type="date" name="fecha" required></label><br>
        <label>Hora: <input type="time" name="hora" required></label><br>
        <button type="submit">Agendar cita</button>
    </form>
    <h2>Citas próximas</h2>
    <table border="1" cellpadding="6">
        <tr><th>ID</th><th>Cliente</th><th>Servicio</th><th>Fecha</th><th>Hora</th><th>Acciones</th></tr>
        <?php while ($c = $citas->fetch_assoc()): ?>
        <tr>
            <td><?= $c['id_cita'] ?></td>
            <td><?= $c['nombre'] ?></td>
            <td><?= $c['servicio'] ?></td>
            <td><?= $c['fecha'] ?></td>
            <td><?= $c['hora'] ?></td>
            <td><a href="cancelar.php?id=<?= $c['id_cita'] ?>">Cancelar</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
<?php $conexion->close(); ?>
