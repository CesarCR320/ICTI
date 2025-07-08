<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lista de Asistentes - <?php echo htmlspecialchars($evento_nombre); ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    body { font-family: 'Poppins', sans-serif; }
  </style>
</head>
<body class="bg-gray-100 p-6">

  <div class="max-w-7xl mx-auto">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-4">
      <div class="flex items-center gap-2">
        <a href="index.php" class="text-[#002b5c] text-2xl hover:text-blue-800 transition">←</a>
        <h1 class="text-2xl font-bold text-[#002b5c]">Lista de Asistentes - <?php echo htmlspecialchars($evento_nombre); ?></h1>
      </div>
      <button id="generarQRsBtn" class="bg-[#007acc] text-white px-4 py-2 rounded hover:bg-blue-700">
        📲 Generar/Actualizar QR
      </button>
    </div>

    <div id="mensajeQR" class="hidden mb-4 p-4 bg-green-100 border border-green-400 text-green-800 rounded">
      ✅ Códigos QR generados exitosamente.
    </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-xl">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-[#007acc] text-white">
          <tr>
            <th class="px-4 py-3 text-left">QR</th>
            <th class="px-4 py-3 text-left">Folio</th>
            <th class="px-4 py-3 text-left">Nombre</th>
            <th class="px-4 py-3 text-left">Institución</th>
            <th class="px-4 py-3 text-left">Asistencia</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <?php foreach ($asistentes as $asistente): ?>
            <tr class="hover:bg-gray-50">
              <td class="px-4 py-3">
                <img src="qrs/<?php echo htmlspecialchars($asistente['folio']); ?>.png"
                     alt="QR-<?php echo htmlspecialchars($asistente['folio']); ?>"
                     class="w-12 h-12 object-contain" />
              </td>
              <td class="px-4 py-3"><?php echo htmlspecialchars($asistente['folio']); ?></td>
              <td class="px-4 py-3">
                <?php
                  echo htmlspecialchars($asistente['nombre']) . " " .
                      htmlspecialchars($asistente['apellido_paterno']) . " " .
                      htmlspecialchars($asistente['apellido_materno']);
                ?>
              </td>
              <td class="px-4 py-3"><?php echo htmlspecialchars($asistente['institucion']); ?></td>
              <td class="px-4 py-3">
                <?php echo $asistente['asistencia'] ? '✅' : '❌'; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    // Aquí puedes añadir JS para generar QR, mostrar mensajes, etc.
    $("#generarQRsBtn").click(function () {
      // Tu código AJAX para generar QRs
      $("#mensajeQR").removeClass("hidden");
      setTimeout(() => $("#mensajeQR").addClass("hidden"), 3000);
    });
  </script>
</body>
</html>