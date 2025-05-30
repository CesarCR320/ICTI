<?php
include 'config.php';

$eventoQuery = "SELECT id, nombre FROM eventos WHERE activo = 1 LIMIT 1";
$eventoResult = $conn->query($eventoQuery);

if (!$eventoResult || $eventoResult->num_rows === 0) {
    die("❌ No hay evento activo. Activa uno primero.");
}

$evento = $eventoResult->fetch_assoc();
$evento_id = $evento['id'];
$evento_nombre = $evento['nombre'];

$stmt = $conn->prepare("SELECT folio, nombre, apellido_paterno, apellido_materno, institucion, asistencia FROM asistentes_congreso WHERE evento_id = ?");
$stmt->bind_param("i", $evento_id);
$stmt->execute();
$result = $stmt->get_result();

$asistentes = [];
while ($row = $result->fetch_assoc()) {
    $asistentes[] = $row;
}

$stmt->close();
$conn->close();
?>
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
                     alt="QR"
                     width="60"
                     onerror="this.src='https://via.placeholder.com/60x60?text=No+QR';">
              </td>
              <td class="px-4 py-3 font-mono"><?php echo htmlspecialchars($asistente['folio']); ?></td>
              <td class="px-4 py-3">
                <?php echo htmlspecialchars($asistente['nombre'] . ' ' . $asistente['apellido_paterno'] . ' ' . $asistente['apellido_materno']); ?>
              </td>
              <td class="px-4 py-3"><?php echo htmlspecialchars($asistente['institucion']); ?></td>
              <td class="px-4 py-3">
                <?php if ($asistente['asistencia']): ?>
                  <span class="text-green-600 font-semibold">✔ Asistió</span>
                <?php else: ?>
                  <span class="text-red-500 font-semibold">✘ No asistió</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    $('#generarQRsBtn').click(function () {
      $.get('funciones/generar_qrs.php', function (data) {
        $('#mensajeQR').removeClass('hidden').removeClass('bg-red-100 border-red-400 text-red-800')
          .addClass('bg-green-100 border-green-400 text-green-800').html('✅ ' + data).show();
        setTimeout(() => $('#mensajeQR').fadeOut(), 5000);
      }).fail(function () {
        $('#mensajeQR').removeClass('hidden').removeClass('bg-green-100 border-green-400 text-green-800')
          .addClass('bg-red-100 border-red-400 text-red-800').html('❌ Error al generar los QR.').show();
      });
    });
  </script>

</body>
</html>
