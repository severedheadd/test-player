<?php
require_once "security.php";

// Данные подключения из Railway (переменные окружения)
$host = $_ENV['MYSQLHOST'];
$db_name = $_ENV['MYSQLDATABASE'];
$username = $_ENV['MYSQLUSER'];
$password = $_ENV['MYSQLPASSWORD'];

try {
    $conn = new PDO(
        "mysql:host=$host;dbname=$db_name;charset=utf8",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (Exception $e) {
    echo json_encode(["error" => "DB connection failed"]);
    exit;
}
?>
