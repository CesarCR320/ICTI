<?php
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
if (!$input || !isset($input['folio'])) {
    echo json_encode(['success' => false, 'error' => 'Folio no enviado']);
    exit;
}

$folio = trim($input['folio']);

$conn = getDatabaseConnection();

// Buscar evento activo
$evento = $conn->query("SELECT id FROM eventos WHERE activo = 1 LIMIT 1")->fetch_assoc();
if (!$evento) {
    echo json_encode(['success' => false, 'error' => 'No hay evento activo']);
    $conn->close();
    exit;
}
$evento_id = intval($evento['id']);

// Buscar al asistente por folio y evento activo
$stmt = $conn->prepare("SELECT id, nombre, apellido_paterno, apellido_materno, asistencia FROM asistentes_congreso WHERE folio = ? AND evento_id = ? LIMIT 1");
$stmt->bind_param("si", $folio, $evento_id);
$stmt->execute();
$result = $stmt->get_result();

if ($asistente = $result->fetch_assoc()) {
    // Registrar asistencia solo si no está ya registrada
    if ($asistente['asistencia']) {
        $nombreCompleto = $asistente['nombre'] . ' ' . $asistente['apellido_paterno'] . ' ' . $asistente['apellido_materno'];
        echo json_encode([
            'success' => false,
            'error' => "El folio <b>$folio</b> (<b>$nombreCompleto</b>) ya estaba registrado como presente."
        ]);
    } else {
        $stmtUpdate = $conn->prepare("UPDATE asistentes_congreso SET asistencia = 1, fecha_asistencia = NOW() WHERE id = ?");
        $stmtUpdate->bind_param("i", $asistente['id']);
        $stmtUpdate->execute();
        $nombreCompleto = $asistente['nombre'] . ' ' . $asistente['apellido_paterno'] . ' ' . $asistente['apellido_materno'];
        echo json_encode([
            'success' => true,
            'folio' => $folio,
            'nombre' => $nombreCompleto
        ]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Folio no encontrado en el evento activo.']);
}

$stmt->close();
$conn->close();