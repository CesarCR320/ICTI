<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Escanear QR - Registro de Asistencia</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <script src="https://unpkg.com/html5-qrcode"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f3f4f6; }
    </style>
</head>
<body class="flex flex-col items-center min-h-screen p-6">
    <div class="w-full max-w-xl bg-white rounded-2xl shadow-lg p-8 mt-8">
        <h2 class="text-2xl font-bold text-center mb-4 text-[#002b5c]">📸 Escanear QR para registro</h2>
        <div id="qr-reader" class="mx-auto mb-4"></div>
        <div id="qr-result" class="text-center text-lg font-semibold mt-4"></div>
        <button id="volver" class="mt-6 bg-[#C1228E] text-white font-semibold py-2 px-6 rounded shadow hover:bg-pink-700 transition">← Volver al menú principal</button>
    </div>
    <script src="/resources/js/escanear_qr.js"></script>
</body>
</html>