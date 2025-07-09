document.addEventListener("DOMContentLoaded", function () {
  const qrResult = document.getElementById("qr-result");
  const volverBtn = document.getElementById("volver");

  volverBtn.onclick = () => window.location.href = "index.php";

  function onScanSuccess(decodedText, decodedResult) {
    // Suponemos que el QR contiene el folio del asistente
    qrResult.innerHTML = "Procesando asistencia...";
    // Enviar folio al backend para registrar asistencia
    fetch("registrar_asistencia_qr.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ folio: decodedText })
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          qrResult.innerHTML = `<span class="text-green-700">✅ Asistencia registrada para el folio: <b>${data.folio}</b></span>`;
        } else {
          qrResult.innerHTML = `<span class="text-red-700">❌ ${data.message || 'No se pudo registrar la asistencia.'}</span>`;
        }
      })
      .catch(() => {
        qrResult.innerHTML = `<span class="text-red-700">❌ Error de comunicación con el servidor.</span>`;
      });

    html5QrcodeScanner.clear();
  }

  function onScanFailure(error) {
    // No mostrar errores menores
  }

  const html5QrcodeScanner = new Html5QrcodeScanner(
    "qr-reader", { fps: 10, qrbox: 250 }
  );
  html5QrcodeScanner.render(onScanSuccess, onScanFailure);
});