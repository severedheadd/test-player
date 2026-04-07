async function register() {
    const login = document.getElementById("login").value;
    const password = document.getElementById("password").value;

    const res = await fetch('/api/register.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ login, password })
    });

    const data = await res.json();

    if (data.error) {
        document.getElementById("msg").innerText = data.error;
        return;
    }

    // авто-вход
    window.location.href = "tests.html";
}
