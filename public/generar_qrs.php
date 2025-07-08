<?php
require_once __DIR__ . '/../app/controllers/AttendanceController.php';

$result = AttendanceController::generarTodosQRs();

if ($result === true) {
    // Redirecciona a la lista o muestra mensaje de éxito
    header("Location: asistentes.php?qr_generados=1");
    exit;
} else {
    echo "<h2>Error: $result</h2>";
    echo '<a href="asistentes.php">Volver a la lista de asistentes</a>';
}
?>