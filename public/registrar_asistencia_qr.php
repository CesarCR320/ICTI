<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../app/controllers/AttendanceController.php';

// Leer el folio desde el JSON recibido
$input = json_decode(file_get_contents('php://input'), true);
$folio = isset($input['folio']) ? trim($input['folio']) : null;

if (!$folio) {
    echo json_encode([
        'success' => false,
        'message' => 'Folio no recibido'
    ]);
    exit;
}

// Obtener el evento activo
$conn = getDatabaseConnection();
$evento = $conn->query("SELECT id FROM eventos WHERE activo = 1 LIMIT 1")->fetch_assoc();
$conn->close();

if (!$evento) {
    echo json_encode([
        'success' => false,
        'message' => 'No hay evento activo'
    ]);
    exit;
}

$evento_id = $evento['id'];
$result = AttendanceController::registrarAsistencia($folio, $evento_id);

if ($result) {
    echo json_encode([
        'success' => true,
        'folio' => $folio
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Folio no encontrado o ya registrado'
    ]);
}