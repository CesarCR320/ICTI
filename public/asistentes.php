<?php
require_once __DIR__ . '/../app/controllers/AttendanceController.php';

$controller = new AttendanceController();
$controller->showList();
?>