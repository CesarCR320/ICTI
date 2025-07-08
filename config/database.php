<?php
$host = 'localhost';
$user = 'root';
$password = ''; // En XAMPP suele estar en blanco
$database = 'icti';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>