<?php
require_once "../config/db.php";

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->login, $data->password)) {
    echo json_encode(["error" => "Invalid input"]);
    exit;
}

// Поиск пользователя
$stmt = $conn->prepare("SELECT * FROM users WHERE login = ?");
$stmt->execute([$data->login]);

$user = $stmt->fetch();

if ($user && password_verify($data->password, $user['password'])) {

    // Защита от фиксации сессии
    session_regenerate_id(true);

    // Сохраняем пользователя в сессии
    $_SESSION['user_id'] = $user['id'];

    // Генерация CSRF токена
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    echo json_encode([
        "message" => "Success",
        "csrf_token" => $_SESSION['csrf_token']
    ]);

} else {
    echo json_encode(["error" => "Invalid credentials"]);
}
?>
