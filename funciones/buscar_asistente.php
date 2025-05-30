<?php
include '../config.php';

if (!isset($_POST['folio'])) {
    echo "<p class='text-red-500'>❌ Folio no recibido.</p>";
    exit;
}

$folio = trim($_POST['folio']);


$eventoQuery = "SELECT id FROM eventos WHERE activo = 1 LIMIT 1";
$eventoResult = $conn->query($eventoQuery);

if (!$eventoResult || $eventoResult->num_rows === 0) {
    echo "<p class='text-red-500'>❌ No hay evento activo.</p>";
    exit;
}

$evento_id = $eventoResult->fetch_assoc()['id'];


$stmt = $conn->prepare("SELECT nombre, apellido_paterno, apellido_materno, institucion, asistencia FROM asistentes_congreso WHERE folio = ? AND evento_id = ?");
$stmt->bind_param("si", $folio, $evento_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p class='text-red-500'>❌ Folio no encontrado.</p>";
    exit;
}

$asistente = $result->fetch_assoc();


if (!$asistente['asistencia']) {
    $update = $conn->prepare("UPDATE asistentes_congreso SET asistencia = 1 WHERE folio = ? AND evento_id = ?");
    $update->bind_param("si", $folio, $evento_id);
    $update->execute();
    $msg = "<p class='text-green-600 font-semibold'>✅ Asistencia registrada.</p>";
} else {
    $msg = "<p class='text-yellow-600 font-semibold'>⚠️ Asistencia ya estaba registrada.</p>";
}


echo $msg;
echo "<ul class='mt-2 space-y-1'>
  <li><strong>Folio:</strong> $folio</li>
  <li><strong>Nombre:</strong> {$asistente['nombre']} {$asistente['apellido_paterno']} {$asistente['apellido_materno']}</li>
  <li><strong>Institución:</strong> {$asistente['institucion']}</li>
</ul>";
?>
