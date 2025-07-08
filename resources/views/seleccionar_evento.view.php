<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Seleccionar Evento Activo</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body { font-family: 'Poppins', sans-serif; background: #f3f4f6; }
    .transition { transition: background 0.2s, color 0.2s; }
    select:focus, button:focus { outline: none; box-shadow: 0 0 0 2px #007acc; }
  </style>
</head>
<body class="flex justify-center items-center min-h-screen p-4">

<div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
  <h2 class="text-xl font-bold text-center mb-6 text-[#002b5c]">🎯 Seleccionar Evento Activo</h2>

  <?php if (isset($_GET['success'])): ?>
    <div class="mb-4 text-green-700 bg-green-100 border border-green-300 rounded p-2 text-center">
      ✅ Evento activado exitosamente.
    </div>
  <?php endif; ?>
  <?php if (isset($_GET['error'])): ?>
    <div class="mb-4 text-red-700 bg-red-100 border border-red-300 rounded p-2 text-center">
      ❌ Ocurrió un error. Intenta de nuevo.
    </div>
  <?php endif; ?>

  <form action="activar_evento.php" method="POST" id="formSeleccionarEvento">
    <label for="evento_id" class="block font-semibold text-gray-700 mb-2">Elige un evento:</label>
    <select name="evento_id" id="evento_id" required class="w-full p-3 border rounded-lg mb-4 transition">
      <option value="">-- Selecciona --</option>
      <?php foreach ($eventos as $evento): ?>
        <option value="<?= htmlspecialchars($evento['id']) ?>">
          <?= htmlspecialchars($evento['nombre']) ?>
          <?php if (!empty($evento['fecha'])): ?>
            (<?= date('d/m/Y', strtotime($evento['fecha'])) ?>)
          <?php endif; ?>
        </option>
      <?php endforeach; ?>
    </select>

    <button type="submit" class="w-full bg-[#007acc] text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition">
      Activar evento
    </button>
  </form>

  <a href="index.php" class="block mt-4 text-center text-sm text-[#002b5c] underline hover:text-[#007acc] transition">← Volver al menú</a>
</div>

</body>
</html>