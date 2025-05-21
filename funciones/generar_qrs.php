<?php
include '../phpqrcode/qrlib.php'; // Usa la librería oficial

include '../config.php';

// Buscar evento activo
$eventoQuery = "SELECT id FROM eventos WHERE activo = 1 LIMIT 1";
$eventoResult = $conn->query($eventoQuery);

if (!$eventoResult || $eventoResult->num_rows === 0) {
    exit("❌ No hay evento activo. Activa uno primero.");
}

$evento = $eventoResult->fetch_assoc();
$evento_id = $evento['id'];

// Obtener asistentes
$stmt = $conn->prepare("SELECT folio FROM asistentes_congreso WHERE evento_id = ?");
$stmt->bind_param("i", $evento_id);
$stmt->execute();
$result = $stmt->get_result();

$generados = 0;

while ($row = $result->fetch_assoc()) {
    $folio = $row['folio'];
    $archivoQR = "../qrs/" . $folio . ".png";

    // Generar QR usando la librería
    QRcode::png($folio, $archivoQR, QR_ECLEVEL_L, 4, 4);
    $generados++;
}

$stmt->close();
$conn->close();

echo "✅ Se generaron <strong>$generados</strong> códigos QR correctamente.";
?>
