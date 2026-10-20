<?php
require 'conexion.php';
$libros = $conexion->query("SELECT * FROM libros");
$sqlPrestamos = "SELECT p.*, l.titulo, u.nombres, u.apellidos FROM prestamos p 
                 INNER JOIN libros l ON p.id_libro = l.id_libro
                 INNER JOIN usuarios u ON p.id_usuario = u.id_usuario
                 WHERE p.devuelto = FALSE ORDER BY p.fecha_devolucion_estimada ASC";
$prestamos = $conexion->query($sqlPrestamos);
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Biblioteca</title></head>
<body>
    <h1>Sistema de Biblioteca Municipal</h1>
    <h2>Registrar préstamo</h2>
    <form action="guardar.php" method="POST">
        <label>Libro: <select name="id_libro" required>
            <?php while ($l = $libros->fetch_assoc()): ?>
            <option value="<?= $l['id_libro'] ?>"><?= $l['titulo'] ?> (Stock: <?= $l['stock'] ?>)</option>
            <?php endwhile; ?>
        </select></label><br>
        <label>DNI: <input type="text" name="dni" maxlength="8" required></label><br>
        <label>Días: <input type="number" name="dias" min="1" value="14" required></label><br>
        <button type="submit">Registrar préstamo</button>
    </form>
    <h2>Préstamos activos</h2>
    <table border="1" cellpadding="6">
        <tr><th>ID</th><th>Libro</th><th>Usuario</th><th>Fecha</th><th>Vence</th><th>Acciones</th></tr>
        <?php while ($p = $prestamos->fetch_assoc()): ?>
        <tr>
            <td><?= $p['id_prestamo'] ?></td>
            <td><?= $p['titulo'] ?></td>
            <td><?= $p['nombres'] . ' ' . $p['apellidos'] ?></td>
            <td><?= $p['fecha_prestamo'] ?></td>
            <td><?= $p['fecha_devolucion_estimada'] ?></td>
            <td><a href="devolver.php?id=<?= $p['id_prestamo'] ?>">Devuelto</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
<?php $conexion->close(); ?>
