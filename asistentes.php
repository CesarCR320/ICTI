<?php
include 'config.php';

// Obtener evento activo
$eventoQuery = "SELECT id, nombre FROM eventos WHERE activo = 1 LIMIT 1";
$eventoResult = $conn->query($eventoQuery);

if (!$eventoResult || $eventoResult->num_rows === 0) {
    die("❌ No hay evento activo. Activa uno primero.");
}

$evento = $eventoResult->fetch_assoc();
$evento_id = $evento['id'];
$evento_nombre = $evento['nombre'];

// Obtener asistentes del evento activo
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
  <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class="bg-gray-100 p-4">

  <div class="max-w-7xl mx-auto">
    <h1 class="text-2xl font-bold text-[#002b5c] mb-4">📄 Lista de Asistentes - <?php echo htmlspecialchars($evento_nombre); ?></h1>

    <div class="overflow-x-auto">
      <table class="min-w-full bg-white shadow-md rounded-xl overflow-hidden">
        <thead class="bg-[#007acc] text-white">
          <tr>
            <th class="p-3 text-left">QR</th>
            <th class="p-3 text-left">Folio</th>
            <th class="p-3 text-left">Nombre</th>
            <th class="p-3 text-left">Institución</th>
            <th class="p-3 text-left">Asistencia</th>
          </tr>
        </thead>
        <tbody class="text-gray-700">
          <?php foreach ($asistentes as $asistente): ?>
            <tr class="border-b hover:bg-gray-50">
              <td class="p-3">
                <img src="qrs/<?php echo htmlspecialchars($asistente['folio']); ?>.png" alt="QR" width="60" onerror="this.src='https://via.placeholder.com/60x60?text=No+QR';">
              </td>
              <td class="p-3 font-mono"><?php echo htmlspecialchars($asistente['folio']); ?></td>
              <td class="p-3"><?php echo htmlspecialchars($asistente['nombre'] . ' ' . $asistente['apellido_paterno'] . ' ' . $asistente['apellido_materno']); ?></td>
              <td class="p-3"><?php echo htmlspecialchars($asistente['institucion']); ?></td>
              <td class="p-3">
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

    <div class="mt-6 flex justify-between">
      <a href="index.php" class="text-[#002b5c] underline">← Volver al menú</a>
      <a href="funciones/generar_qrs.php" class="bg-[#007acc] text-white px-4 py-2 rounded hover:bg-blue-700">
        📲 Generar/Actualizar QR
      </a>
    </div>
  </div>

</body>
</html>
