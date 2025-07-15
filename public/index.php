<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ICTI - Sistema de Asistencia</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to bottom right, #f0f4ff, #ffffff);
    }
    .card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
      border: 2px solid #C1228E;
      background: white;
    }
    .card:hover {
      transform: translateY(-6px);
      box-shadow: 0 20px 30px rgba(0, 0, 0, 0.15);
      background-color: #fce6f2; 
    }
    .emoji {
      font-size: 2.5rem;
      margin-bottom: 0.5rem;
    }
  </style>
</head>
<body>
  <nav class="bg-gradient-to-r from-[#C1228E] via-[#007ACC] to-[#002D5C] text-white px-6 py-4 shadow-lg sticky top-0 z-50 rounded-b-xl">
    <div class="max-w-7xl mx-auto flex justify-center">
      <h1 class="text-2xl font-bold">📌 ICTI - Sistema de Asistencia</h1>
    </div>
  </nav>

  <main class="max-w-6xl mx-auto px-4 py-12">
    <section class="mb-12">
      <div class="bg-white p-6 rounded-2xl shadow-lg text-center">
        <h2 class="text-3xl font-bold text-[#002D5C] mb-2">👋 Bienvenido</h2>
        <p class="text-gray-600">Evento activo: <span id="eventoNombre" class="font-semibold text-black"></span></p>
        <p class="text-gray-600">Fecha: <span id="eventoFecha" class="font-semibold text-black"></span></p>
      </div>
    </section>

    <section class="mb-12">
      <h3 class="text-2xl font-semibold text-[#002D5C] mb-6">🛠️ Funciones de Registro</h3>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6" id="menuRegistro"></div>
    </section>

    <section>
      <h3 class="text-2xl font-semibold text-[#002D5C] mb-6">⚙️ Funciones Administrativas</h3>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6" id="menuAdmin"></div>
    </section>
  </main>

  <!-- ...tu HTML arriba... -->
<script>
  // Animaciones (lo que ya tienes)
  document.addEventListener("DOMContentLoaded", () => {
    const tarjetas = document.querySelectorAll('.animar');
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, { threshold: 0.1 });
    tarjetas.forEach(t => observer.observe(t));

    // --- NUEVO: Evento activo dinámico ---
    fetch("api/evento_activo.php")
      .then(res => res.json())
      .then(evento => {
        document.getElementById("eventoNombre").textContent = evento.nombre;
        document.getElementById("eventoFecha").textContent = evento.fecha;
      });
    // --- FIN NUEVO ---
  });

  // Menús (lo que ya tienes)
  const registro = [
    { emoji: '📸', texto: 'Escanear QR', link: 'escanear_qr.php' },
    { emoji: '🔍', texto: 'Registrar por Folio', link: 'registrar_folio.php' },
    { emoji: '🧾', texto: 'Lista de Asistentes', link: 'asistentes.php' },
    { emoji: '📊', texto: 'Estadísticas', link: 'estadisticas.php' }
  ];
  const admin = [
    { emoji: '⬆️', texto: 'Cargar Base', link: 'cargar_csv.php' },
    { emoji: '📅', texto: 'Crear Evento', link: 'crear_evento.php' },
    { emoji: '🎯', texto: 'Activar Evento', link: 'seleccionar_evento.php' }
  ];
  function crearTarjetas(arr, contenedorId) {
    const contenedor = document.getElementById(contenedorId);
    arr.forEach(op => {
      const card = document.createElement("div");
      card.className = "card rounded-2xl p-6 text-center shadow-md hover:shadow-xl animar";
      card.onclick = () => window.location.href = op.link;
      card.innerHTML = `
        <div class="emoji">${op.emoji}</div>
        <h4 class="text-lg font-semibold text-[#002D5C]">${op.texto}</h4>
      `;
      contenedor.appendChild(card);
    });
  }
  crearTarjetas(registro, "menuRegistro");
  crearTarjetas(admin, "menuAdmin");
</script>
</body>
</html>
