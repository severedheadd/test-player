let answers = {};

async function loadQuestions() {
    const test_id = localStorage.getItem("test_id");

    const res = await fetch(`/api/get_questions.php?test_id=${test_id}`, {
        credentials: 'include'
    });

    const data = await res.json();

    // если не авторизован
    if (data.error) {
        window.location.href = "index.html";
        return;
    }

    const container = document.getElementById("questions");
    container.innerHTML = "";

    data.forEach(q => {
        const div = document.createElement("div");

        div.innerHTML = `<h3>${q.question}</h3>`;

        q.answers.forEach(a => {
            const label = document.createElement("label");

            const input = document.createElement("input");
            input.type = "radio";
            input.name = "q" + q.question_id;
            input.value = a.id;

            input.onclick = () => {
                answers[q.question_id] = a.id;
            };

            label.appendChild(input);
            label.append(" " + a.text);

            div.appendChild(label);
            div.appendChild(document.createElement("br"));
        });

        container.appendChild(div);
    });
}

async function submitTest() {
    const test_id = localStorage.getItem("test_id");
    const csrf_token = localStorage.getItem("csrf_token");

    const res = await fetch('/api/submit_test.php', {
        method: 'POST',
        credentials: 'include',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            test_id,
            answers,
            csrf_token
        })
    });

    const result = await res.json();

    if (result.error) {
        document.getElementById("result").innerText = "Ошибка отправки";
        return;
    }

    document.getElementById("result").innerText =
        `Результат: ${result.score} / ${result.total}`;
}

loadQuestions();
