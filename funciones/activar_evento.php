<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['evento_id'])) {
    $evento_id = intval($_POST['evento_id']);

    $conn->query("UPDATE eventos SET activo = 0");

    $stmt = $conn->prepare("UPDATE eventos SET activo = 1 WHERE id = ?");
    $stmt->bind_param("i", $evento_id);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    header("Location: ../index.php");
    exit;
}
?>
