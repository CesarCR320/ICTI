<?php
require_once __DIR__ . '/../../config/database.php';

class AttendanceController {
    public function showList() {
        $conn = getDatabaseConnection();

        // Obtener evento activo (ajusta el nombre de la tabla/campo según tu estructura)
        $eventoActivo = null;
        $sqlEvento = "SELECT * FROM eventos WHERE activo = 1 LIMIT 1";
        $resultEvento = $conn->query($sqlEvento);
        if ($resultEvento && $resultEvento->num_rows > 0) {
            $eventoActivo = $resultEvento->fetch_assoc();
        }

        // Obtener asistentes del evento activo o todos si no hay evento activo
        $asistentes = [];
        if ($eventoActivo) {
            $idEvento = $eventoActivo['id']; // Ajusta si tu campo es diferente
            $sqlAsistentes = "SELECT * FROM asistentes WHERE evento_id = $idEvento";
        } else {
            $sqlAsistentes = "SELECT * FROM asistentes";
        }
        $resultAsistentes = $conn->query($sqlAsistentes);
        if ($resultAsistentes) {
            while ($row = $resultAsistentes->fetch_assoc()) {
                $asistentes[] = $row;
            }
        }

        // Cargar la vista
        require __DIR__ . '/../../resources/views/asistentes.view.php';
    }
}
?>