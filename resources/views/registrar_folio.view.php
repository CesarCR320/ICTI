<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>📝 Registro de asistencia por folio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f3f4f6; }
        .animate-fade-in { animation: fadein 0.5s; }
        @keyframes fadein { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body class="flex justify-center items-center min-h-screen p-4">

<div class="bg-white p-10 rounded-3xl shadow-2xl w-full max-w-lg border-t-8 border-[#C1228E] animate-fade-in">
    <div class="flex items-center justify-center mb-6">
        <div class="bg-[#007acc] text-white rounded-full w-14 h-14 flex items-center justify-center shadow-lg text-3xl mr-3">
            <i class="fa-solid fa-id-card"></i>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-[#002b5c]">Registro de Asistencia por Folio</h2>
            <p class="text-sm text-gray-500">Registra la asistencia ingresando el folio del participante.</p>
        </div>
    </div>

    <?php if (isset($mensaje) && $mensaje): ?>
        <div class="mb-4 text-center <?= strpos($mensaje, '✅') !== false ? 'text-green-700 bg-green-100 border-green-300' : 'text-red-700 bg-red-100 border-red-300' ?> border rounded p-2 font-semibold shadow">
            <?= $mensaje ?>
        </div>
    <?php endif; ?>

    <?php if (!isset($evento) || !$evento): ?>
        <div class="mb-4 text-red-700 bg-red-100 border border-red-300 rounded p-2 text-center font-semibold shadow">
            <i class="fa-solid fa-circle-exclamation"></i> No hay evento activo, selecciona uno primero.
        </div>
        <a href="seleccionar_evento.php" class="block mt-4 text-center text-sm text-[#002b5c] underline hover:text-[#007acc] transition">
            <i class="fa-solid fa-arrow-right-to-bracket"></i> Ir a seleccionar evento
        </a>
    <?php else: ?>
        <div class="mb-2 text-center text-[#007acc] font-semibold">
            <i class="fa-solid fa-bolt"></i> Evento activo: <?= htmlspecialchars($evento['nombre']) ?>
        </div>

        <form action="registrar_folio.php" method="POST" id="formFolio" class="space-y-5">
            <div>
                <label for="folio" class="block text-[#002b5c] font-semibold mb-1">Folio del asistente</label>
                <input type="text" name="folio" id="folio" required maxlength="30"
                       class="block w-full p-3 border-2 border-[#007acc]/30 rounded-lg focus:border-[#007acc] focus:outline-none transition"
                       placeholder="Ingresa el folio aquí" autofocus autocomplete="off">
            </div>
            <button type="submit" class="w-full bg-[#C1228E] text-white font-semibold py-2 rounded-lg shadow hover:bg-[#007acc] hover:scale-105 transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-check"></i> Registrar asistencia
            </button>
        </form>
    <?php endif; ?>

    <a href="index.php" class="block mt-6 text-center text-sm text-[#002b5c] underline hover:text-[#C1228E] transition">
        <i class="fa-solid fa-arrow-left"></i> Volver al menú
    </a>
</div>

<script>
    // Limpia el formulario tras éxito para facilitar escaneo masivo
    if (document.querySelector('.text-green-700')) {
        setTimeout(() => {
            const form = document.getElementById('formFolio');
            if(form) form.reset();
        }, 1500);
    }
</script>
</body>
</html>