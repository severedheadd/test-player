<?php
require_once "security.php";

// получаем переменные окружения
$host = getenv('MYSQLHOST');
$db_name = getenv('MYSQLDATABASE');
$username = getenv('MYSQLUSER');
$password = getenv('MYSQLPASSWORD');
$port = getenv('MYSQLPORT');

try {
    $conn = new PDO(
        "mysql:host=$host;port=$port;dbname=$db_name;charset=utf8mb4",
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
