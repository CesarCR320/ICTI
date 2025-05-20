<?php
include '../config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'] ?? '';
    $fecha = $_POST['fecha'] ?? '';
    $lugar = $_POST['lugar'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';

    if (empty($nombre) || empty($fecha)) {
        echo "❌ Nombre y fecha son obligatorios.";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO eventos (nombre, fecha, lugar, descripcion) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $fecha, $lugar, $descripcion);

    if ($stmt->execute()) {
        echo "✅ Evento guardado correctamente.";
    } else {
        echo "❌ Error al guardar evento: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
