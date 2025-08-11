<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../app/controllers/AttendanceController.php';

$input = json_decode(file_get_contents('php://input'), true);
$folio = isset($input['folio']) ? trim($input['folio']) : null;

// Obtener el evento activo
$conn = getDatabaseConnection();
$evento = $conn->query("SELECT id FROM eventos WHERE activo = 1 LIMIT 1")->fetch_assoc();
$conn->close();

if (!$evento || !$folio) {
    echo json_encode([]);
    exit;
}

$evento_id = $evento['id'];
$asistente = AttendanceController::obtenerAsistentePorFolio($folio, $evento_id);
echo json_encode($asistente ?: []);