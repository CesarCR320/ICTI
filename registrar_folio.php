<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['folio'])) {
    $folio = trim($_POST['folio']);

    $eventoQuery = "SELECT id FROM eventos WHERE activo = 1 LIMIT 1";
    $eventoResult = $conn->query($eventoQuery);

    if ($eventoResult && $eventoResult->num_rows > 0) {
        $evento = $eventoResult->fetch_assoc();
        $evento_id = $evento['id'];

        $stmt = $conn->prepare("SELECT id, nombre, apellido_paterno, asistencia FROM asistentes_congreso WHERE folio = ? AND evento_id = ?");
        $stmt->bind_param("si", $folio, $evento_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $asistente = $result->fetch_assoc();

            if ($asistente['asistencia']) {
                echo "⚠️ El asistente <strong>{$asistente['nombre']} {$asistente['apellido_paterno']}</strong> ya está registrado como presente.";
            } else {
                $update = $conn->prepare("UPDATE asistentes_congreso SET asistencia = 1, fecha_asistencia = NOW() WHERE id = ?");
                $update->bind_param("i", $asistente['id']);
                $update->execute();

                echo "✅ Asistencia registrada para <strong>{$asistente['nombre']} {$asistente['apellido_paterno']}</strong>.";
            }

        } else {
            echo "❌ Folio no encontrado para el evento activo.";
        }

        $stmt->close();
    } else {
        echo "❌ No hay evento activo seleccionado.";
    }

    $conn->close();
} else {
    echo "❌ Solicitud inválida.";
}
?>
