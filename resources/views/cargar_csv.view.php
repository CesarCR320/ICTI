<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>📁 Cargar asistentes por CSV</title>
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
        <div class="bg-[#002b5c] text-white rounded-full w-14 h-14 flex items-center justify-center shadow-lg text-3xl mr-3">
            <i class="fa-solid fa-file-csv"></i>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-[#002b5c]">Cargar asistentes desde CSV</h2>
            <p class="text-sm text-gray-500">Carga tu base de asistentes de manera rápida y segura.</p>
        </div>
    </div>

    <?php if (isset($mensaje) && $mensaje): ?>
        <div class="mb-4 text-center <?= strpos($mensaje, '✅') !== false ? 'text-green-700 bg-green-100 border-green-300' : 'text-red-700 bg-red-100 border-red-300' ?> border rounded p-2 font-semibold shadow">
            <?= $mensaje ?>
        </div>
        <?php if ($resultado && isset($resultado['errores']) && count($resultado['errores']) > 0): ?>
            <div class="mb-4 text-sm text-red-700 bg-red-50 border border-red-200 rounded p-2 shadow">
                <b>Errores encontrados:</b>
                <ul class="ml-4 list-disc text-left">
                    <?php foreach ($resultado['errores'] as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <form action="cargar_csv.php" method="POST" enctype="multipart/form-data" class="space-y-5">
        <div>
            <label for="csv" class="block text-[#002b5c] font-semibold mb-1">Selecciona archivo CSV</label>
            <input type="file" name="csv" id="csv" accept=".csv,text/csv"
                   class="block w-full p-2 border-2 border-[#007acc]/30 rounded-lg focus:border-[#007acc] focus:outline-none transition" required>
        </div>
        <button type="submit" class="w-full bg-[#007acc] text-white font-semibold py-2 rounded-lg shadow hover:bg-[#002b5c] hover:scale-105 transition flex items-center justify-center gap-2">
            <i class="fa-solid fa-upload"></i> Cargar asistentes
        </button>
    </form>

    <a href="index.php" class="block mt-6 text-center text-sm text-[#002b5c] underline hover:text-[#C1228E] transition">
        <i class="fa-solid fa-arrow-left"></i> Volver al menú
    </a>
</div>
</body>
</html>