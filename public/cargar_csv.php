<?php
require_once __DIR__ . '/../app/controllers/CsvController.php';

$mensaje = '';
$resultado = null;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES['csv']) && $_FILES['csv']['error'] === UPLOAD_ERR_OK) {
    $archivoTmp = $_FILES['csv']['tmp_name'];
    $resultado = CsvController::procesarCSV($archivoTmp);
    if ($resultado['success']) {
        $mensaje = "✅ CSV cargado con éxito. Registros insertados: " . $resultado['insertados'] . ".";
    } else {
        $mensaje = "❌ Error: " . $resultado['error'];
    }
}

require_once __DIR__ . '/../resources/views/cargar_csv.view.php';