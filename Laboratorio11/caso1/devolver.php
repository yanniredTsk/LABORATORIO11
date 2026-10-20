
<?php
require 'conexion.php';

$id_prestamo = (int)($_GET['id'] ?? 0);

$sql = "SELECT id_libro, devuelto
        FROM prestamos
        WHERE id_prestamo = ?";

$stmtPres = $conexion->prepare($sql);
$stmtPres->bind_param("i", $id_prestamo);
$stmtPres->execute();

$prestamo = $stmtPres->get_result()->fetch_assoc();

if (!$prestamo) {
    exit("Préstamo no encontrado");
}

if (!$prestamo['devuelto']) {
    $conexion->begin_transaction();

    try {
        $sql = "UPDATE prestamos
                SET devuelto = TRUE,
                    fecha_devolucion_real = CURDATE()
                WHERE id_prestamo = ?
                AND devuelto = FALSE";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id_prestamo);
        $stmt->execute();

        if ($stmt->affected_rows === 1) {
            $sqlStock = "UPDATE libros
                         SET stock = stock + 1
                         WHERE id_libro = ?";

            $stmtStock = $conexion->prepare($sqlStock);
            $stmtStock->bind_param("i", $prestamo['id_libro']);
            $stmtStock->execute();
            $stmtStock->close();
        }

        $stmt->close();
        $conexion->commit();

    } catch (Throwable $e) {
        $conexion->rollback();
        throw $e;
    }
}

$stmtPres->close();
$conexion->close();

header("Location: index.php");
exit;
?>
