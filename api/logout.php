<?php
require_once "../config/security.php";

// Очистка сессии
$_SESSION = [];

// Уничтожение cookie сессии
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"] ?? '',
        $params["secure"],
        $params["httponly"]
    );
}

// Уничтожение сессии
session_destroy();

echo json_encode(["message" => "Logged out"]);
?>
