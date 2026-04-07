let csrfToken = null;

async function login() {
    const login = document.getElementById("login").value;
    const password = document.getElementById("password").value;

    const res = await fetch('/api/login.php', {
        method: 'POST',
        credentials: 'include', // важно для сессий
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ login, password })
    });

    const data = await res.json();

    if (data.csrf_token) {
        csrfToken = data.csrf_token;

        // сохраняем CSRF токен
        localStorage.setItem("csrf_token", csrfToken);

        window.location.href = "tests.html";
    } else {
        document.getElementById("msg").innerText = "Ошибка входа";
    }
}
