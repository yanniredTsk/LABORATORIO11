<?php
require 'conexion.php';

$medicamentos = $conexion->query("SELECT m.*, c.nombre as categoria FROM medicamentos m 
                                   INNER JOIN categorias c ON m.id_categoria = c.id_categoria");

$sqlVentas = "SELECT v.id_venta, m.nombre, v.cantidad, v.total, v.fecha_venta FROM ventas v
              INNER JOIN medicamentos m ON v.id_medicamento = m.id_medicamento ORDER BY v.fecha_venta DESC LIMIT 20";
$ventas = $conexion->query($sqlVentas);
?>

<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Farmacia - Ventas</title></head>
<body>
    <h1>Sistema de Ventas - Farmacia</h1>
    <h2>Registrar venta</h2>
    <form action="guardar.php" method="POST">
        <label>Medicamento: <select name="id_medicamento" required>
            <?php while ($m = $medicamentos->fetch_assoc()): ?>
            <option value="<?= $m['id_medicamento'] ?>"><?= $m['nombre'] ?> - S/ <?= $m['precio_base'] ?></option>
            <?php endwhile; ?>
        </select></label><br>
        <label>Cantidad: <input type="number" name="cantidad" min="1" required></label><br>
        <button type="submit">Registrar venta</button>
    </form>
    <h2>Historial de ventas</h2>
    <table border="1" cellpadding="6">
        <tr><th>Boleta</th><th>Medicamento</th><th>Cantidad</th><th>Total (S/)</th><th>Fecha</th><th>Acciones</th></tr>
        <?php while ($v = $ventas->fetch_assoc()): ?>
        <tr>
            <td><?= str_pad($v['id_venta'], 6, '0', STR_PAD_LEFT) ?></td>
            <td><?= $v['nombre'] ?></td>
            <td><?= $v['cantidad'] ?></td>
            <td>S/ <?= number_format($v['total'], 2) ?></td>
            <td><?= $v['fecha_venta'] ?></td>
            <td><a href="eliminar.php?id=<?= $v['id_venta'] ?>">Anular</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
<?php $conexion->close(); ?>
