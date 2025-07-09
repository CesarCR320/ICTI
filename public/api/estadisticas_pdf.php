<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Recibe datos POST
$generoImg = $_POST['generoImg'] ?? '';
$escolaridadImg = $_POST['escolaridadImg'] ?? '';
$diariaImg = $_POST['diariaImg'] ?? '';
$total = $_POST['total'] ?? '0';
$asistieron = $_POST['asistieron'] ?? '0';
$noasistieron = $_POST['noasistieron'] ?? '0';
$indigena = $_POST['indigena'] ?? '0';
$eventoNombre = $_POST['eventoNombre'] ?? 'Todos los eventos';

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// Puedes personalizar el logo si quieres
$logo_url = "https://icti.michoacan.gob.mx/wp-content/uploads/2021/03/LOGO-ICTI-2021.png";

$html = <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .titulo { color: #002b5c; font-weight: bold; font-size: 22px; margin-bottom: 0.5em; }
        .subtitulo { color: #C1228E; font-size: 16px; }
        .kpi-table td { padding: 0.4em 1em; text-align: center; }
        .kpi-table th { background: #f3f4f6; }
        .grafico { margin: 1.2em 0; text-align: center; }
        .kpi-num { font-size: 1.6em; font-weight: bold; }
    </style>
</head>
<body>
    <table width="100%" style="margin-bottom: 1em;">
        <tr>
            <td width="80%">
                <div class="titulo">Reporte de Estadísticas de Asistencia</div>
                <div class="subtitulo">Evento: {$eventoNombre}</div>
            </td>
            <td width="20%" align="right">
                <img src="{$logo_url}" alt="ICTI" style="height:60px;">
            </td>
        </tr>
    </table>
    <table class="kpi-table" border="1" cellspacing="0" cellpadding="4" width="100%">
        <tr>
            <th>Registrados</th>
            <th>Asistieron</th>
            <th>No asistieron</th>
            <th>Comunidad indígena</th>
        </tr>
        <tr>
            <td class="kpi-num">{$total}</td>
            <td class="kpi-num">{$asistieron}</td>
            <td class="kpi-num">{$noasistieron}</td>
            <td class="kpi-num">{$indigena}</td>
        </tr>
    </table>
    <div class="grafico">
        <b>Género</b><br>
        <img src="{$generoImg}" style="max-width: 100%; height: 220px;">
    </div>
    <div class="grafico">
        <b>Escolaridad</b><br>
        <img src="{$escolaridadImg}" style="max-width: 100%; height: 220px;">
    </div>
    <div class="grafico">
        <b>Asistencias por día</b><br>
        <img src="{$diariaImg}" style="max-width: 100%; height: 220px;">
    </div>
    <div style="font-size:10px; color:#888; margin-top:1em;">
        Generado automáticamente por el sistema ICTI - Fecha: {date('Y-m-d H:i')}
    </div>
</body>
</html>
HTML;

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$dompdf->stream('reporte_estadisticas.pdf', ['Attachment' => true]);
exit;