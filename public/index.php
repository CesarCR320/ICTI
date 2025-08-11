<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ICTI - Sistema de Asistencia</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f0f4ff 0%, #f8e5f6 100%);
      min-height: 100vh;
      position: relative;
      overflow-x: hidden;
    }
    .card-menu {
      transition: transform 0.18s, box-shadow 0.15s, background 0.3s;
      cursor: pointer;
      border: 2px solid #C1228E33;
      background: white;
      box-shadow: 0 2px 6px 0 #c1228e18;
      position: relative;
      outline: none;
    }
    .card-menu:hover, .card-menu:focus {
      transform: translateY(-4px) scale(1.04);
      box-shadow: 0 6px 32px 4px #C1228E33, 0 1.5px 8px #007ACC22;
      background: #fce6f2;
      border-color: #C1228E;
      z-index: 2;
    }
    .emoji {
      font-size: 2.5rem;
      margin-bottom: 0.6rem;
      filter: drop-shadow(0 2px 5px #c1228e21);
    }
    .fade-in {
      animation: fadein 0.6s;
    }
    @keyframes fadein { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: none; } }
    .transition { transition: background 0.2s, color 0.2s; }
    .tooltip {
      opacity: 0;
      pointer-events: none;
      position: absolute;
      left: 50%; top: 100%; transform: translateX(-50%) translateY(6px);
      padding: 0.4rem 0.7rem;
      background: #222b;
      color: #fff;
      font-size: 0.9rem;
      border-radius: 0.6rem;
      white-space: nowrap;
      transition: opacity 0.18s;
      z-index: 10;
      font-weight: 500;
    }
    .card-menu:focus .tooltip,
    .card-menu:hover .tooltip {
      opacity: 1;
      pointer-events: auto;
    }
    @media (max-width: 640px) {
      .emoji { font-size: 2rem; }
      .card-menu { padding: 1.2rem !important; }
    }
  </style>
</head>
<body>
  <nav class="bg-gradient-to-r from-[#C1228E] via-[#007ACC] to-[#002D5C] text-white px-8 py-6 shadow-lg sticky top-0 z-50 rounded-b-xl">
    <div class="max-w-7xl mx-auto flex justify-center items-center gap-4">
      <img src="logo_icti.png" alt="ICTI Logo" class="hidden sm:block h-12 rounded-xl shadow-md bg-white/80 p-1">
      <h1 class="text-2xl sm:text-3xl font-bold tracking-wide flex items-center gap-2"><i class="fa-solid fa-microchip"></i> - Sistema de Asistencia</h1>
    </div>
  </nav>

  <main class="max-w-5xl mx-auto px-4 py-10 fade-in">
    <!-- Tarjeta de bienvenida y evento activo -->
    <section class="mb-12">
      <div class="bg-white p-8 rounded-3xl shadow-2xl text-center border-t-8 border-[#C1228E]">
        <div class="flex flex-col items-center mb-3">
          <div class="bg-[#007ACC] text-white rounded-full w-16 h-16 flex items-center justify-center shadow-lg text-4xl mb-2">
            <i class="fa-solid fa-hand-wave"></i>
          </div>
          <h2 class="text-3xl font-bold text-[#002D5C] mb-1">¡Bienvenido!</h2>
        </div>
        <p class="text-gray-600 mb-2">Gestiona y registra la asistencia de los eventos del ICTI fácil y rápido.</p>
        <div class="flex flex-col items-center gap-0.5 mt-3">
          <div class="font-semibold text-[#C1228E] flex items-center gap-2">
            <i class="fa-solid fa-calendar-check"></i>
            Evento activo:
            <span id="eventoNombre" class="font-bold text-black"></span>
          </div>
          <div class="font-semibold text-[#007acc] flex items-center gap-2">
            <i class="fa-solid fa-clock"></i>
            Fecha:
            <span id="eventoFecha" class="font-bold text-black"></span>
          </div>
        </div>
      </div>
    </section>

    <!-- Sección de registro -->
    <section class="mb-14">
      <h3 class="text-2xl font-semibold text-[#002D5C] mb-6 flex items-center gap-2"><i class="fa-solid fa-clipboard-list"></i> Funciones de Registro</h3>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-7" id="menuRegistro"></div>
    </section>

    <!-- Sección administrativa -->
    <section>
      <h3 class="text-2xl font-semibold text-[#C1228E] mb-6 flex items-center gap-2"><i class="fa-solid fa-gears"></i> Funciones Administrativas</h3>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-7" id="menuAdmin"></div>
    </section>
  </main>

  <footer class="w-full pt-8 pb-4 px-4 text-center text-sm text-gray-500">
    <hr class="mb-2">
    Hecho con <span aria-label="corazón" class="text-[#C1228E]">♥</span> por el equipo ICTI &middot; <span class="font-semibold">2025</span>
  </footer>

<script>
  // Trae evento activo
  document.addEventListener("DOMContentLoaded", () => {
    fetch("api/evento_activo.php")
      .then(res => res.json())
      .then(evento => {
        document.getElementById("eventoNombre").textContent = evento.nombre || "Sin evento activo";
        document.getElementById("eventoFecha").textContent = evento.fecha || "-";
      });
  });

  // Opciones de menú
  const registro = [
    { emoji: '📸', texto: 'Escanear QR', link: 'escanear_qr.php', desc: "Escanea el código QR de los asistentes para marcar su registro." },
    { emoji: '🔍', texto: 'Registrar por Folio', link: 'registrar_folio.php', desc: "Registra asistencia manualmente introduciendo folio." },
    { emoji: '🧾', texto: 'Lista de Asistentes', link: 'asistentes.php', desc: "Consulta y gestiona la lista completa de asistentes." }
  ];
  const admin = [
    { emoji: '⬆️', texto: 'Cargar Base', link: 'cargar_csv.php', desc: "Carga una base de datos de asistentes en formato CSV." },
    { emoji: '📅', texto: 'Crear Evento', link: 'crear_evento.php', desc: "Crea un nuevo evento para el control de asistencias." },
    { emoji: '🎯', texto: 'Activar Evento', link: 'seleccionar_evento.php', desc: "Selecciona qué evento estará activo para el registro." },
    { emoji: '📊', texto: 'Estadísticas', link: 'estadisticas.php', desc: "Visualiza estadísticas del evento y asistencia." }
  ];

  function crearTarjetas(arr, contenedorId) {
    const contenedor = document.getElementById(contenedorId);
    arr.forEach(op => {
      const card = document.createElement("button");
      card.type = "button";
      card.className = "card-menu rounded-2xl p-7 text-center shadow-md hover:shadow-xl focus:shadow-xl focus:ring-2 focus:ring-[#C1228E] relative group transition";
      card.onclick = () => window.location.href = op.link;
      card.setAttribute("tabindex", "0");
      card.setAttribute("aria-label", op.texto + ". " + op.desc);
      card.innerHTML = `
        <div class="emoji">${op.emoji}</div>
        <h4 class="text-lg font-semibold text-[#002D5C] mb-1">${op.texto}</h4>
        <div class="text-sm text-gray-500">${op.desc}</div>
        <span class="tooltip">${op.desc}</span>
      `;
      contenedor.appendChild(card);
    });
  }
  crearTarjetas(registro, "menuRegistro");
  crearTarjetas(admin, "menuAdmin");
</script>
</body>
</html>