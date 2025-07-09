<?php
require_once __DIR__ . '/../../config/database.php';

class CsvController {
    public static function procesarCSV($archivo) {
        $conn = getDatabaseConnection();
        $handle = fopen($archivo, 'r');
        if (!$handle) {
            return ['success' => false, 'error' => 'No se pudo abrir el archivo CSV.'];
        }

        $insertados = 0;
        $errores = [];
        $primeraLinea = true;
        $camposEsperados = ['folio', 'nombre', 'correo']; // Ajusta a tus campos

        while (($datos = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($primeraLinea) {
                // Validar cabecera
                foreach ($camposEsperados as $idx => $campo) {
                    if (strtolower(trim($datos[$idx])) !== strtolower($campo)) {
                        fclose($handle);
                        return ['success' => false, 'error' => 'La cabecera del CSV es incorrecta. Usa: ' . implode(', ', $camposEsperados)];
                    }
                }
                $primeraLinea = false;
                continue;
            }
            // Valida que existan todos los campos requeridos
            if (count($datos) < count($camposEsperados)) {
                $errores[] = "Fila incompleta: " . implode(", ", $datos);
                continue;
            }

            $folio = trim($datos[0]);
            $nombre = trim($datos[1]);
            $correo = trim($datos[2]);
            // Puedes agregar más validaciones aquí

            // Inserta en la base de datos (ajusta el nombre de la tabla/columnas si es necesario)
            $stmt = $conn->prepare("INSERT INTO asistentes_congreso (folio, nombre, correo) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE nombre=VALUES(nombre), correo=VALUES(correo)");
            $stmt->bind_param("sss", $folio, $nombre, $correo);
            if ($stmt->execute()) {
                $insertados++;
            } else {
                $errores[] = "Error al insertar folio $folio: " . $stmt->error;
            }
            $stmt->close();
        }
        fclose($handle);
        $conn->close();

        return [
            'success' => true,
            'insertados' => $insertados,
            'errores' => $errores
        ];
    }
}