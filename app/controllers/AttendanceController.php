<?php
class AttendanceController {

    // Muestra el listado de asistentes (ajusta este método según tus necesidades)
    public static function showList($mensaje = '') {
        require_once __DIR__ . '/../../config/database.php';

        // Obtener evento activo
        $eventoQuery = "SELECT id, nombre FROM eventos WHERE activo = 1 LIMIT 1";
        $eventoResult = $conn->query($eventoQuery);

        $evento = null;
        if ($eventoResult && $eventoResult->num_rows > 0) {
            $evento = $eventoResult->fetch_assoc();
        }

        $asistentes = [];
        if ($evento) {
            // Ajusta los campos según tus columnas reales
            $stmt = $conn->prepare(
                "SELECT folio, nombre, apellido_paterno, apellido_materno, asistencia, fecha_asistencia 
                 FROM asistentes_congreso 
                 WHERE evento_id = ?"
            );
            $stmt->bind_param("i", $evento['id']);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $asistentes[] = $row;
            }
            $stmt->close();
        }

        $conn->close();

        // Incluye la vista de listado (ajústala según tu estructura)
        require __DIR__ . '/../../resources/views/lista_asistentes.view.php';
    }

    // Muestra el formulario de registro por folio
    public static function showFolioForm($mensaje = '') {
        require_once __DIR__ . '/../../config/database.php';

        // Obtener evento activo
        $eventoQuery = "SELECT id, nombre FROM eventos WHERE activo = 1 LIMIT 1";
        $eventoResult = $conn->query($eventoQuery);

        $evento = null;
        if ($eventoResult && $eventoResult->num_rows > 0) {
            $evento = $eventoResult->fetch_assoc();
        }
        $conn->close();

        require __DIR__ . '/../../resources/views/registrar_folio.view.php';
    }

    // Procesa el registro de asistencia por folio
    public static function registrarFolio() {
        require_once __DIR__ . '/../../config/database.php';
        $mensaje = '';

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['folio'])) {
            $folio = trim($_POST['folio']);

            // Buscar evento activo
            $eventoQuery = "SELECT id FROM eventos WHERE activo = 1 LIMIT 1";
            $eventoResult = $conn->query($eventoQuery);

            if ($eventoResult && $eventoResult->num_rows > 0) {
                $evento = $eventoResult->fetch_assoc();
                $evento_id = $evento['id'];

                // Buscar folio
                $stmt = $conn->prepare("SELECT id, nombre, apellido_paterno, apellido_materno, asistencia FROM asistentes_congreso WHERE folio = ? AND evento_id = ?");
                $stmt->bind_param("si", $folio, $evento_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $asistente = $result->fetch_assoc();

                    if ($asistente['asistencia']) {
                        $mensaje = "⚠️ El asistente <strong>{$asistente['nombre']} {$asistente['apellido_paterno']} {$asistente['apellido_materno']}</strong> ya está registrado como presente.";
                    } else {
                        $update = $conn->prepare("UPDATE asistentes_congreso SET asistencia = 1, fecha_asistencia = NOW() WHERE id = ?");
                        $update->bind_param("i", $asistente['id']);
                        $update->execute();
                        $update->close();
                        $mensaje = "✅ Asistencia registrada para <strong>{$asistente['nombre']} {$asistente['apellido_paterno']} {$asistente['apellido_materno']}</strong>.";
                    }
                } else {
                    $mensaje = "❌ Folio no encontrado para el evento activo.";
                }
                $stmt->close();
            } else {
                $mensaje = "❌ No hay evento activo seleccionado.";
            }
            $conn->close();
        } else {
            $mensaje = "❌ Solicitud inválida.";
        }

        // Mostrar formulario con mensaje
        self::showFolioForm($mensaje);
    }
}