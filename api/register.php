<?php
require_once "../config/db.php";

session_start();

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->login, $data->password)) {
    echo json_encode(["error" => "Invalid input"]);
    exit;
}

if (strlen($data->login) < 3 || strlen($data->password) < 5) {
    echo json_encode(["error" => "Login or password too short"]);
    exit;
}

// проверка существования
$stmt = $conn->prepare("SELECT id FROM users WHERE login = ?");
$stmt->execute([$data->login]);

if ($stmt->fetch()) {
    echo json_encode(["error" => "User already exists"]);
    exit;
}

// хешируем пароль
$hash = password_hash($data->password, PASSWORD_DEFAULT);

// создаём пользователя
$stmt = $conn->prepare("INSERT INTO users (login, password) VALUES (?, ?)");
$stmt->execute([$data->login, $hash]);

$user_id = $conn->lastInsertId();

// авто-логин
$_SESSION['user_id'] = $user_id;

echo json_encode(["success" => true]);
?>
