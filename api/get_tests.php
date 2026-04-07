<?php
require_once "../middleware/auth.php";
require_once "../config/db.php";

// Получение списка тестов
$stmt = $conn->query("SELECT id, title, description FROM tests");

$tests = $stmt->fetchAll();

echo json_encode($tests);
?>
