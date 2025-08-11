<?php
require_once __DIR__ . '/../../config/database.php';

class CsvController {
    public static function procesarCSV($archivo) {
        $conn = getDatabaseConnection();
        $handle = fopen($archivo, 'r');
        if (!$handle) {
            return ['success' => false, 'error' => 'No se pudo abrir el archivo CSV.'];
        }

        // --- NUEVO: obtener el evento activo ---
        $eventoActivo = $conn->query("SELECT id FROM eventos WHERE activo = 1 LIMIT 1")->fetch_assoc();
        if (!$eventoActivo) {
            fclose($handle);
            return ['success' => false, 'error' => 'No hay evento activo.'];
        }
        $evento_id_activo = intval($eventoActivo['id']);
        // --- FIN NUEVO ---

        $insertados = 0;
        $errores = [];
        $primeraLinea = true;
        $camposEsperados = [
            'folio','nombre','apellido_paterno','apellido_materno','nacionalidad','estado','municipio','edad','genero',
            'estado_civil','escolaridad','institucion','facultad','email','comunidad_indigena','comunidad_indigena_nombre','evento_id'
        ];

        while (($datos = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($primeraLinea) {
                // Validar cabecera
                foreach ($camposEsperados as $idx => $campo) {
                    if (!isset($datos[$idx]) || strtolower(trim($datos[$idx])) !== strtolower($campo)) {
                        fclose($handle);
                        return ['success' => false, 'error' => "El campo <b>$campo</b> no está en la posición correcta del CSV. Esperado: " . implode(',', $camposEsperados)];
                    }
                }
                $primeraLinea = false;
                continue;
            }

            // Validar número de columnas
            if (count($datos) < count($camposEsperados)) {
                $errores[] = "Faltan columnas en la fila: " . implode(',', $datos);
                continue;
            }

            // Validar campos obligatorios
            if (empty($datos[0]) || empty($datos[1]) || empty($datos[2]) || empty($datos[3]) || empty($datos[13])) {
                $errores[] = "Campos obligatorios incompletos en la fila: " . implode(',', $datos);
                continue;
            }

            // --- NUEVO: usar SIEMPRE el evento_id_activo ---
            $evento_id = $evento_id_activo;
            // --- FIN NUEVO ---

            // Prevenir duplicados por folio y evento_id
            $stmtCheck = $conn->prepare("SELECT COUNT(*) FROM asistentes_congreso WHERE folio = ? AND evento_id = ?");
            $stmtCheck->bind_param("si", $datos[0], $evento_id);
            $stmtCheck->execute();
            $stmtCheck->bind_result($existe);
            $stmtCheck->fetch();
            $stmtCheck->close();

            if ($existe > 0) {
                $errores[] = "Folio duplicado para el evento en la fila: " . $datos[0];
                continue;
            }

            // Insertar registro
            $sql = "INSERT INTO asistentes_congreso (
                folio, nombre, apellido_paterno, apellido_materno, nacionalidad, estado, municipio, edad, genero,
                estado_civil, escolaridad, institucion, facultad, email, comunidad_indigena, comunidad_indigena_nombre, evento_id
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Convertir valores para types
            $edad = is_numeric($datos[7]) ? intval($datos[7]) : null;
            $comunidad_indigena = is_numeric($datos[14]) ? intval($datos[14]) : 0;

            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "ssssssssssssssssi",
                $datos[0],  // folio
                $datos[1],  // nombre
                $datos[2],  // apellido_paterno
                $datos[3],  // apellido_materno
                $datos[4],  // nacionalidad
                $datos[5],  // estado
                $datos[6],  // municipio
                $edad,      // edad
                $datos[8],  // genero
                $datos[9],  // estado_civil
                $datos[10], // escolaridad
                $datos[11], // institucion
                $datos[12], // facultad
                $datos[13], // email
                $comunidad_indigena, // comunidad_indigena
                $datos[15], // comunidad_indigena_nombre
                $evento_id  // SIEMPRE el evento activo
            );

            if ($stmt->execute()) {
                $insertados++;
            } else {
                $errores[] = "Error al insertar folio {$datos[0]}: " . $stmt->error;
            }
            $stmt->close();
        }

        fclose($handle);
        $conn->close();

        if (count($errores) > 0) {
            return ['success' => true, 'insertados' => $insertados, 'errores' => $errores];
        } else {
            return ['success' => true, 'insertados' => $insertados];
        }
    }
}