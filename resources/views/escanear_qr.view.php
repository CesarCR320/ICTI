<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Escanear QR - Registro de Asistencia</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f3f4f6; }
        .animate-fade-in { animation: fadein 0.5s; }
        @keyframes fadein { from { opacity: 0; } to { opacity: 1; } }
        #qr-reader {
            border: 2px solid #C1228E;
            border-radius: 1rem;
            background: #f9f9fb;
        }
    </style>
</head>
<body class="flex flex-col items-center min-h-screen p-4">

    <div class="w-full max-w-xl bg-white rounded-3xl shadow-2xl p-8 mt-8 border-t-8 border-[#C1228E] animate-fade-in">
        <div class="flex flex-col items-center mb-6">
            <div class="bg-[#007acc] text-white rounded-full w-16 h-16 flex items-center justify-center shadow-lg text-4xl mb-2">
                <i class="fa-solid fa-qrcode"></i>
            </div>
            <h2 class="text-2xl font-bold text-[#002b5c] mb-1">Escanear QR para registro</h2>
            <p class="text-gray-500 text-sm mb-2">Apunta la cámara al código QR del asistente para registrar su asistencia.</p>
        </div>
        <div id="qr-reader" class="mx-auto w-full max-w-xs mb-4"></div>
        <div id="qr-result" class="text-center text-lg font-semibold mt-4"></div>
        <button id="volver" class="mt-8 w-full bg-[#C1228E] text-white font-semibold py-2 rounded-lg shadow hover:bg-[#007acc] hover:scale-105 transition flex items-center justify-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Volver al menú principal
        </button>
    </div>

    <script src="/resources/js/escanear_qr.js"></script>
    <script>
        // Estilos dinámicos para el resultado
        function mostrarResultado(mensaje, exito = false) {
            const resultDiv = document.getElementById('qr-result');
            resultDiv.textContent = mensaje;
            resultDiv.className =
                'text-center text-lg font-semibold mt-4 ' +
                (exito
                    ? 'text-green-700 bg-green-100 border border-green-300 rounded p-2 shadow'
                    : 'text-red-700 bg-red-100 border border-red-300 rounded p-2 shadow');
        }

        // Si tu lógica JS muestra mensajes, puedes usar mostrarResultado(mensaje, true/false)
        document.getElementById('volver').onclick = () => {
            window.location.href = 'index.php';
        };
    </script>
</body>
</html>