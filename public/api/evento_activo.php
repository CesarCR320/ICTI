<?php
require_once __DIR__ . '/../../config/database.php';

$conn = getDatabaseConnection();
$evento = $conn->query("SELECT nombre, fecha FROM eventos WHERE activo = 1 LIMIT 1")->fetch_assoc();
$conn->close();

if ($evento) {
    // Puedes ajustar formato de fecha aquí si quieres
    $evento['fecha'] = date('d/m/Y', strtotime($evento['fecha']));
    header('Content-Type: application/json');
    echo json_encode($evento);
} else {
    echo json_encode(['nombre' => 'Sin evento activo', 'fecha' => '']);
}