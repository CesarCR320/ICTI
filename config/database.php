<?php
/**
 * Retorna una nueva conexión mysqli a la base de datos.
 * Debe llamarse SIEMPRE que se requiera conexión desde un controlador.
 */
function getDatabaseConnection() {
    $host = 'localhost';
    $user = 'root';
    $password = ''; // Cambia si usas otra contraseña
    $database = 'icti';

    $conn = new mysqli($host, $user, $password, $database);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    $conn->set_charset('utf8');
    return $conn;
}
?>