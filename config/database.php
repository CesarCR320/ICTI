<?php
function getDatabaseConnection() {
    $host = 'localhost';
    $user = 'root'; // Cambia si tu usuario/contraseña son diferentes
    $pass = '';
    $db = 'icti';
    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        die('Error de conexión: ' . $conn->connect_error);
    }
    $conn->set_charset('utf8');
    return $conn;
}
?>