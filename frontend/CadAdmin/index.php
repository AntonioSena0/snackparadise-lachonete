<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snack Paradise - Admin</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../imgs/Logo.png" type="image/x-icon">
</head>
<body>
    <header>
        <div class="header-left">
            <button class="btn-menu-lateral" id="btnMenuLateral">☰</button>
            <div class="logo-container">
            <a href="../Cardápio/index.php" class="logo">
                    <img src="../imgs/Logo.png" class="logo" alt="Snack Paradise Logo">
                </a>           
             </div>
        </div>
    <div class="header-center">
            <a href="../Cardápio/index.php" class="menu-item">Menu</a>
            <div class="menu-item cardapio-btn" id="cardapioBtn">
                Cardápio
                <div class="submenu" id="submenu">
                    <a href="../Cardápio/menu.php#subheader2" class="submenu-item">Hambúrgueres</a>
                    <a href="../Cardápio/menu.php#acompanhamentos" class="submenu-item">Acompanhamentos</a>
                    <a href="../Cardápio/menu.php#bebidas" class="submenu-item">Bebidas</a>
                </div>
            </div>
            <a href="../Acumular Pontos/pontos.html" class="menu-item">Promoções</a>
            <a href="../Quem Somos/index.php" class="menu-item">Sobre Nós</a>
        </div>

        <a href="../PerfilUser/index.php" class="btn-conta">Conta</a>
    </header>

    <!-- Menu Lateral -->
    <nav class="menu-lateral" id="menuLateral">
        <a href="../Cardápio/index.php" class="menu-lateral-item">Início</a>
        <a href="../PerfilUser/index.php" class="menu-lateral-item">Perfil</a>
        <a href="../Acumular Pontos/pontos.html" class="menu-lateral-item active">Pontos</a>
        <a href="../SejaParceiro/index.php" class="menu-lateral-item">Seja Parceiro</a>
    <a href="../Feedback/index.php" class="menu-lateral-item">Avaliações</a>
    <a href="../Quem somos/index.php" class="menu-lateral-item">Sobre nós</a>
    <a href="../Duvidas/index.php" class="menu-lateral-item">Dúvidas</a>
    <a href="../Auxílio Preferencial/auxilio.php" class="menu-lateral-item">Auxílio Preferencial</a>
    </nav>

    <main>
        <div class="main-container">
            <div class="box">
                <div class="forms">
                    <form autocomplete="off" class="Entrar-Form" method="POST" action="../../backend/controllers/login_admin.php">
                        <div class="logo2">
                            <img src="../imgs/Logo.png" alt="SnackParadiseLogo">
                            <h4>SnackParadise</h4>
                        </div>
                        <div id="loginForm" class="txt-inicial">
                            <h2>Acesso Restrito</h2>
                        </div>
                        <div class="form-atual">
                           <div class="input-wrap">
                                <input type="text" minlength="4" class="input-field" autocomplete="off" id="loginUsername" name="username" required/>
                                <label>Nome de Usuário</label>
                            </div>
                            <div class="input-wrap">
                                <input type="password" minlength="4" class="input-field" autocomplete="off" id="loginPassword" name="password" required/>
                                <label>Senha</label>
                            </div>
                            
                            <div class="error-message" style="color: red; text-align: center;">
                                <?php
                                if (isset($_SESSION['login_error'])) {
                                    echo htmlspecialchars($_SESSION['login_error']);
                                    unset($_SESSION['login_error']);
                                }
                                ?>
                            </div>
                            <input type="submit" value="Entrar" class="botao-login" />
                            <p class="txt">
                                Esqueceu a senha?
                                <a href="#">Obter ajuda</a> para iniciar sessão
                            </p>
                        </div>
                    </form>
                </div>
                <div class="carrossel">
                    <div class="imagens">
                        <img src="../imgs/Slider-Login/1.png" class="imagem img-1 mostrar" alt="Sobre nós">
                        <img src="../imgs/Slider-Login/2.png" class="imagem img-2" alt="Junte se a nós">
                        <img src="../imgs/Slider-Login/3.png" class="imagem img-3" alt="Tenha a melhor experiência">
                        <div class="bullets">
                            <span class="active" data-value="1"></span>
                            <span data-value="2"></span>
                            <span data-value="3"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <div class="footer-container">
            <div class="footer-links">
                <a href="../Menu/index.php">Início</a>
                <a href="../Quem somos/index.php">Sobre</a>
                <a href="../Auxílio Preferencial/auxilio.php">Serviços</a>
                <a href="https://www.instagram.com/_snackparadise_/profilecard/?igsh=OHh2eWpsOXBuOWRp">Contato</a>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 SnackParadise. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>
    <div vw class="enabled">
        <div vw-access-button class="active"></div>
        <div vw-plugin-wrapper>
            <div class="vw-plugin-top-wrapper"></div>
        </div>
    </div>
    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <script>
        new window.VLibras.Widget('https://vlibras.gov.br/app');
    </script>
    <script src="menu.js"></script>
    <script>
        const loginForm = document.querySelector('.Entrar-Form');
        loginForm.addEventListener('submit', function (event) {
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;
            if (!email || !password) {
                event.preventDefault();
                document.getElementById('loginError').style.display = 'block';
            }
        });
    </script>
    <style>
        .motoboy-section {
            text-align: center;
            margin-top: 20px;
        }
        .btn-motoboy {
            display: inline-block;
            background-color: #a20908;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1rem;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .btn-motoboy:hover {
            background-color: #FF3131;
            transform: scale(1.05);
        }
    </style>
</body>
</html>
