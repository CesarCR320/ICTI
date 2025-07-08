<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lista de Asistentes</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body { font-family: 'Poppins', sans-serif; background: #f3f4f6; }
    .asistencia-si { color: #18a418; font-weight: bold; }
    .asistencia-no { color: #b91c1c; font-weight: bold; }
  </style>
</head>
<body class="p-4">

<div class="bg-white p-6 rounded-2xl shadow-lg max-w-4xl mx-auto">
  <h2 class="text-2xl font-bold text-center mb-6 text-[#002b5c]">🧑‍🤝‍🧑 Lista de Asistentes</h2>

  <?php if (isset($mensaje) && $mensaje): ?>
    <div class="mb-4 text-center text-blue-700 bg-blue-100 border border-blue-300 rounded p-2">
      <?= $mensaje ?>
    </div>
  <?php endif; ?>

  <?php if (!isset($evento) || !$evento): ?>
    <div class="mb-4 text-red-700 bg-red-100 border border-red-300 rounded p-2 text-center">
      ❌ No hay evento activo, selecciona uno primero.
    </div>
    <a href="seleccionar_evento.php" class="block mt-4 text-center text-sm text-[#002b5c] underline hover:text-[#007acc] transition">Ir a seleccionar evento</a>
  <?php else: ?>
    <div class="mb-2 text-center text-[#007acc] font-semibold">
      Evento activo: <?= htmlspecialchars($evento['nombre']) ?>
    </div>
    <div class="overflow-x-auto mt-4">
      <table class="min-w-full bg-white text-sm text-center border border-gray-300">
        <thead>
          <tr>
            <th class="px-2 py-2 border-b">Folio</th>
            <th class="px-2 py-2 border-b">Nombre</th>
            <th class="px-2 py-2 border-b">Apellido Paterno</th>
            <th class="px-2 py-2 border-b">Apellido Materno</th>
            <th class="px-2 py-2 border-b">Asistencia</th>
            <th class="px-2 py-2 border-b">Fecha de Asistencia</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($asistentes as $asistente): ?>
          <tr>
            <td class="px-2 py-2 border-b"><?= htmlspecialchars($asistente['folio']) ?></td>
            <td class="px-2 py-2 border-b"><?= htmlspecialchars($asistente['nombre']) ?></td>
            <td class="px-2 py-2 border-b"><?= htmlspecialchars($asistente['apellido_paterno']) ?></td>
            <td class="px-2 py-2 border-b"><?= htmlspecialchars($asistente['apellido_materno']) ?></td>
            <td class="px-2 py-2 border-b">
                <?php if ($asistente['asistencia']): ?>
                  <span class="asistencia-si">Sí</span>
                <?php else: ?>
                  <span class="asistencia-no">No</span>
                <?php endif; ?>
            </td>
            <td class="px-2 py-2 border-b">
                <?= $asistente['asistencia'] && $asistente['fecha_asistencia'] ? date('d/m/Y H:i', strtotime($asistente['fecha_asistencia'])) : '-' ?>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (count($asistentes) === 0): ?>
          <tr>
            <td colspan="6" class="py-4 text-gray-500">No hay asistentes registrados para este evento.</td>
          </tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>

  <a href="index.php" class="block mt-6 text-center text-sm text-[#002b5c] underline hover:text-[#007acc] transition">← Volver al menú</a>
</div>
</body>
</html>