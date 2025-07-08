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

    <form action="funciones/activar_evento.php" method="POST" id="formSeleccionarEvento">
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

    <div id="msg" class="hidden mt-4 text-sm text-center"></div>

    <a href="index.php" class="block mt-4 text-center text-sm text-[#002b5c] underline hover:text-[#007acc] transition">← Volver al menú</a>
  </div>

  <script>
    // Mejora: Validación y UX mejorada en JS
    document.getElementById('formSeleccionarEvento').addEventListener('submit', function(e) {
      const select = document.getElementById('evento_id');
      const msg = document.getElementById('msg');
      if (!select.value) {
        e.preventDefault();
        msg.textContent = "Por favor, selecciona un evento válido.";
        msg.className = "block mt-4 text-sm text-center text-red-600";
        select.focus();
      } else {
        msg.className = "hidden";
      }
    });
  </script>
</body>
</html>