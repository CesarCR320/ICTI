<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Asistentes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f3f4f6; }
    </style>
</head>
<body class="p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Encabezado con botón de regreso, título centrado y botón de generar QR -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
            <!-- Botón Regresar a la izquierda -->
            <div class="flex-1 flex justify-center sm:justify-start mb-2 sm:mb-0">
                <a href="index.php" class="inline-block px-6 py-2 bg-[#C1228E] text-white font-semibold rounded-lg shadow hover:bg-pink-700 transition text-sm">
                    <i class="fas fa-arrow-left mr-2"></i> Regresar
                </a>
            </div>
            <!-- Título centrado -->
            <div class="flex-1 flex flex-col items-center">
                <h1 class="text-3xl font-bold text-[#002b5c]">Lista de Asistentes</h1>
                <?php if (isset($evento_nombre)): ?>
                    <div class="text-lg mt-2 font-semibold text-[#007acc]"><?= htmlspecialchars($evento_nombre) ?></div>
                <?php endif; ?>
            </div>
            <!-- Botón Generar QRs a la derecha -->
            <div class="flex-1 flex justify-center sm:justify-end mt-2 sm:mt-0">
                <a href="generar_qrs.php" class="inline-block px-6 py-2 bg-[#C1228E] text-white font-semibold rounded-lg shadow hover:bg-pink-700 transition text-sm">
                    <i class="fas fa-qrcode mr-2"></i> Generar QRs de todos los asistentes
                </a>
            </div>
        </div>

        <?php if (isset($_GET['qr_generados'])): ?>
            <div class="mb-4 text-green-700 bg-green-100 border border-green-300 rounded-lg px-4 py-2 text-center font-semibold">
                QRs generados correctamente.
            </div>
        <?php endif; ?>

        <?php if (isset($asistentes) && count($asistentes) > 0): ?>
            <div class="overflow-x-auto rounded-xl shadow-lg border border-gray-200">
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
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-green-100 text-green-800 font-semibold text-xs">
                                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                            Asistió
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-red-100 text-red-800 font-semibold text-xs">
                                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                            No Asistió
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
            <div class="mt-8 text-red-600 font-semibold text-center">No hay asistentes registrados para este evento.</div>
        <?php endif; ?>
    </div>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>