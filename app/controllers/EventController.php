<?php
require_once __DIR__ . '/../../config/database.php';

class EventController {
    // Muestra la vista para seleccionar evento
    public static function selectEventView() {
        $conn = getDatabaseConnection();

        $eventos = [];
        $query = "SELECT id, nombre, fecha FROM eventos ORDER BY fecha DESC";
        $result = $conn->query($query);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $eventos[] = $row;
            }
        }
        $conn->close();

        // Pasa los eventos a la vista
        require __DIR__ . '/../../resources/views/seleccionar_evento.view.php';
    }

    // Procesa el formulario para activar evento
    public static function activarEvento() {
        $conn = getDatabaseConnection();

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['evento_id'])) {
            $evento_id = intval($_POST['evento_id']);
            // Desactivar todos los eventos
            $conn->query("UPDATE eventos SET activo = 0");
            // Activar el seleccionado
            $stmt = $conn->prepare("UPDATE eventos SET activo = 1 WHERE id = ?");
            $stmt->bind_param("i", $evento_id);
            $stmt->execute();
            $stmt->close();
            $conn->close();

            // Redirigir con mensaje de éxito
            header("Location: seleccionar_evento.php?success=1");
            exit;
        } else {
            $conn->close();
            header("Location: seleccionar_evento.php?error=1");
            exit;
        }
    }

    // Método para crear un nuevo evento
    public static function crearEvento($datos) {
        $conn = getDatabaseConnection();
        $stmt = $conn->prepare("INSERT INTO eventos (nombre, fecha, lugar, activo) VALUES (?, ?, ?, 0)");
        $stmt->bind_param("sss", $datos['nombre'], $datos['fecha'], $datos['lugar']);
        $ok = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $ok;
    }
}