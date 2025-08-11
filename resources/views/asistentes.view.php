<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Asistentes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f3f4f6; }
        .animate-fade-in { animation: fadein 0.5s; }
        @keyframes fadein { from { opacity: 0; } to { opacity: 1; } }
        .tabla-asistentes th, .tabla-asistentes td { font-size: 0.97rem; }
        @media (max-width: 640px) {
            .tabla-asistentes th, .tabla-asistentes td { font-size: 0.85rem; padding-left: 0.4rem; padding-right: 0.4rem; }
        }
    </style>
</head>
<body class="p-4 sm:p-8">

<div class="max-w-7xl mx-auto animate-fade-in">
    <div class="bg-white rounded-3xl shadow-2xl border-t-8 border-[#C1228E] px-4 sm:px-8 py-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
            <!-- Botón regresar -->
            <div class="flex-1 flex justify-center sm:justify-start mb-2 sm:mb-0">
                <a href="index.php" class="inline-flex items-center gap-2 px-5 py-2 bg-[#C1228E] text-white font-semibold rounded-lg shadow hover:bg-[#007ACC] transition text-sm">
                    <i class="fa-solid fa-arrow-left"></i> Regresar
                </a>
            </div>
            <!-- Título y evento -->
            <div class="flex-1 flex flex-col items-center">
                <h1 class="text-2xl sm:text-3xl font-bold text-[#002b5c] flex items-center gap-2 mb-1">
                    <i class="fa-solid fa-users"></i> Lista de Asistentes
                </h1>
                <?php if (isset($evento_nombre)): ?>
                    <div class="text-base sm:text-lg font-semibold text-[#007acc]"><?= htmlspecialchars($evento_nombre) ?></div>
                <?php endif; ?>
            </div>
            <!-- Botón generar QRs -->
            <div class="flex-1 flex justify-center sm:justify-end mt-2 sm:mt-0">
                <a href="generar_qrs.php" class="inline-flex items-center gap-2 px-5 py-2 bg-[#C1228E] text-white font-semibold rounded-lg shadow hover:bg-[#007ACC] transition text-sm">
                    <i class="fa-solid fa-qrcode"></i> Generar QRs de todos
                </a>
            </div>
        </div>

        <?php if (isset($_GET['qr_generados'])): ?>
            <div class="mb-4 text-green-700 bg-green-100 border border-green-300 rounded-lg px-4 py-2 text-center font-semibold shadow">
                <i class="fa-solid fa-circle-check"></i> QRs generados correctamente.
            </div>
        <?php endif; ?>

        <?php if (isset($asistentes) && count($asistentes) > 0): ?>
            <div class="overflow-x-auto rounded-xl shadow-md border border-gray-200 mt-4 tabla-asistentes">
                <table class="min-w-full divide-y divide-gray-200 bg-white">
                    <thead class="bg-gradient-to-r from-[#C1228E] via-[#007ACC] to-[#002D5C]">
                        <tr>
                            <th class="px-6 py-3 text-center text-xs font-bold text-white uppercase tracking-wider">QR</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Folio</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Apellidos</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Institución</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-white uppercase tracking-wider">Asistencia</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Fecha</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($asistentes as $asistente): ?>
                            <tr class="hover:bg-[#f0f4ff] transition">
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <?php
                                        $qrPath = "qrs/" . htmlspecialchars($asistente['folio']) . ".png";
                                        if (file_exists(__DIR__ . "/../../public/" . $qrPath)) {
                                            $qrUrl = $qrPath;
                                        } else {
                                            $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=60x60&data=" . urlencode($asistente['folio']);
                                        }
                                    ?>
                                    <img src="<?= $qrUrl ?>" alt="QR <?= htmlspecialchars($asistente['folio']) ?>"
                                         class="w-12 h-12 mx-auto rounded shadow border border-gray-200 bg-white"/>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($asistente['folio']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($asistente['nombre']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?= htmlspecialchars($asistente['apellido_paterno'] . ' ' . $asistente['apellido_materno']) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($asistente['institucion']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <?php if ($asistente['asistencia']): ?>
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-green-100 text-green-800 font-semibold text-xs" title="Asistió">
                                            <i class="fa-solid fa-check-circle"></i> Asistió
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-red-100 text-red-800 font-semibold text-xs" title="No asistió">
                                            <i class="fa-solid fa-circle-xmark"></i> No Asistió
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($asistente['fecha_asistencia']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="mt-8 text-red-600 font-semibold text-center">
                <i class="fa-solid fa-triangle-exclamation"></i>
                No hay asistentes registrados para este evento.
            </div>
        <?php endif; ?>
    </div>
</body>
</html>