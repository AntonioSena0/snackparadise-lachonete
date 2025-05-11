document.addEventListener('DOMContentLoaded', async () => {
    const token = localStorage.getItem('token');

    if (!token) {
        alert('Você precisa estar logado para acessar esta página.');
        window.location.href = '../Tela de login/index.html';
        return;
    }

    const response = await fetch('http://localhost/snack-paradise/profile.php', {
        method: 'GET',
        headers: { Authorization: token }
    });

    const data = await response.json();

    if (data.username) {
        document.getElementById('profile').innerHTML = `
            <h1>Bem-vindo, ${data.username}</h1>
            <p>Email: ${data.email}</p>
        `;
    } else {
        alert(data.message);
        window.location.href = '../Tela de login/index.html';
    }
});

const registerForm = document.getElementById('registerForm');

registerForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    const response = await fetch('http://localhost/snack-paradise/register.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username, email, password })
    });

    const data = await response.json();
    alert(data.message);
});

const loginForm = document.getElementById('loginForm');

loginForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;

    const response = await fetch('http://localhost/snack-paradise/login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password })
    });

    const data = await response.json();
    if (data.token) {
        localStorage.setItem('token', data.token);
        alert('Login realizado com sucesso!');
        window.location.href = '../Perfil/index.html';
    } else {
        alert(data.message);
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('login');
    const registerForm = document.getElementById('register');
    const profileSection = document.getElementById('profile');
    const loginFormContainer = document.getElementById('loginForm');
    const registerFormContainer = document.getElementById('registerForm');

    // Verificar se o usuário já está logado
    const token = localStorage.getItem('token');
    if (token) {
        loadProfile(token);
    }

    // Função para carregar o perfil
    async function loadProfile(token) {
        try {
            const response = await fetch('http://localhost/snack-paradise/perfil.php', {
                method: 'GET',
                headers: { Authorization: token }
            });

            const data = await response.json();

            if (data.username) {
                document.getElementById('usernameDisplay').textContent = data.username;
                document.getElementById('emailDisplay').textContent = data.email;

                // Mostrar a seção de perfil e esconder os formulários
                profileSection.style.display = 'block';
                loginFormContainer.style.display = 'none';
                registerFormContainer.style.display = 'none';
            } else {
                alert(data.message);
                localStorage.removeItem('token');
            }
        } catch (error) {
            console.error('Erro ao carregar o perfil:', error);
        }
    }

    // Lógica de login
    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const email = document.getElementById('loginEmail').value;
        const password = document.getElementById('loginPassword').value;

        try {
            const response = await fetch('http://localhost/snack-paradise/login.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email, password })
            });

            const data = await response.json();

            if (data.token) {
                localStorage.setItem('token', data.token);
                alert('Login realizado com sucesso!');
                loadProfile(data.token);
            } else {
                alert(data.message);
            }
        } catch (error) {
            console.error('Erro ao fazer login:', error);
        }
    });

    // Lógica de cadastro
    registerForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const username = document.getElementById('username').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        try {
            const response = await fetch('http://localhost/snack-paradise/register.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ username, email, password })
            });

            const data = await response.json();

            if (response.ok) {
                alert('Cadastro realizado com sucesso!');
                loginFormContainer.style.display = 'block';
                registerFormContainer.style.display = 'none';
            } else {
                alert(data.message || 'Erro ao cadastrar. Tente novamente.');
            }
        } catch (error) {
            console.error('Erro ao cadastrar:', error);
        }
    });
});