<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Motoboy - Snack Paradise</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../img's/Logo.png" type="image/x-icon">
</head>
<body>
    <header id="header">
        <div class="container">
            <div class="flex">
                <nav>
                    <ul>
                        <li class="list-menu2">
                            <button class="btn-ativação" id="btn-ativação">☰</button>
                            <div class="barralateral" id="barralateral">
                                <a href="../Menu/index.html" target="_self">Início</a>
                                <a href="../Perfil/index.html" target="_self">Perfil</a>
                                <a href="#" target="_self">Pontos</a>
                                <a href="#" target="_self">Seja Parceiro</a>
                                <a href="#" target="_self">Avaliações</a>
                                <a href="../Quem somos/index.html" target="_self">Sobre nós</a>
                                <a href="../Auxílio Preferencial/auxilio.html" target="_self">Auxílio Preferencial</a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <div class="btn-conta">
                    <a href="../Tela de login/index.html"><button id="btn-conta" class="conta">Conta</button></a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="main-container">
            <div class="box">
                <div class="forms">
                    <form autocomplete="off" class="Cadastrar-Motoboy-Form" method="POST" action="../../backend/controllers/registro_motoboy.php">
                        <div class="logo2">
                            <img src="../imgs/Logo.png" alt="SnackParadiseLogo">
                            <h4>SnackParadise</h4>
                        </div>
                        <div class="txt-inicial">
                            <h2>Cadastro de Motoboy</h2>
                            <h6>Já tem uma conta?</h6>
                            <a href="index.php" class="toggle">Entrar</a>
                        </div>
                        <div class="form-atual">
                            <div class="input-wrapper">
                                <input type="text" name="motoboy_name" id="motoboy_name" required>
                                <label for="motoboy_name">Nome do Motoboy</label>
                            </div>
                            <div class="input-wrapper">
                                <input type="email" name="email" id="email" required>
                                <label for="email">E-mail</label>
                            </div>
                            <div class="input-wrapper">
                                <input type="password" name="senha" id="senha" required>
                                <label for="senha">Senha</label>
                            </div>
                            <div class="input-wrapper">
                                <input type="text" name="vehicle_type" id="vehicle_type" required>
                                <label for="vehicle_type">Tipo de Veículo</label>
                            </div>
                            <div class="input-wrapper">
                                <input type="text" name="license_plate" id="license_plate" required>
                                <label for="license_plate">Placa do Veículo</label>
                            </div>
                            <button type="submit" class="btn-submit">Cadastrar</button>
                            <p class="toggle-text">Já tem uma conta? <a href="index.php" class="toggle">Entrar</a></p>
                        </div>
                    </form>
                </div>
                <div class="img-container">
                    <img src="../imgs/motoboy.png" alt="Motoboy Image">
                </div>
            </div>
        </div>
    </main>
    <footer>
        <div class="footer-container">
            <p>&copy; 2023 Snack Paradise. Todos os direitos reservados.</p>
        </div>
    </footer>
    <script src="menu.js"></script>
</body>
</html>
<script>
    document.getElementById('btn-ativação').addEventListener('click', function() {
        const barralateral = document.getElementById('barralateral');
        barralateral.classList.toggle('active');
    });
    document.querySelector('.toggle').addEventListener('click', function() {
        const form = document.querySelector('.Cadastrar-Motoboy-Form');
        form.classList.toggle('active');
    });
    document.querySelector('.toggle-text a').addEventListener('click', function(event) {
        event.preventDefault();
        const form = document.querySelector('.Cadastrar-Motoboy-Form');
        form.classList.toggle('active');
    });
    document.querySelector('.btn-ativação').addEventListener('click', function() {
        const barralateral = document.getElementById('barralateral');
        barralateral.classList.toggle('active');
    });
    document.querySelector('.barralateral').addEventListener('click', function(event) {
        event.stopPropagation();
    });
    document.addEventListener('click', function(event) {
        const barralateral = document.getElementById('barralateral');
        if (!barralateral.contains(event.target) && !event.target.matches('.btn-ativação')) {
            barralateral.classList.remove('active');
        }
    });
    document.querySelector('.Cadastrar-Motoboy-Form').addEventListener('submit', function(event) {
        const motoboyName = document.getElementById('motoboy_name').value;
        const email = document.getElementById('email').value;
        const senha = document.getElementById('senha').value;
        const vehicleType = document.getElementById('vehicle_type').value;
        const licensePlate = document.getElementById('license_plate').value;

        if (!motoboyName || !email || !senha || !vehicleType || !licensePlate) {
            event.preventDefault();
            alert('Por favor, preencha todos os campos.');
        }
    });
    document.querySelector('.Cadastrar-Motoboy-Form').addEventListener('input', function() {
        const motoboyName = document.getElementById('motoboy_name').value;
        const email = document.getElementById('email').value;
        const senha = document.getElementById('senha').value;
        const vehicleType = document.getElementById('vehicle_type').value;
        const licensePlate = document.getElementById('license_plate').value;

        if (motoboyName && email && senha && vehicleType && licensePlate) {
            document.querySelector('.btn-submit').disabled = false;
        } else {
            document.querySelector('.btn-submit').disabled = true;
        }
    });
    document.querySelector('.btn-submit').disabled = true; // Disable button initially
    document.querySelector('.Cadastrar-Motoboy-Form').addEventListener('input', function() {
        const motoboyName = document.getElementById('motoboy_name').value;
        const email = document.getElementById('email').value;
        const senha = document.getElementById('senha').value;
        const vehicleType = document.getElementById('vehicle_type').value;
        const licensePlate = document.getElementById('license_plate').value;

        if (motoboyName && email && senha && vehicleType && licensePlate) {
            document.querySelector('.btn-submit').disabled = false;
        } else {
            document.querySelector('.btn-submit').disabled = true;
        }
    });
</script>
