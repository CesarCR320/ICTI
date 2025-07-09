<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estadísticas ICTI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f3f4f6; }
    </style>
</head>
<body class="min-h-screen p-4">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold text-[#002b5c] mb-2 text-center">📊 Estadísticas de Asistencia</h1>
        <div class="flex flex-col md:flex-row md:justify-between items-center mb-6 gap-4">
            <div>
                <label class="font-semibold text-[#002b5c]">Seleccionar:</label>
                <select id="select-evento" class="border rounded p-2 ml-2"></select>
            </div>
            <a href="index.php" class="mt-2 block md:inline text-[#007acc] underline">← Volver al menú</a>
        </div>
        <div class="mb-4 flex flex-col md:flex-row gap-2 md:gap-4 items-center">
            <button id="btn-descargar-csv" class="bg-[#007acc] text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Descargar estadísticas en CSV
            </button>
            <button id="btn-descargar-pdf" class="bg-[#C1228E] text-white px-4 py-2 rounded hover:bg-pink-700 transition">
                Descargar reporte PDF
            </button>
        </div>
        <!-- KPIs -->
        <div id="kpis" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow text-center p-6">
                <div class="text-2xl font-bold text-[#C1228E]" id="kpi-total">0</div>
                <div class="text-gray-500">Registrados</div>
            </div>
            <div class="bg-white rounded-lg shadow text-center p-6">
                <div class="text-2xl font-bold text-green-600" id="kpi-asistieron">0</div>
                <div class="text-gray-500">Asistieron</div>
            </div>
            <div class="bg-white rounded-lg shadow text-center p-6">
                <div class="text-2xl font-bold text-red-600" id="kpi-noasistieron">0</div>
                <div class="text-gray-500">No asistieron</div>
            </div>
            <div class="bg-white rounded-lg shadow text-center p-6">
                <div class="text-2xl font-bold text-indigo-700" id="kpi-indigena">0</div>
                <div class="text-gray-500">Comunidad indígena</div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="bg-white rounded-lg p-6 shadow">
                <h3 class="text-lg font-semibold mb-2 text-[#002b5c]">Género (barras)</h3>
                <canvas id="genero-chart"></canvas>
            </div>
            <div class="bg-white rounded-lg p-6 shadow">
                <h3 class="text-lg font-semibold mb-2 text-[#002b5c]">Escolaridad (pastel)</h3>
                <canvas id="escolaridad-chart"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-lg p-6 shadow mb-8">
            <h3 class="text-lg font-semibold mb-2 text-[#002b5c]">Asistencias por día</h3>
            <canvas id="diaria-chart"></canvas>
        </div>
    </div>
    <script src="/resources/js/estadisticas.js"></script>
</body>
</html>