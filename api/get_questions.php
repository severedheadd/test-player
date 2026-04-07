<?php
require_once "../middleware/auth.php";
require_once "../config/db.php";

// Получаем и валидируем test_id
$test_id = filter_input(INPUT_GET, 'test_id', FILTER_VALIDATE_INT);

if (!$test_id) {
    echo json_encode(["error" => "Invalid test_id"]);
    exit;
}

// Запрос вопросов и ответов
$stmt = $conn->prepare("
SELECT q.id as question_id, q.question_text, q.type,
       a.id as answer_id, a.answer_text
FROM questions q
JOIN answers a ON q.id = a.question_id
WHERE q.test_id = ?
");

$stmt->execute([$test_id]);
$data = $stmt->fetchAll();

$result = [];

foreach ($data as $row) {
    $qid = $row['question_id'];

    if (!isset($result[$qid])) {
        $result[$qid] = [
            "question_id" => $qid,
            "question" => htmlspecialchars($row['question_text']),
            "type" => $row['type'],
            "answers" => []
        ];
    }

    $result[$qid]["answers"][] = [
        "id" => $row['answer_id'],
        "text" => htmlspecialchars($row['answer_text'])
    ];
}

// Возвращаем в JSON
echo json_encode(array_values($result));
?>
