<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>🎉 Crear nuevo evento</title>
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
            <i class="fa-solid fa-calendar-plus"></i>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-[#002b5c]">Crear nuevo evento</h2>
            <p class="text-sm text-gray-500">Llena los datos para agregar un nuevo evento al sistema.</p>
        </div>
    </div>
    <?php if (isset($mensaje) && $mensaje): ?>
        <div class="mb-4 text-center <?= strpos($mensaje, '✅') !== false ? 'text-green-700 bg-green-100 border-green-300' : 'text-red-700 bg-red-100 border-red-300' ?> border rounded p-2 font-semibold shadow">
            <?= $mensaje ?>
        </div>
    <?php endif; ?>
    <form action="crear_evento.php" method="POST" class="space-y-5">
        <div>
            <label for="nombre" class="block text-[#002b5c] font-semibold mb-1">Nombre del evento</label>
            <input type="text" name="nombre" id="nombre" maxlength="120" required
                   class="block w-full p-2 border-2 border-[#007acc]/30 rounded-lg focus:border-[#007acc] focus:outline-none transition"
                   placeholder="Ejemplo: Congreso Estatal de Ciencia 2025">
        </div>
        <div>
            <label for="fecha" class="block text-[#002b5c] font-semibold mb-1">Fecha</label>
            <input type="date" name="fecha" id="fecha" required
                   class="block w-full p-2 border-2 border-[#007acc]/30 rounded-lg focus:border-[#007acc] focus:outline-none transition">
        </div>
        <div>
            <label for="lugar" class="block text-[#002b5c] font-semibold mb-1">Lugar</label>
            <input type="text" name="lugar" id="lugar" maxlength="120" required
                   class="block w-full p-2 border-2 border-[#007acc]/30 rounded-lg focus:border-[#007acc] focus:outline-none transition"
                   placeholder="Ejemplo: Centro de Convenciones Morelia">
        </div>
        <button type="submit" class="w-full bg-[#C1228E] text-white font-semibold py-2 rounded-lg shadow hover:bg-[#007acc] hover:scale-105 transition flex items-center justify-center gap-2">
            <i class="fa-solid fa-plus"></i> Crear evento
        </button>
    </form>
    <a href="index.php" class="block mt-6 text-center text-sm text-[#002b5c] underline hover:text-[#C1228E] transition">
        <i class="fa-solid fa-arrow-left"></i> Volver al menú
    </a>
</div>
</body>
</html>