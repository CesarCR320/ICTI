<?php
require_once __DIR__ . '/../../app/controllers/EstadisticasController.php';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=estadisticas_evento.csv');
echo "\xEF\xBB\xBF"; // UTF-8 BOM para Excel

$evento_id = isset($_GET['evento_id']) && $_GET['evento_id'] !== "" ? intval($_GET['evento_id']) : null;
$rows = EstadisticasController::getRawData($evento_id);

// Encabezado
echo "Folio,Nombre,Apellido Paterno,Apellido Materno,Género,Edad,Escolaridad,Institución,Email,Asistencia,Fecha Asistencia\n";
foreach ($rows as $row) {
    echo sprintf(
        "\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",%s,\"%s\",\"%s\",\"%s\",\"%s\",\"%s\"\n",
        $row['folio'],
        $row['nombre'],
        $row['apellido_paterno'],
        $row['apellido_materno'],
        $row['genero'],
        $row['edad'] !== null ? $row['edad'] : '',
        $row['escolaridad'],
        $row['institucion'],
        $row['email'],
        $row['asistencia'] ? 'Sí' : 'No',
        $row['fecha_asistencia']
    );
}