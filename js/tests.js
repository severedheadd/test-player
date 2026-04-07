async function loadTests() {
    const res = await fetch('/api/get_tests.php', {
        credentials: 'include'
    });

    const data = await res.json();

    // если не авторизован → назад на логин
    if (data.error) {
        window.location.href = "index.html";
        return;
    }

    const container = document.getElementById("tests");

    data.forEach(test => {
        const div = document.createElement("div");

        div.innerHTML = `
            <h3>${test.title}</h3>
            <p>${test.description}</p>
            <button onclick="startTest(${test.id})">Начать</button>
        `;

        container.appendChild(div);
    });
}

function startTest(id) {
    localStorage.setItem("test_id", id);
    window.location.href = "test.html";
}

loadTests();
