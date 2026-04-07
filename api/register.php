<?php
require_once "../config/db.php";

$data = json_decode(file_get_contents("php://input"));

// Проверка входных данных
if (!isset($data->login, $data->password)) {
    echo json_encode(["error" => "Invalid input"]);
    exit;
}

// Валидация
if (strlen($data->login) < 3 || strlen($data->password) < 5) {
    echo json_encode(["error" => "Login or password too short"]);
    exit;
}

// Проверка на существующего пользователя
$stmt = $conn->prepare("SELECT id FROM users WHERE login = ?");
$stmt->execute([$data->login]);

if ($stmt->fetch()) {
    echo json_encode(["error" => "User already exists"]);
    exit;
}

// Хеширование пароля
$hash = password_hash($data->password, PASSWORD_DEFAULT);

// Создание пользователя
$stmt = $conn->prepare("INSERT INTO users (login, password) VALUES (?, ?)");
$stmt->execute([$data->login, $hash]);

echo json_encode(["message" => "User registered"]);
?>
