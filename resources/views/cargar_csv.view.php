<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cargar asistentes por CSV</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f3f4f6; }
    </style>
</head>
<body class="flex justify-center items-center min-h-screen p-4">
<div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
    <h2 class="text-xl font-bold text-center mb-6 text-[#002b5c]">📁 Cargar asistentes desde archivo CSV</h2>

    <?php if (isset($mensaje) && $mensaje): ?>
        <div class="mb-4 text-center <?= strpos($mensaje, '✅') !== false ? 'text-green-700 bg-green-100 border-green-300' : 'text-red-700 bg-red-100 border-red-300' ?> border rounded p-2">
            <?= $mensaje ?>
        </div>
        <?php if ($resultado && isset($resultado['errores']) && count($resultado['errores']) > 0): ?>
            <div class="mb-4 text-sm text-red-700 bg-red-50 border border-red-200 rounded p-2">
                <b>Errores encontrados:</b>
                <ul class="ml-4">
                    <?php foreach ($resultado['errores'] as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <form action="cargar_csv.php" method="POST" enctype="multipart/form-data" class="space-y-4">
        <input type="file" name="csv" accept=".csv,text/csv" required
               class="w-full block p-2 border rounded-lg">
        <button type="submit" class="w-full bg-[#007acc] text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition">
            Cargar asistentes
        </button>
    </form>

    <a href="index.php" class="block mt-4 text-center text-sm text-[#002b5c] underline hover:text-[#007acc] transition">← Volver al menú</a>
</div>
</body>
</html>