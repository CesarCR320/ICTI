<?php
include 'config.php';

$evento_activo = "Ningún evento activo";
$fecha_evento = "";

$query = "SELECT nombre, fecha FROM eventos WHERE activo = 1 LIMIT 1";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $evento_activo = $row['nombre'];
    $fecha_evento = $row['fecha'];
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Panel Principal - ICTI</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body class="bg-gray-100">

  <nav class="bg-[#002b5c] text-white px-6 py-4 shadow-md">
    <div class="max-w-7xl mx-auto text-center">
      <h1 class="text-xl font-semibold">📌 ICTI - Sistema de Asistencia</h1>
    </div>
  </nav>

  <main class="max-w-6xl mx-auto mt-10 px-4">

    <div class="bg-white p-6 rounded-xl shadow-md mb-10">
      <h2 class="text-lg font-semibold mb-1">👋 Bienvenido</h2>
      <p class="text-gray-600">Evento activo: <strong><?php echo $evento_activo; ?></strong></p>
      <?php if (!empty($fecha_evento)): ?>
        <p class="text-gray-600">Fecha: <strong><?php echo $fecha_evento; ?></strong></p>
      <?php endif; ?>
    </div>

    <h3 class="text-xl font-bold text-gray-800 mb-4">🛠️ Funciones de Registro</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-12">

      <a href="escanear.html" class="bg-white rounded-2xl shadow-lg p-6 text-center hover:shadow-xl block">
        <div class="text-4xl mb-2">📸</div>
        <h3 class="text-lg font-semibold">Escanear QR</h3>
      </a>

      <a href="registrar_folio.html" class="bg-white rounded-2xl shadow-lg p-6 text-center hover:shadow-xl block">
        <div class="text-4xl mb-2">🔍</div>
        <h3 class="text-lg font-semibold">Registrar por Folio</h3>
      </a>

    <a href="asistentes.php" class="bg-white rounded-2xl shadow-lg p-6 text-center hover:shadow-xl block transition">
      <div class="text-4xl mb-2">🧾</div>
      <h3 class="text-lg font-semibold">Lista de Asistentes</h3>
    </a>


      <div class="bg-white rounded-2xl shadow-lg p-6 text-center hover:shadow-xl block">
        <div class="text-4xl mb-2">📊</div>
        <h3 class="text-lg font-semibold">Estadísticas</h3>
      </div>
    </div>

    <h3 class="text-xl font-bold text-gray-800 mb-4">⚙️ Funciones Administrativas</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

      <a href="cargar_base.html" class="bg-white rounded-2xl shadow-lg p-6 text-center hover:shadow-xl block">
    <div class="text-4xl mb-2">⬆️</div>
    <h3 class="text-lg font-semibold">Cargar Base de Datos</h3>
  </a>

      <a href="crear_evento.html" class="bg-white rounded-2xl shadow-lg p-6 text-center hover:shadow-xl block">
        <div class="text-4xl mb-2">📅</div>
        <h3 class="text-lg font-semibold">Crear Evento</h3>
      </a>

<a href="seleccionar_evento.php" class="bg-white rounded-2xl shadow-lg p-6 text-center hover:shadow-xl block">
  <div class="text-4xl mb-2">🎯</div>
  <h3 class="text-lg font-semibold">Activar Evento</h3>
</a>


      <div class="bg-white rounded-2xl shadow-lg p-6 text-center hover:shadow-xl block">
        <div class="text-4xl mb-2">⚙️</div>
        <h3 class="text-lg font-semibold">Configuración</h3>
        <p class="text-sm text-gray-500">(En desarrollo)</p>
      </div>

    </div>
  </main>
</body>
</html>
