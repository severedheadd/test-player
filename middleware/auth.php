<?php
require_once "../config/security.php";

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "error" => "Unauthorized"
    ]);
    exit;
}
?>
