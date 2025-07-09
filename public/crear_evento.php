<?php
require_once __DIR__ . '/../app/controllers/EventController.php';

$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST['nombre'] ?? '');
    $fecha = trim($_POST['fecha'] ?? '');
    $lugar = trim($_POST['lugar'] ?? '');
    if ($nombre && $fecha && $lugar) {
        $result = EventController::crearEvento([
            'nombre' => $nombre,
            'fecha' => $fecha,
            'lugar' => $lugar
        ]);
        if ($result) {
            $mensaje = "✅ Evento creado correctamente.";
        } else {
            $mensaje = "❌ Error al crear evento. Intenta de nuevo.";
        }
    } else {
        $mensaje = "❌ Todos los campos son obligatorios.";
    }
}

require_once __DIR__ . '/../resources/views/crear_evento.view.php';