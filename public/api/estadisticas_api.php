<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../app/controllers/EstadisticasController.php';

$evento_id = isset($_GET['evento_id']) ? intval($_GET['evento_id']) : null;

switch ($_GET['type'] ?? '') {
    case 'kpis':
        echo json_encode(EstadisticasController::getKPIs($evento_id));
        break;
    case 'genero':
        echo json_encode(EstadisticasController::getGeneroStats($evento_id));
        break;
    case 'escolaridad':
        echo json_encode(EstadisticasController::getEscolaridadStats($evento_id));
        break;
    case 'diaria':
        echo json_encode(EstadisticasController::getAsistenciasPorDia($evento_id));
        break;
    case 'evento_activo':
        echo json_encode(EstadisticasController::getEventoActivo());
        break;
    default:
        echo json_encode(['error' => 'Tipo de estadística no soportado']);
}