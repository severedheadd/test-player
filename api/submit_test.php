<?php
require_once "../middleware/auth.php";
require_once "../config/db.php";

$data = json_decode(file_get_contents("php://input"));

// Проверка CSRF
if (!isset($data->csrf_token) || $data->csrf_token !== $_SESSION['csrf_token']) {
    echo json_encode(["error" => "CSRF validation failed"]);
    exit;
}

// Получаем данные
$user_id = $_SESSION['user_id'];
$test_id = (int)$data->test_id;
$answers = $data->answers;

if (!$test_id || !is_array($answers)) {
    echo json_encode(["error" => "Invalid data"]);
    exit;
}

// Подсчёт баллов

$score = 0;
$total = 0;

foreach ($answers as $question_id => $answer_value) {

    if (is_array($answer_value)) {
        // multiple
        foreach ($answer_value as $answer_id) {
            $stmt = $conn->prepare("SELECT is_correct FROM answers WHERE id = ?");
            $stmt->execute([$answer_id]);
            $row = $stmt->fetch();

            if ($row && $row['is_correct']) {
                $score++;
            }
            $total++;
        }
    } else {
        // single
        $stmt = $conn->prepare("SELECT is_correct FROM answers WHERE id = ?");
        $stmt->execute([$answer_value]);
        $row = $stmt->fetch();

        if ($row && $row['is_correct']) {
            $score++;
        }
        $total++;
    }
}

// Запись результата
$stmt = $conn->prepare("
INSERT INTO results (user_id, test_id, score, total_questions)
VALUES (?, ?, ?, ?)
");

$total = count($answers);
$stmt->execute([$user_id, $test_id, $score, $total]);

$result_id = $conn->lastInsertId();

// Сохранение ответов пользователя
foreach ($answers as $question_id => $answer_id) {
    $stmt = $conn->prepare("
        INSERT INTO user_answers (result_id, question_id, answer_id)
        VALUES (?, ?, ?)
    ");
    $stmt->execute([$result_id, $question_id, $answer_id]);
}

// Ответ
echo json_encode([
    "score" => $score,
    "total" => $total
]);
?>
