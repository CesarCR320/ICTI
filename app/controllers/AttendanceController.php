<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../vendor/phpqrcode/qrlib.php'; // AJUSTA si la ruta no es esta
class AttendanceController
{
    // Muestra la lista de asistentes para el evento activo
    public static function showList()
    {
        $conn = getDatabaseConnection();

        // Obtener el evento activo
        $evento = $conn->query("SELECT id, nombre FROM eventos WHERE activo = 1 LIMIT 1")->fetch_assoc();
        $asistentes = [];
        $evento_nombre = $evento ? $evento['nombre'] : null;
        $evento_id = $evento ? $evento['id'] : null;

        if ($evento_id) {
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
            $stmt->close();
        }

        $conn->close();

        // Pasa los datos a la vista
        require __DIR__ . '/../../resources/views/asistentes.view.php';
    }

    public static function registrarAsistencia($folio, $evento_id)
    {
        $conn = getDatabaseConnection();
        $stmt = $conn->prepare("UPDATE asistentes_congreso SET asistencia = 1, fecha_asistencia = NOW() WHERE folio = ? AND evento_id = ?");
        $stmt->bind_param("si", $folio, $evento_id);
        $stmt->execute();
        $success = $stmt->affected_rows > 0;
        $stmt->close();
        $conn->close();
        return $success;
    }

    public static function obtenerAsistentePorFolio($folio, $evento_id)
    {
        $conn = getDatabaseConnection();
        $stmt = $conn->prepare("SELECT folio, nombre, apellido_paterno, apellido_materno, institucion, asistencia, fecha_asistencia FROM asistentes_congreso WHERE folio = ? AND evento_id = ?");
        $stmt->bind_param("si", $folio, $evento_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $asistente = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
        return $asistente;
    }

public static function generarTodosQRs()
    {
        $conn = getDatabaseConnection();
        $evento = $conn->query("SELECT id FROM eventos WHERE activo = 1 LIMIT 1")->fetch_assoc();
        if (!$evento) {
            $conn->close();
            return "No hay evento activo";
        }
        $evento_id = $evento['id'];

        $result = $conn->query("SELECT folio FROM asistentes_congreso WHERE evento_id = $evento_id");
        $output_dir = __DIR__ . '/../../public/qrs/';
        if (!file_exists($output_dir)) {
            mkdir($output_dir, 0777, true);
        }

        while ($row = $result->fetch_assoc()) {
            $folio = $row['folio'];
            $filename = $output_dir . $folio . '.png';
            \QRcode::png($folio, $filename, QR_ECLEVEL_L, 6, 2);
        }
        $conn->close();
        return true;
    }
}
?>