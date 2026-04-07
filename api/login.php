<?php
require_once "../config/db.php";

session_start();

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

    // защита от фиксации сессии
    session_regenerate_id(true);

    // сохраняем пользователя
    $_SESSION['user_id'] = $user['id'];

    // CSRF токен
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    echo json_encode([
        "message" => "Success",
        "csrf_token" => $_SESSION['csrf_token']
    ]);

} else {
    echo json_encode(["error" => "Invalid credentials"]);
}
?>
