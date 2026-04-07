let csrfToken = null;

async function login() {
    const login = document.getElementById("login").value;
    const password = document.getElementById("password").value;

    const res = await fetch('/api/login.php', {
        method: 'POST',
        credentials: 'include',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ login, password })
    });

    const data = await res.json();

    console.log(data); // 🔥 очень важно для отладки

    if (data.csrf_token) {
        csrfToken = data.csrf_token;

        localStorage.setItem("csrf_token", csrfToken);

        window.location.href = "tests.html";
    } else {
        document.getElementById("msg").innerText =
            data.error || "Ошибка входа";
    }
}
