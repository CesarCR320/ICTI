document.addEventListener("DOMContentLoaded", async function () {
    const eventoSelect = document.getElementById("select-evento");
    let currentEvento = null;
    let activoEvento = null;

    // Cargar solo "Todos" y el evento activo
    async function cargarSelectorEvento() {
        eventoSelect.innerHTML = '<option value="">Todos los eventos</option>';
        // Obtener evento activo
        const res = await fetch("api/estadisticas_api.php?type=evento_activo");
        activoEvento = await res.json();
        if (activoEvento && activoEvento.id) {
            const opt = document.createElement("option");
            opt.value = activoEvento.id;
            opt.textContent = `Evento activo: ${activoEvento.nombre}`;
            eventoSelect.appendChild(opt);
            eventoSelect.value = activoEvento.id; // Selecciona por defecto el evento activo
            currentEvento = activoEvento.id;
        } else {
            eventoSelect.value = ""; // Si no hay evento activo, selecciona "Todos"
            currentEvento = null;
        }
        actualizarEstadisticas();
    }

    eventoSelect.addEventListener("change", () => {
        currentEvento = eventoSelect.value || null;
        actualizarEstadisticas();
    });

    // KPI
    async function actualizarKPIs() {
        const res = await fetch("api/estadisticas_api.php?type=kpis" + (currentEvento ? "&evento_id=" + currentEvento : ""));
        const kpis = await res.json();
        document.getElementById("kpi-total").textContent = kpis.total || 0;
        document.getElementById("kpi-asistieron").textContent = kpis.asistieron || 0;
        document.getElementById("kpi-noasistieron").textContent = kpis.no_asistieron || 0;
        document.getElementById("kpi-indigena").textContent = kpis.comunidad_indigena || 0;
    }

    // Gráficos
    let generoChart, escolaridadChart, diariaChart;

    async function actualizarGenero() {
        const res = await fetch("api/estadisticas_api.php?type=genero" + (currentEvento ? "&evento_id=" + currentEvento : ""));
        const data = await res.json();
        const labels = Object.keys(data);
        const values = Object.values(data);

        if (generoChart) generoChart.destroy();
        generoChart = new Chart(document.getElementById("genero-chart"), {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: "Participantes",
                    data: values,
                    backgroundColor: [
                        "#C1228E", "#007acc", "#ffb700", "#aaa", "#ddd"
                    ]
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                responsive: true,
                scales: { y: { beginAtZero: true } }
            }
        });
    }

    async function actualizarEscolaridad() {
        const res = await fetch("api/estadisticas_api.php?type=escolaridad" + (currentEvento ? "&evento_id=" + currentEvento : ""));
        const data = await res.json();
        const labels = Object.keys(data);
        const values = Object.values(data);

        if (escolaridadChart) escolaridadChart.destroy();
        escolaridadChart = new Chart(document.getElementById("escolaridad-chart"), {
            type: 'pie',
            data: {
                labels,
                datasets: [{
                    data: values,
                    backgroundColor: [
                        "#007acc", "#C1228E", "#ffb700", "#5bc0be", "#aaa"
                    ]
                }]
            },
            options: {
                responsive: true
            }
        });
    }

    async function actualizarDiaria() {
        const res = await fetch("api/estadisticas_api.php?type=diaria" + (currentEvento ? "&evento_id=" + currentEvento : ""));
        const data = await res.json();
        const labels = Object.keys(data);
        const values = Object.values(data);

        if (diariaChart) diariaChart.destroy();
        diariaChart = new Chart(document.getElementById("diaria-chart"), {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: "Asistencias",
                    data: values,
                    fill: true,
                    borderColor: "#C1228E",
                    backgroundColor: "rgba(193,34,142,0.1)",
                    tension: 0.2
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } }
            }
        });
    }

    async function actualizarEstadisticas() {
        await Promise.all([
            actualizarKPIs(),
            actualizarGenero(),
            actualizarEscolaridad(),
            actualizarDiaria()
        ]);
    }

    // Botón para descargar CSV
    document.getElementById("btn-descargar-csv").addEventListener("click", function() {
        const eventoId = document.getElementById("select-evento").value;
        let url = "api/estadisticas_csv.php";
        if (eventoId) url += "?evento_id=" + encodeURIComponent(eventoId);
        window.open(url, "_blank");
    });

    // Botón para descargar PDF
    document.getElementById("btn-descargar-pdf").addEventListener("click", async function() {
        // Obtén imágenes base64 de los gráficos
        const generoImg = document.getElementById("genero-chart").toDataURL();
        const escolaridadImg = document.getElementById("escolaridad-chart").toDataURL();
        const diariaImg = document.getElementById("diaria-chart").toDataURL();

        // Obtén los KPIs y nombre de evento
        const kpis = {
            total: document.getElementById("kpi-total").textContent,
            asistieron: document.getElementById("kpi-asistieron").textContent,
            noasistieron: document.getElementById("kpi-noasistieron").textContent,
            indigena: document.getElementById("kpi-indigena").textContent
        };

        const eventoSelect = document.getElementById("select-evento");
        const eventoNombre = eventoSelect.options[eventoSelect.selectedIndex].text;
        
        // Enviar al backend usando POST con FormData (descarga directa)
        const form = document.createElement("form");
        form.method = "POST";
        form.action = "api/estadisticas_pdf.php";
        form.target = "_blank";

        function addField(name, value) {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = name;
            input.value = value;
            form.appendChild(input);
        }

        addField("generoImg", generoImg);
        addField("escolaridadImg", escolaridadImg);
        addField("diariaImg", diariaImg);
        addField("total", kpis.total);
        addField("asistieron", kpis.asistieron);
        addField("noasistieron", kpis.noasistieron);
        addField("indigena", kpis.indigena);
        addField("eventoNombre", eventoNombre);

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    });

    await cargarSelectorEvento();
});