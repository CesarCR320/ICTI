<?php
include '../config.php';
include '../phpqrcode.php'; // o ../libs/phpqrcode.php si lo pusiste ahí

// Verificar si hay evento activo
$eventoQuery = "SELECT id FROM eventos WHERE activo = 1 LIMIT 1";
$eventoResult = $conn->query($eventoQuery);

if (!$eventoResult || $eventoResult->num_rows === 0) {
    exit("❌ No hay evento activo. Activa un evento primero.");
}

$evento = $eventoResult->fetch_assoc();
$evento_id = $evento['id'];

// Obtener todos los asistentes del evento activo
$query = "SELECT folio FROM asistentes_congreso WHERE evento_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $evento_id);
$stmt->execute();
$result = $stmt->get_result();

$generados = 0;

while ($row = $result->fetch_assoc()) {
    $folio = $row['folio'];
    $rutaQR = "../qrs/" . $folio . ".png";

    // Generar QR
    QRcode_output($folio, $rutaQR);
    $generados++;
}

$stmt->close();
$conn->close();

echo "✅ Se generaron <strong>$generados</strong> códigos QR correctamente.";
?>
