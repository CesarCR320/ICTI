<?php
require_once __DIR__ . '/../../config/database.php';

class EstadisticasController {

    public static function getEventos() {
        $conn = getDatabaseConnection();
        $result = $conn->query("SELECT id, nombre FROM eventos ORDER BY fecha DESC");
        $eventos = [];
        while ($row = $result->fetch_assoc()) {
            $eventos[] = $row;
        }
        $conn->close();
        return $eventos;
    }

    public static function getEventoActivo() {
        $conn = getDatabaseConnection();
        $result = $conn->query("SELECT id, nombre FROM eventos WHERE activo = 1 LIMIT 1");
        $evento = $result->fetch_assoc();
        $conn->close();
        return $evento ?: null;
    }

    public static function getKPIs($evento_id) {
        $conn = getDatabaseConnection();
        $where = $evento_id ? "WHERE evento_id = $evento_id" : "";

        $sql = "
            SELECT 
                COUNT(*) AS total,
                SUM(asistencia=1) AS asistieron,
                SUM(asistencia=0) AS no_asistieron,
                SUM(comunidad_indigena=1) AS comunidad_indigena
            FROM asistentes_congreso
            $where
        ";
        $res = $conn->query($sql);
        $kpi = $res->fetch_assoc();
        $conn->close();
        return [
            'total' => intval($kpi['total']),
            'asistieron' => intval($kpi['asistieron']),
            'no_asistieron' => intval($kpi['no_asistieron']),
            'comunidad_indigena' => intval($kpi['comunidad_indigena'])
        ];
    }

    public static function getGeneroStats($evento_id) {
        $conn = getDatabaseConnection();
        $where = $evento_id ? "WHERE evento_id = $evento_id" : "";
        $sql = "
            SELECT genero, COUNT(*) as total
            FROM asistentes_congreso
            $where
            GROUP BY genero
        ";
        $res = $conn->query($sql);
        $data = [];
        while ($row = $res->fetch_assoc()) {
            $data[$row['genero'] ?: 'Sin especificar'] = intval($row['total']);
        }
        $conn->close();
        return $data;
    }

    public static function getEscolaridadStats($evento_id) {
        $conn = getDatabaseConnection();
        $where = $evento_id ? "WHERE evento_id = $evento_id" : "";
        $sql = "
            SELECT escolaridad, COUNT(*) as total
            FROM asistentes_congreso
            $where
            GROUP BY escolaridad
        ";
        $res = $conn->query($sql);
        $data = [];
        while ($row = $res->fetch_assoc()) {
            $data[$row['escolaridad'] ?: 'Sin especificar'] = intval($row['total']);
        }
        $conn->close();
        return $data;
    }

    public static function getAsistenciasPorDia($evento_id) {
        $conn = getDatabaseConnection();
        $where = $evento_id ? "WHERE evento_id = $evento_id AND asistencia=1" : "WHERE asistencia=1";
        $sql = "
            SELECT DATE(fecha_asistencia) as fecha, COUNT(*) as total
            FROM asistentes_congreso
            $where
            GROUP BY DATE(fecha_asistencia)
            ORDER BY fecha
        ";
        $res = $conn->query($sql);
        $data = [];
        while ($row = $res->fetch_assoc()) {
            $data[$row['fecha']] = intval($row['total']);
        }
        $conn->close();
        return $data;
    }

    public static function getRawData($evento_id) {
        $conn = getDatabaseConnection();
        $where = $evento_id ? "WHERE evento_id = $evento_id" : "";
            $sql = "SELECT folio, nombre, apellido_paterno, apellido_materno, genero, edad, escolaridad, institucion, email, asistencia, fecha_asistencia 
            FROM asistentes_congreso $where";
    $res = $conn->query($sql);
    $rows = [];
    while($row = $res->fetch_assoc()) $rows[] = $row;
    $conn->close();
    return $rows;
}
}