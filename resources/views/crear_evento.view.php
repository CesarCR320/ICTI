<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear evento</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f3f4f6; }
    </style>
</head>
<body class="flex justify-center items-center min-h-screen p-4">

<div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
    <h2 class="text-xl font-bold text-center mb-6 text-[#002b5c]">🎉 Crear nuevo evento</h2>

    <?php if ($mensaje): ?>
        <div class="mb-4 text-center <?= strpos($mensaje, '✅') !== false ? 'text-green-700 bg-green-100 border-green-300' : 'text-red-700 bg-red-100 border-red-300' ?> border rounded p-2">
            <?= $mensaje ?>
        </div>
    <?php endif; ?>

    <form action="crear_evento.php" method="POST" class="space-y-4">
        <div>
            <label for="nombre" class="block font-semibold text-gray-700 mb-1">Nombre del evento:</label>
            <input type="text" name="nombre" id="nombre" required maxlength="100"
                   class="w-full p-3 border rounded-lg transition" autofocus
                   placeholder="Ej. Congreso de Ciencia 2025">
        </div>
        <div>
            <label for="fecha" class="block font-semibold text-gray-700 mb-1">Fecha:</label>
            <input type="date" name="fecha" id="fecha" required
                   class="w-full p-3 border rounded-lg transition">
        </div>
        <div>
            <label for="lugar" class="block font-semibold text-gray-700 mb-1">Lugar:</label>
            <input type="text" name="lugar" id="lugar" required maxlength="100"
                   class="w-full p-3 border rounded-lg transition"
                   placeholder="Ej. Centro de Convenciones">
        </div>
        <button type="submit" class="w-full bg-[#007acc] text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition">
            Crear evento
        </button>
    </form>

    <a href="index.php" class="block mt-4 text-center text-sm text-[#002b5c] underline hover:text-[#007acc] transition">← Volver al menú</a>
</div>
</body>
</html>