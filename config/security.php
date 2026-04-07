<?php
// Тип ответа
header("Content-Type: application/json");

// CORS (важно для работы в браузере)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");

// Настройки cookie для сессии
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'httponly' => true,   // защита от JS-доступа
    'secure' => true,     // обязательно для HTTPS (Railway)
    'samesite' => 'None'  // нужно для работы cookies
]);

// Запуск сессии
session_start();

// Хранение сессий во временной папке (важно для Railway)
ini_set('session.save_path', '/tmp');
?>
