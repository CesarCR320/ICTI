<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>🎯 Seleccionar Evento Activo</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
  <style>
    body { font-family: 'Poppins', sans-serif; background: #f3f4f6; }
    .animate-fade-in { animation: fadein 0.5s; }
    @keyframes fadein { from { opacity: 0; } to { opacity: 1; } }
    .transition { transition: background 0.2s, color 0.2s; }
    select:focus, button:focus { outline: none; box-shadow: 0 0 0 2px #007acc; }
  </style>
</head>
<body class="flex justify-center items-center min-h-screen p-4">

<div class="bg-white p-10 rounded-3xl shadow-2xl w-full max-w-lg border-t-8 border-[#C1228E] animate-fade-in">
  <div class="flex items-center justify-center mb-6">
    <div class="bg-[#C1228E] text-white rounded-full w-14 h-14 flex items-center justify-center shadow-lg text-3xl mr-3">
      <i class="fa-solid fa-bolt"></i>
    </div>
    <div>
      <h2 class="text-2xl font-bold text-[#002b5c]">Seleccionar Evento Activo</h2>
      <p class="text-sm text-gray-500">Elige el evento que estará activo para el registro.</p>
    </div>
  </div>

  <?php if (isset($_GET['success'])): ?>
    <div class="mb-4 text-green-700 bg-green-100 border border-green-300 rounded p-2 text-center font-semibold shadow">
      ✅ Evento activado exitosamente.
    </div>
  <?php endif; ?>
  <?php if (isset($_GET['error'])): ?>
    <div class="mb-4 text-red-700 bg-red-100 border border-red-300 rounded p-2 text-center font-semibold shadow">
      ❌ Ocurrió un error. Intenta de nuevo.
    </div>
  <?php endif; ?>

  <form action="activar_evento.php" method="POST" id="formSeleccionarEvento" class="space-y-5">
    <div>
      <label for="evento_id" class="block text-[#002b5c] font-semibold mb-1">Elige un evento:</label>
      <select name="evento_id" id="evento_id" required class="block w-full p-2 border-2 border-[#007acc]/30 rounded-lg focus:border-[#007acc] transition">
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
    </div>
    <button type="submit" class="w-full bg-[#007acc] text-white font-semibold py-2 rounded-lg shadow hover:bg-[#002b5c] hover:scale-105 transition flex items-center justify-center gap-2">
      <i class="fa-solid fa-bolt"></i> Activar evento
    </button>
  </form>

  <a href="index.php" class="block mt-6 text-center text-sm text-[#002b5c] underline hover:text-[#C1228E] transition">
    <i class="fa-solid fa-arrow-left"></i> Volver al menú
  </a>
</div>

</body>
</html>