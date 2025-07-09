<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de asistencia por folio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f3f4f6; }
    </style>
</head>
<body class="flex justify-center items-center min-h-screen p-4">

<div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
    <h2 class="text-xl font-bold text-center mb-6 text-[#002b5c]">📝 Registro de Asistencia por Folio</h2>

    <?php if (isset($mensaje) && $mensaje): ?>
        <div class="mb-4 text-center <?= strpos($mensaje, '✅') !== false ? 'text-green-700 bg-green-100 border-green-300' : 'text-red-700 bg-red-100 border-red-300' ?> border rounded p-2">
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

        <form action="registrar_folio.php" method="POST" id="formFolio">
            <label for="folio" class="block font-semibold text-gray-700 mb-2">Folio del asistente:</label>
            <input type="text" name="folio" id="folio" required maxlength="30"
                   class="w-full p-3 border rounded-lg mb-4 transition" autofocus
                   placeholder="Ingresa el folio aquí">
            <button type="submit" class="w-full bg-[#007acc] text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition">
                Registrar asistencia
            </button>
        </form>
    <?php endif; ?>

    <a href="index.php" class="block mt-4 text-center text-sm text-[#002b5c] underline hover:text-[#007acc] transition">← Volver al menú</a>
</div>

<script>
    // Limpia el formulario tras éxito para facilitar escaneo masivo
    if (document.querySelector('.text-green-700')) {
        setTimeout(() => {
            document.getElementById('formFolio').reset();
        }, 1500);
    }
</script>
</body>
</html>