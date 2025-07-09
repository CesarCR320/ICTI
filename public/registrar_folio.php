<?php
require_once __DIR__ . '/../app/controllers/AttendanceController.php';

$mensaje = '';
$evento = null;

// Obtener evento activo
$conn = getDatabaseConnection();
$evento = $conn->query("SELECT id, nombre FROM eventos WHERE activo = 1 LIMIT 1")->fetch_assoc();
$conn->close();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['folio'])) {
    $folio = trim($_POST['folio']);
    if ($evento && $folio) {
        $result = AttendanceController::registrarAsistencia($folio, $evento['id']);
        if ($result) {
            $mensaje = "✅ Asistencia registrada correctamente para el folio: <b>$folio</b>";
        } else {
            $mensaje = "❌ No se pudo registrar la asistencia. Folio no encontrado, ya registrado o error en el sistema.";
        }
    } else {
        $mensaje = "❌ Debes ingresar un folio válido y tener un evento activo.";
    }
}

require_once __DIR__ . '/../resources/views/registrar_folio.view.php';