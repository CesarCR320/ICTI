<?php
class AttendanceController {
    public static function showList() {
        require_once __DIR__ . '/../../config/database.php';

        // Obtener evento activo
        $eventoQuery = "SELECT id, nombre FROM eventos WHERE activo = 1 LIMIT 1";
        $eventoResult = $conn->query($eventoQuery);

        if (!$eventoResult || $eventoResult->num_rows === 0) {
            die("❌ No hay evento activo. Activa uno primero.");
        }

        $evento = $eventoResult->fetch_assoc();
        $evento_id = $evento['id'];
        $evento_nombre = $evento['nombre'];

        // Obtener asistentes del evento activo
        $stmt = $conn->prepare("SELECT folio, nombre, apellido_paterno, apellido_materno, institucion, asistencia FROM asistentes_congreso WHERE evento_id = ?");
        $stmt->bind_param("i", $evento_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $asistentes = [];
        while ($row = $result->fetch_assoc()) {
            $asistentes[] = $row;
        }

        $stmt->close();
        $conn->close();

        // Pasar datos a la vista
        require __DIR__ . '/../../resources/views/asistentes.view.php';
    }
}