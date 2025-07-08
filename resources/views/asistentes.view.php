<?php
require_once __DIR__ . '/../../config/database.php';

class AttendanceController
{
    public function showList($evento_id, $evento_nombre)
    {
        global $conn;
        $asistentes = [];

        $stmt = $conn->prepare(
            "SELECT folio, nombre, apellido_paterno, apellido_materno, institucion, asistencia, fecha_asistencia
             FROM asistentes_congreso
             WHERE evento_id = ?"
        );
        $stmt->bind_param("i", $evento_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $asistentes[] = $row;
        }

        // Pasa $evento_nombre a la vista
        include __DIR__ . '/../../resources/views/asistentes.view.php';
    }

    public function registrarAsistencia($folio, $evento_id)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE asistentes_congreso SET asistencia = 1, fecha_asistencia = NOW() WHERE folio = ? AND evento_id = ?");
        $stmt->bind_param("si", $folio, $evento_id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function obtenerAsistentePorFolio($folio, $evento_id)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT folio, nombre, apellido_paterno, apellido_materno, institucion, asistencia, fecha_asistencia FROM asistentes_congreso WHERE folio = ? AND evento_id = ?");
        $stmt->bind_param("si", $folio, $evento_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function generarQR($folio)
    {
        // Ejemplo de generación de QR (ajusta según tu lógica real)
        $qrPath = __DIR__ . "/../../public/qrs/$folio.png";
        if (!file_exists($qrPath)) {
            // Usar una librería de QR real aquí en producción
            file_put_contents($qrPath, 'QR_PLACEHOLDER');
        }
        return $qrPath;
    }

    // Agrega aquí cualquier otro método que ya tengas en tu controller
}
?>