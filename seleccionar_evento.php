<?php
include 'config.php';

$eventos = [];
$query = "SELECT id, nombre FROM eventos ORDER BY fecha DESC";
$result = $conn->query($query);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $eventos[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Seleccionar Evento Activo</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen p-4">
  <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
    <h2 class="text-xl font-bold text-center mb-6 text-[#002b5c]">🎯 Seleccionar Evento Activo</h2>

    <form action="funciones/activar_evento.php" method="POST">
      <label for="evento_id" class="block font-semibold text-gray-700 mb-2">Elige un evento:</label>
      <select name="evento_id" id="evento_id" required class="w-full p-3 border rounded-lg mb-6">
        <option value="">-- Selecciona --</option>
        <?php foreach ($eventos as $evento): ?>
          <option value="<?= $evento['id'] ?>"><?= $evento['nombre'] ?></option>
        <?php endforeach; ?>
      </select>

      <button type="submit" class="w-full bg-[#007acc] text-white font-semibold py-2 rounded-lg hover:bg-blue-700">
        Activar evento
      </button>
    </form>

    <a href="index.php" class="block mt-4 text-center text-sm text-[#002b5c] underline">← Volver al menú</a>
  </div>
</body>
</html>
