document.addEventListener("DOMContentLoaded", function () {
  const qrResult = document.getElementById("qr-result");
  const volverBtn = document.getElementById("volver");
  let html5QrcodeScanner = null;

  volverBtn.onclick = () => window.location.href = "index.php";

  function mostrarConfirmacion(data) {
    qrResult.innerHTML = `
      <div class="bg-green-100 border border-green-400 text-green-800 p-4 rounded-lg mb-4 text-center">
        ✅ Asistencia registrada<br>
        <span class="font-bold">${data.nombre ?? ''}</span><br>
        <span class="text-sm text-gray-700">Folio: ${data.folio}</span>
      </div>
      <button id="btn-nuevo-registro" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        Nuevo registro
      </button>
    `;
    document.getElementById('btn-nuevo-registro').onclick = function() {
      qrResult.innerHTML = '';
      html5QrcodeScanner.clear().then(() => {
        iniciarEscaneo();
      });
    };
  }

  function mostrarError(msg) {
    qrResult.innerHTML = `<span class="text-red-700">❌ ${msg}</span>
      <button id="btn-nuevo-registro" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        Nuevo registro
      </button>`;
    document.getElementById('btn-nuevo-registro').onclick = function() {
      qrResult.innerHTML = '';
      html5QrcodeScanner.clear().then(() => {
        iniciarEscaneo();
      });
    };
  }

  function onScanSuccess(decodedText, decodedResult) {
    qrResult.innerHTML = "Procesando asistencia...";
    fetch("registrar_asistencia_qr.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ folio: decodedText })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        // Intenta obtener el nombre del asistente
        fetch('obtener_asistente.php', {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ folio: data.folio })
        })
        .then(r => r.json())
        .then(asistente => {
          mostrarConfirmacion({
            folio: data.folio,
            nombre: asistente && asistente.nombre ? `${asistente.nombre} ${asistente.apellido_paterno ?? ''} ${asistente.apellido_materno ?? ''}` : ''
          });
        })
        .catch(() => mostrarConfirmacion({ folio: data.folio, nombre: '' }));
      } else {
        mostrarError(data.message || 'No se pudo registrar la asistencia.');
      }
    })
    .catch(() => {
      mostrarError('Error de comunicación con el servidor.');
    });

    html5QrcodeScanner.clear();
  }

  function onScanFailure(error) {
    // Silencio
  }

  function iniciarEscaneo() {
    html5QrcodeScanner = new Html5QrcodeScanner(
      "qr-reader", { fps: 10, qrbox: 250 }
    );
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
  }

  iniciarEscaneo();
});