<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["archivo_csv"])) {
    $archivo = $_FILES["archivo_csv"]["tmp_name"];
    $nombreArchivo = $_FILES["archivo_csv"]["name"];

    if (pathinfo($nombreArchivo, PATHINFO_EXTENSION) !== 'csv') {
        exit("❌ El archivo debe tener extensión .csv");
    }

    $eventoQuery = "SELECT id FROM eventos WHERE activo = 1 LIMIT 1";
    $eventoResult = $conn->query($eventoQuery);

    if (!$eventoResult || $eventoResult->num_rows === 0) {
        exit("❌ No hay un evento activo. Por favor activa uno antes de cargar datos.");
    }

    $evento = $eventoResult->fetch_assoc();
    $evento_id = $evento['id'];

    $handle = fopen($archivo, "r");
    if ($handle === false) {
        exit("❌ No se pudo abrir el archivo.");
    }

    $encabezado = fgetcsv($handle); 
    $insertados = 0;

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $folio                = $data[0];
        $nombre               = $data[1];
        $apellido_paterno     = $data[2];
        $apellido_materno     = $data[3];
        $nacionalidad         = $data[4];
        $estado               = $data[5];
        $municipio            = $data[6];
        $edad                 = (int) $data[7];
        $genero               = $data[8];
        $estado_civil         = $data[9];
        $escolaridad          = $data[10];
        $institucion          = $data[11];
        $facultad             = $data[12];
        $email                = $data[13];
        $comunidad_indigena  = strtolower(trim($data[14])) === 'sí' ? 1 : 0;
        $comunidad_nombre     = $data[15];

        $stmt = $conn->prepare("INSERT INTO asistentes_congreso (
            folio, nombre, apellido_paterno, apellido_materno, nacionalidad, estado, municipio, edad,
            genero, estado_civil, escolaridad, institucion, facultad, email, comunidad_indigena,
            comunidad_indigena_nombre, evento_id
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("sssssssissssssssi", $folio, $nombre, $apellido_paterno, $apellido_materno, $nacionalidad,
            $estado, $municipio, $edad, $genero, $estado_civil, $escolaridad, $institucion, $facultad, $email,
            $comunidad_indigena, $comunidad_nombre, $evento_id);

        if ($stmt->execute()) {
            $insertados++;
        }

        $stmt->close();
    }

    fclose($handle);
    $conn->close();

    echo "✅ Se cargaron correctamente <strong>$insertados</strong> asistentes al evento activo.";
} else {
    echo "❌ No se recibió un archivo válido.";
}
?>
